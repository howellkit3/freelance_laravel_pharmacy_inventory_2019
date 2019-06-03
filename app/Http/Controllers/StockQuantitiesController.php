<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\StockQuantities;
use App\Http\Models\Stocks;

class StockQuantitiesController extends Controller
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

    public function addQuantity(Request $request)
    {
      if($request->has('_token')) {
        $request->validate([
          'stocks_id' => 'required',
          'quantity' => 'required|integer|min:0',
          'date_sold' => 'required',
        ]);
        $stock_quantity_form = $request->all();
        $stock_quantity_details['stock_id'] = $stock_quantity_form['stocks_id'];
        $stock_quantity_details['quantity'] = $stock_quantity_form['quantity'];
        $stock_quantity_details['date_sold'] = $stock_quantity_form['date_sold'];

        $StockQuantities = new StockQuantities;
        $dailySalesList = $StockQuantities->addQuantityToStock($stock_quantity_details);

        return redirect()->route('stocks')->with('success','Stock Quantity has been updated successfully!');
      }

      return view('pages.daily_sales.index',compact('dailySalesList', 'brandList', 'categoryList','stockList'));
    }

    public function addSale(Request $request)
    {
      if($request->has('_token')) {
        $stock_quantity_form = $request->all();
        $request->validate([
          'stock_id' => 'required',
          'quantity' => 'required|integer|min:0',
          'date_sold' => 'required',
        ]);

        $stock_quantity_form = $request->all();
        $StockQuantities = new StockQuantities;
        $currentQuantity = $StockQuantities->checkStockAndDateSold($stock_quantity_form);

        $isValid = $StockQuantities->checkAvailStockQuantity($currentQuantity, $stock_quantity_form['quantity']);

        if(!$isValid && !empty($currentQuantity)) {
          return redirect()->route('stocks')->with('error','Check Item Quantity');
        }

        if ($currentQuantity) {
          $stock_quantity_details['quantity'] = $currentQuantity->quantity + $stock_quantity_form['quantity'];
          $stock_quantity_details['date_sold'] = $stock_quantity_form['date_sold'];
          $dailySalesList = $StockQuantities->updateQuantityToStock($stock_quantity_details, $currentQuantity->id);
          return redirect()->route('stocks')->with('success','Stock Quantity has been updated successfully!');
        } else {
          $stock_quantity_details['stock_id'] = $stock_quantity_form['stock_id'];
          $stock_quantity_details['quantity'] = $stock_quantity_form['quantity'];
          $stock_quantity_details['date_sold'] = $stock_quantity_form['date_sold'];
          $stock_quantity_details['type'] = 0;

          $hasQuantity = $StockQuantities->checkIfHasQuantity($stock_quantity_details['stock_id']);

          if(!empty($hasQuantity)) {
            $dailySalesList = $StockQuantities->addQuantityToStock($stock_quantity_details);
            return redirect()->route('stocks')->with('success','Stock Quantity has been updated successfully!');
          }else{
            return redirect()->route('stocks')->with('error','There is no Stock for the Item');
          }
        }
      }
    }

    public function insertStockQuantity($stockList)
    {
      print_r($stockList); exit;
    }
}
