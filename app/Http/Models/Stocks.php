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
                          ->paginate(5);

      return $StockDetails;
    }

		public static function getStocksAll(){
			$StockDetails = SELF::orderBy('brands.name', 'asc')
													->where('stocks.status' , 1)
													->select('stocks.*','stock_infos.*','stock_infos.id as stock_infos_id', 'stocks.id as stocks_id')
													->leftjoin('stock_infos', 'stocks.id', '=', 'stock_infos.stock_id')
													->leftjoin('brands', 'stocks.brand_id', '=', 'brands.id')
													->get();

			return $StockDetails;
		}

		public static function getStocksOverAll(){
			$StockDetails = SELF::orderBy('brands.name', 'asc')
													->where('stocks.status' , 1)
													->select('stocks.*','stock_infos.*','stock_infos.id as stock_infos_id'
														,'stocks.id as stocks_id', 'brands.name as brand_name')
													->leftjoin('stock_infos', 'stocks.id', '=', 'stock_infos.stock_id')
													->leftjoin('brands', 'stocks.brand_id', '=', 'brands.id')
													->paginate(50);
			return $StockDetails;
		}

		public static function checkDuplicate($stock_details){
			$StockDetails = SELF::where('brand_id' , $stock_details['brand_id'])
													->where('category_id' , $stock_details['category_id'])
													->where('supplier_id' , $stock_details['supplier_id'])
													->where('generic_id' , $stock_details['generic_id'])
													->where('size' , $stock_details['size'])
													->where('status' , 1)
													->first();

			if(!empty($StockDetails)) {
				return true;
			}
			return false;
		}

		public static function getSupplierList(){
			$supplier_list = DB::table('suppliers')
					->orderBy('created_at', 'desc')
					->where('status', 1)
					->pluck('name', 'id');

			return $supplier_list;
		}

		public static function getBrandList(){
			$brand_list = DB::table('brands')
					->orderBy('created_at', 'desc')
					->where('status', 1)
					->pluck('name', 'id');

			return $brand_list;
		}

		public static function getBrandListAll(){
			$brand_list = DB::table('brands')
					->orderBy('created_at', 'desc')
					->pluck('name', 'id');

			return $brand_list;
		}

		public static function getCategoryList(){
			$category_list = DB::table('categories')
					->orderBy('created_at', 'desc')
					->where('status', 1)
					->pluck('name', 'id');

			return $category_list;
		}

		public static function getGenericList(){
			$generic_list = DB::table('generics')
					->orderBy('created_at', 'desc')
					->where('status', 1)
					->pluck('name', 'id');

			return $generic_list;
		}

		public static function getGenericListAll(){
			$generic_list = DB::table('generics')
					->orderBy('created_at', 'desc')
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

		public function collection()
		{
				return SELF::all();
		}

		public static function getStocksExport(){
			$StockDetails = SELF::orderBy('brands.name', 'asc')
					->where('stocks.status' , 1)
					->select('stocks.id',
									'stocks.stock_num',
									'brands.name as brand_name',
									'categories.name as category_name',
									'generics.name as generic_name',
									'suppliers.name as supplier_name',
									'stocks.size',
									'stock_infos.unit_price',
									'stock_infos.selling_price',
									'stock_infos.expiry_date'
									)
					->leftjoin('stock_infos', 'stocks.id', '=', 'stock_infos.stock_id')
					->leftjoin('brands', 'brands.id', '=', 'stocks.brand_id')
					->leftjoin('categories', 'categories.id', '=', 'stocks.category_id')
					->leftjoin('generics', 'generics.id', '=', 'stocks.generic_id')
					->leftjoin('suppliers', 'suppliers.id', '=', 'stocks.supplier_id')
					->get();

			return $StockDetails;
		}

		public static function getSearch($keyword){
			$StockDetails = SELF::orderBy('stocks.id', 'desc')
													->where('stocks.status' , 1)
													->select('stocks.*',
														'stock_infos.*',
														'stock_infos.id as stock_infos_id',
														'stocks.id as stocks_id',
														'brands.name as brand_name')
													->leftjoin('stock_infos', 'stocks.id', '=', 'stock_infos.stock_id')
													->leftjoin('brands', 'stocks.brand_id', '=', 'brands.id')
													->where('brands.name', 'like', '%'.$keyword.'%')
													->paginate(10);

			return $StockDetails;
		}
}
