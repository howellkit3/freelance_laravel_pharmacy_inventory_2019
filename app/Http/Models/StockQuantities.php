<?php
namespace App\Http\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StockQuantities extends Model
{
	use Notifiable;

    protected $fillable = [
         'id', 'stock_id','quantity','type','date_sold','created_by', 'updated_by'
    ];

    protected $hidden = [
        'remember_token',
    ];

    public static function getStockQuantities(){
   		$StockQuantityDetails = DB::table('stock_quantities')
													->orderBy('stock_quantities.id', 'desc')
													->select('stocks.*','stock_quantities.*','stock_quantities.id as stock_quantities_id', 'stocks.id as stocks_id')
													->leftjoin('stocks', 'stocks.id', '=', 'stock_quantities.stock_id')
                          ->paginate(50);

      return $StockQuantityDetails;
    }

		public static function getSoldDates(){
			$StockQuantityDetails = DB::table('stock_quantities')
													->orderBy('stock_quantities.date_sold', 'desc')
													->select('stocks.*','stock_quantities.*','stock_quantities.id as stock_quantities_id', 'stocks.id as stocks_id', 'stock_infos.*')
													->leftjoin('stocks', 'stocks.id', '=', 'stock_quantities.stock_id')
													->leftjoin('stock_infos', 'stock_infos.stock_id', '=', 'stocks.id')
													->where('type', 0)
													->paginate(50);

			return $StockQuantityDetails;
		}

		public function addQuantityToStock($stock_quantity_details)
		{
			$stock_quantity = SELF::create($stock_quantity_details);
			return $stock_quantity->id;
		}

		public function checkDuplicateQuantity($stock_quantity_details)
		{
			$isAlreadyExist = DB::table('stock_quantities')
					->where('stock_id', $stock_quantity_details['stock_id'])
					->where('quantity', $stock_quantity_details['quantity'])
					->where('date_sold', $stock_quantity_details['date_sold'])
					->where('created_at', Carbon::now()->toDateTimeString())
					->first();

			if(!empty($isAlreadyExist)) {
				return true;
			}

			return false;
		}

		public function insertStockQuantity($stocks)
		{
			foreach ($stocks as $key => $value) {
				$adds = DB::table('stock_quantities')
						->where('stock_id', $value->id)
						->where('type', 1)
						->sum('quantity');

				$subtracts = DB::table('stock_quantities')
						->where('stock_id', $value->id)
						->where('type', 0)
						->sum('quantity');

				$available = $adds - $subtracts;

				$stocks[$key]->available = $available;
				$stocks[$key]->quantity_sold = $subtracts;
			}

			return $stocks;
		}

		public function insertStockQuantityExcel($stocks)
		{
			foreach ($stocks as $key => $value) {
				$adds = DB::table('stock_quantities')
						->where('stock_id', $value->id)
						->where('type', 1)
						->sum('quantity');

				$subtracts = DB::table('stock_quantities')
						->where('stock_id', $value->id)
						->where('type', 0)
						->sum('quantity');

				$available = $adds - $subtracts;
				$stocks[$key]->available = $available;
			}

			return $stocks;
		}

		public static function computeProfit($stocks)
		{

			foreach ($stocks as $key => $value) {
				$unit_price = $value->unit_price;
				$selling_price = $value->selling_price;
				$quantity_sold = $value->quantity;
				$profit = ($selling_price * $quantity_sold) - ($unit_price * $quantity_sold);
				$stocks[$key]->profit = $profit;
			}

			return $stocks;
		}

		public static function checkStockAndDateSold($sale_form)
		{
			$isExist = DB::table('stock_quantities')
					->where('date_sold', $sale_form['date_sold'])
					->where('stock_id',  $sale_form['stock_id'])
					->where('type',  0)
					->first();

			return $isExist;
		}

		public static function checkAvailStockQuantity($current_quantity, $quantity)
		{
			if (!empty($current_quantity->stock_id)) {
				$adds = DB::table('stock_quantities')
						->where('stock_id', $current_quantity->stock_id)
						->where('type', 1)
						->sum('quantity');

				$subtracts = DB::table('stock_quantities')
						->where('stock_id', $current_quantity->stock_id)
						->where('type', 0)
						->sum('quantity');


				$available = $adds - $subtracts;

				if($available < $quantity) {
					return false;
				} else {
					return true;
				}
			} else {
				return false;
			}
		}

		public function updateQuantityToStock($quantity_form, $id)
		{

			SELF::where('id',  $id)
						->where('type',  0)
						->update($quantity_form);
			return 1;
		}

		public static function checkIfHasQuantity($id)
		{
			$isExist = DB::table('stock_quantities')
					->where('stock_id', $id)
					->where('type', 1)
					->first();

			return $isExist;
		}

		public static function getStockQuantityByDate($dailySalesList)
		{
			foreach ($dailySalesList as $key => $value) {
				$adds = DB::table('stock_quantities')
						->where('stock_id', $value->stock_id)
						->where('date_sold', '<=' , $value->date_sold)
						->where('type', 1)
						->sum('quantity');

				$substract = DB::table('stock_quantities')
						->where('stock_id', $value->stock_id)
						->where('date_sold', '<=' , $value->date_sold)
						->where('type', '=' , 0)
						->sum('quantity');

				$dailySalesList[$key]->available_stock = $adds - $substract;
				$dailySalesList[$key]->additions = $adds;
				$dailySalesList[$key]->substractions = $substract;
			}

			return $dailySalesList;
		}
}
