<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\Brands;

class BrandsController extends Controller
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
    public function brands()
    {
      $Brands = new Brands;
      $brandList = $Brands->getBrands();
      return view('pages.admin.brand',compact('brandList'));
    }

    public function addBrand(Request $request)
    {
      if($request->has('_token')) {
        $request->validate([
          'name' => 'required|unique:brands',
        ]);

        $brand_form = $request->all();
        $brand_details['name'] = $brand_form['name'];
        $brand_details['status'] = 1;

        $Brands = new Brands;
        $Brands->addBrand($brand_details);
      }

      return redirect()->route('brand')->with('success','Brands has been added successfully!');
    }

    public function updateBrand(Request $request)
    {
      if($request->has('_token')) {

        $brand_form = $request->all();

        $brand_details['name'] = $brand_form['name'];
        $brand_details['id'] = $brand_form['id'];

        $Brands = new Brands;
        $Brands->updateBrand($brand_details);
      }
      return redirect()->route('brand')->with('success','Brands has been updated successfully!');
    }

    public function deleteBrand(Request $request)
    {
      if($request->has('_token')) {
        $brand_form = $request->all();
        $brand_details['id'] = $brand_form['id'];
        $brand_details['status'] = 0;

        $Brands = new Brands;
        $Brands->deleteBrand($brand_details);
      }
      return redirect()->route('brand')->with('success','Brands has been deleted successfully!');
    }
}
