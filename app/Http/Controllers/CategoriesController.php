<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\Categories;

class CategoriesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function categories()
    {
      $Categories = new Categories;
      $categoryList = $Categories->getCategories();
      return view('pages.admin.category',compact('categoryList'));
    }

    public function addCategory(Request $request)
    {
      if($request->has('_token')) {
        $request->validate([
          'name' => 'required|unique:categories',
        ]);

        $category_form = $request->all();
        $category_details['name'] = $category_form['name'];
        $category_details['status'] = 1;

        $Categories = new Categories;
        $Categories->addCategory($category_details);

        //flash('Category has been Added!')->success()->important();
      }

      return redirect()->route('category');
    }

    public function updateCategory(Request $request)
    {
      if($request->has('_token')) {

        $category_name = $request->all();

        $category_details['name'] = $category_name['name'];
        $category_details['id'] = $category_name['id'];

        $Categories = new Categories;
        $Categories->updateCategory($category_details);
      }
      return redirect()->route('category');
    }

    public function deleteCategory(Request $request)
    {
      if($request->has('_token')) {
        $category_name = $request->all();
        $category_details['id'] = $category_name['id'];
        $category_details['status'] = 0;

        $Categories = new Categories;
        $Categories->deleteCategory($category_details);
      }
      return redirect()->route('category');
    }
}
