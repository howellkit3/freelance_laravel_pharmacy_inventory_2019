<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\StockQuantities;
use App\Http\Models\Stocks;

class DailySalesController extends Controller
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
    public function showStockQuantities()
    {
      $StockQuantities = new StockQuantities;
      $Stocks = new Stocks;
      $dailySalesList = $StockQuantities->getStockQuantities();
      $brandList = $Stocks->getBrandList();
      $categoryList = $Stocks->getCategoryList();
      $stockList = $Stocks->getStocks();

      //print_r('<pre>');     print_r($dailySalesList); print_r('</pre>'); exit;
      return view('pages.daily_sales.index',compact('dailySalesList', 'brandList', 'categoryList','stockList'));
    }

    public function addDailyStockSale(Request $request)
    {
      if($request->has('_token')) {
        $request->validate([
          'stock_id' => 'required',
          'quantity' => 'required',
          'type' => 'required',
        ]);

        $daily_sales_form = $request->all();
        $daily_sales_details['stock_id'] = $daily_sales_form['stock_id'];
        $daily_sales_details['quantity'] =  $daily_sales_form['quantity'];
        $daily_sales_details['type'] =  0;

        $StockQuantities = new StockQuantities;
        $StockQuantities->addStockSale($daily_sales_details);
      }

      return redirect()->route('daily_sales')->with('success','Stock has been updated!');
    }

    public function updateDailyStockSale(Request $request)
    {
      if($request->has('_token')) {

        $generic_form = $request->all();
        $generic_details['name'] = $generic_form['name'];
        $generic_details['id'] = $generic_form['id'];

        $StockQuantities = new StockQuantities;
        $StockQuantities->updateGeneric($generic_details);
      }
      return redirect()->route('generic')->with('success','Generic has been updated successfully!');
    }

    public function deleteDailyStockSale(Request $request)
    {
      if($request->has('_token')) {
        $generic_form = $request->all();
        $generic_details['id'] = $generic_form['id'];
        $generic_details['status'] = 0;

        $StockQuantities = new StockQuantities;
        $StockQuantities->deleteGeneric($generic_details);
      }
      return redirect()->route('generic')->with('success','Generic has been deleted successfully!');
    }
}
