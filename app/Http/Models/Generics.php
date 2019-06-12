<?php
namespace App\Http\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Generics extends Model
{
	use Notifiable;

    protected $fillable = [
         'id', 'name','status', 'created_by', 'updated_by'
    ];

    protected $hidden = [
        'remember_token',
    ];

    public static function getGenerics(){
   		$GenericsDetails = SELF::orderBy('id', 'desc')
                          ->where('status' , 1)
                          ->paginate(5);

      return $GenericsDetails;
    }

		public static function getAllGenerics(){
			$generic_list = DB::table('generics')
					->orderBy('created_at', 'desc')
					->pluck('name', 'id');

			return $generic_list;
		}

		public function addGeneric($generic_details) {
			$generic = SELF::create($generic_details);
			return $generic->id;
		}

		public function updateGeneric($generic_details)
		{
			SELF::where('id','=', $generic_details['id'])->update(array('name' => $generic_details['name']));
			return 1;
		}

		public function deleteGeneric($generic_details)
		{
			SELF::where('id','=', $generic_details['id'])->update(array('status' => $generic_details['status']));
			return 1;
		}
}
