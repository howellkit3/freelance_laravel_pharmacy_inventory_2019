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
                          	->paginate(10);

        return $BrandsDetails;
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
