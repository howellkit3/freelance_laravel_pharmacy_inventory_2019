<?php
namespace App\Http\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class StockQuantities extends Model
{
	use Notifiable;

    protected $fillable = [
         'id', 'stock_id','quantity','type','created_by', 'updated_by'
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

		public function addGeneric($stock_quantity_details) {
			$stock_quantity = SELF::create($stock_quantity_details);
			return $stock_quantity->id;
		}

		public function updateGeneric($stock_quantity_details)
		{
			SELF::where('id','=', $stock_quantity_details['id'])->update(array('name' => $stock_quantity_details['name']));
			return 1;
		}

		public function deleteGeneric($stock_quantity_details)
		{
			SELF::where('id','=', $stock_quantity_details['id'])->update(array('status' => $stock_quantity_details['status']));
			return 1;
		}
}
