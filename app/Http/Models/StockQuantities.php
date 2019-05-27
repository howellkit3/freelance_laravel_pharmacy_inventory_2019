<?php
namespace App\Http\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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

		public function addQuantityToStock($stock_quantity_details)
		{
			$stock_quantity = SELF::create($stock_quantity_details);
			return $stock_quantity->id;
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

				$stocks[$key]['available'] = $available;
			}

			return $stocks;
		}
}
