<?php
namespace App\Http\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Categories extends Model
{
	use Notifiable;

    protected $fillable = [
         'id', 'name','status', 'created_by', 'updated_by'
    ];

    protected $hidden = [
        'remember_token',
    ];

    public static function getCategories(){

   		$CategoriesDetails = SELF::orderBy('id', 'desc')
                           ->where('status' , 1)
                          	->paginate(5);

        return $CategoriesDetails;
    }

		public function addCategory($category_details) {
			$category = SELF::create($category_details);
			return $category->id;
		}

		public function updateCategory($category_details)
		{
			SELF::where('id','=', $category_details['id'])->update(array('name' => $category_details['name']));
			return 1;
		}

		public function deleteCategory($category_details)
		{
			SELF::where('id','=', $category_details['id'])->update(array('status' => $category_details['status']));
			return 1;
		}
}
