<?php
namespace App\Http\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Stocks extends Model
{
	use Notifiable;

    protected $fillable = [
         'id', 'stock_num','supplier_id','brand_id','generic_id','size','category_id','status', 'created_by', 'updated_by'
    ];

    protected $hidden = [
        'remember_token',
    ];

    public static function getStocks(){
   		$StockDetails = SELF::orderBy('stocks.id', 'desc')
                          ->where('stocks.status' , 1)
													->select('stocks.*','stock_infos.*','stock_infos.id as stock_infos_id', 'stocks.id as stocks_id')
													->leftjoin('stock_infos', 'stocks.id', '=', 'stock_infos.stock_id')
                          ->paginate(50);

      return $StockDetails;
    }

		public static function getSupplierList(){
			$supplier_list = DB::table('suppliers')
					->where('status' , 1)
					->pluck('name', 'id');

			return $supplier_list;
		}

		public static function getBrandList(){
			$brand_list = DB::table('brands')
					->where('status' , 1)
					->pluck('name', 'id');

			return $brand_list;
		}

		public static function getCategoryList(){
			$category_list = DB::table('categories')
					->where('status' , 1)
					->pluck('name', 'id');

			return $category_list;
		}

		public static function getGenericList(){
			$generic_list = DB::table('generics')
					->where('status' , 1)
					->pluck('name', 'id');

			return $generic_list;
		}

		public function addStock($stock_details) {
			$stock = SELF::create($stock_details);
			return $stock->id;
		}

		public function updateStock($stock_details, $id)
		{
			SELF::where('id','=', $id)->update($stock_details);
			return 1;
		}

		public function deleteSupplier($stock_details)
		{
			SELF::where('id','=', $stock_details['id'])->update($stock_details);
			return 1;
		}
}
