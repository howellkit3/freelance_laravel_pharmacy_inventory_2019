<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\Suppliers;

class SuppliersController extends Controller
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
    public function suppliers()
    {
      $Suppliers = new Suppliers;
      $supplierList = $Suppliers->getSuppliers();
      return view('pages.suppliers.index',compact('supplierList'));
    }

    public function addSupplier(Request $request)
    {
      if($request->has('_token')) {
        $request->validate([
          'name' => 'required|unique:suppliers',
        ]);

        $supplier_form = $request->all();
        $supplier_details['name'] = $supplier_form['name'];
        $supplier_details['status'] = 1;
        $Suppliers = new Suppliers;
        $Suppliers->addSupplier($supplier_details)->with('success','Supplier has been added successfully!');
      }

      return redirect()->route('suppliers');
    }

    public function updateSupplier(Request $request)
    {
      if($request->has('_token')) {
        $supplier_form = $request->all();
        $supplier_details['name'] = $supplier_form['name'];
        $supplier_details['id'] = $supplier_form['id'];
        $Suppliers = new Suppliers;
        $Suppliers->updateSupplier($supplier_details);
      }
      return redirect()->route('suppliers')->with('success','Supplier has been updated successfully!');
    }

    public function deleteSupplier(Request $request)
    {
      if($request->has('_token')) {
        $supplier_form = $request->all();
        $supplier_details['id'] = $supplier_form['id'];
        $supplier_details['status'] = 0;

        $Suppliers = new Suppliers;
        $Suppliers->deleteSupplier($supplier_details);
      }
      return redirect()->route('suppliers')->with('success','Supplier has been deleted successfully!');
    }
}
