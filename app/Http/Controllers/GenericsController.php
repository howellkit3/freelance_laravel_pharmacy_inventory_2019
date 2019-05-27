<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\Generics;

class GenericsController extends Controller
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
    public function generics()
    {
      $Generics = new Generics;
      $genericList = $Generics->getGenerics();
      return view('pages.admin.generic',compact('genericList'));
    }

    public function addGeneric(Request $request)
    {
      if($request->has('_token')) {
        $request->validate([
          'name' => 'required|unique:generics',
        ]);

        $generic_form = $request->all();
        $generic_details['name'] = $generic_form['name'];
        $generic_details['status'] = 1;

        $Generics = new Generics;
        $Generics->addGeneric($generic_details);
      }

      return redirect()->route('generic')->with('success','Generic has been added successfully!');
    }

    public function updateGeneric(Request $request)
    {
      if($request->has('_token')) {

        $generic_form = $request->all();
        $generic_details['name'] = $generic_form['name'];
        $generic_details['id'] = $generic_form['id'];

        $Generics = new Generics;
        $Generics->updateGeneric($generic_details);
      }
      return redirect()->route('generic')->with('success','Generic has been updated successfully!');
    }

    public function deleteGeneric(Request $request)
    {
      if($request->has('_token')) {
        $generic_form = $request->all();
        $generic_details['id'] = $generic_form['id'];
        $generic_details['status'] = 0;

        $Generics = new Generics;
        $Generics->deleteGeneric($generic_details);
      }
      return redirect()->route('generic')->with('success','Generic has been deleted successfully!');
    }
}
