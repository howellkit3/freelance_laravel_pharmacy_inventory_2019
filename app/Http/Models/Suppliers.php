<?php
namespace App\Http\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Suppliers extends Model
{
	use Notifiable;

    protected $fillable = [
         'id', 'name','status', 'created_by', 'updated_by'
    ];

    protected $hidden = [
        'remember_token',
    ];

    public static function getSuppliers(){
   		$SupplierDetails = SELF::orderBy('id', 'desc')
                          ->where('status' , 1)
                          ->paginate(10);

      return $SupplierDetails;
    }

		public function addSupplier($supplier_details) {
			$supplier = SELF::create($supplier_details);
			return $supplier->id;
		}

		public function updateSupplier($supplier_details)
		{
			SELF::where('id','=', $supplier_details['id'])->update(array('name' => $supplier_details['name']));
			return 1;
		}

		public function deleteSupplier($supplier_details)
		{
			SELF::where('id','=', $supplier_details['id'])->update(array('status' => $supplier_details['status']));
			return 1;
		}
}
