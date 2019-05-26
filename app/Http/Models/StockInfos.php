<?php
namespace App\Http\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class StockInfos extends Model
{
	use Notifiable;

    protected $fillable = [
    		'id', 'stock_id','lot_number','expiry_date','selling_price','unit_price'
    ];

		public $timestamps = false;

		 protected $table = 'stock_infos';

    protected $hidden = [
        'remember_token',
    ];

    public static function getStockInfo($stock_id){
   		$SupplierDetails = SELF::orderBy('id', 'desc')
                          ->where('status' , 1)
													->where('id' , $stock_id)
                          ->first();
      return $SupplierDetails;
    }

		public function addStockInfo($stock_info_details) {
			$stock_id = SELF::create($stock_info_details);
			return $stock_id;
		}

		public function updateStockInfo($stock_info_details, $id)
		{
			SELF::where('id','=', $id)->update($stock_info_details);
			return 1;
		}

		public function deleteStockInfo($stock_info_details)
		{
			SELF::where('id','=', $stock_info_details['id'])->update($stock_info_details);
			return 1;
		}
}
