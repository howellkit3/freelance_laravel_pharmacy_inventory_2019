<?php
namespace App\Http\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Brands extends Model
{
	use Notifiable;

    protected $fillable = [
         'id', 'name','status', 'created_by', 'updated_by'
    ];

    protected $hidden = [
        'remember_token',
    ];

    public static function getBrands(){

   		$BrandsDetails = SELF::orderBy('id', 'desc')
                           ->where('status' , 1)
                          	->paginate(5);

        return $BrandsDetails;
    }

		public static function getAllBrands(){

			$brand_list = DB::table('brands')
					->orderBy('created_at', 'desc')
					->pluck('name', 'id');

				return $brand_list;
		}

		public function addBrand($brand_details) {
			$brand = SELF::create($brand_details);
			return $brand->id;
		}

		public function updateBrand($brand_details)
		{
			SELF::where('id','=', $brand_details['id'])->update(array('name' => $brand_details['name']));
			return 1;
		}

		public function deleteBrand($brand_details)
		{
			SELF::where('id','=', $brand_details['id'])->update(array('status' => $brand_details['status']));
			return 1;
		}
}
