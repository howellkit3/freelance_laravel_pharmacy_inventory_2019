<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\StockInfos;
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
          'unit_price' => 'required',
          'selling_price' => 'required',
          'expiry_date' => 'required',
        ]);
        $stock_quantity_form = $request->all();
        $stock_quantity_details['stock_id'] = $stock_quantity_form['stocks_id'];
        $stock_quantity_details['quantity'] = $stock_quantity_form['quantity'];
        $stock_quantity_details['date_sold'] = $stock_quantity_form['date_sold'];

        $StockQuantities = new StockQuantities;
        $isDuplicate = $StockQuantities->checkDuplicateQuantity($stock_quantity_details);

        $stock_stock_details['unit_price'] = $stock_quantity_form['unit_price'];
        $stock_stock_details['selling_price'] = $stock_quantity_form['selling_price'];
        $stock_stock_details['expiry_date'] = $stock_quantity_form['expiry_date'];
        $stock_stock_details['stocks_quantity_id'] = $stock_quantity_form['stocks_quantity_id'];
        $stock_stock_details['stocks_info_id'] = $stock_quantity_form['stocks_info_id'];
        $isStockExist = $StockQuantities->checkStockDetails($stock_stock_details);

        if(!$isStockExist) {
          $stock_stock_quantity['quantity']  = $stock_quantity_form['orig_quantity'] + $stock_quantity_form['quantity'];
          $stock_stock_quantity['id']  = $stock_quantity_form['stocks_quantity_id'];

          $isSuccessQuantityUpdate = $StockQuantities->updateStockQuantity($stock_stock_quantity);

          if($isSuccessQuantityUpdate) {
            return redirect()->route('stock_search')->with('success','Stock Quantity has been updated successfully!');
          } else {
            return redirect()->route('stock_search')->with('error','Quantity has not been added!');
          }
        }

        if(!$isDuplicate) {
          $stock_quantity_id = $StockQuantities->addQuantityToStock($stock_quantity_details);

          $StockInfos = new StockInfos;
          $stock_info_details['expiry_date'] = $stock_quantity_form['expiry_date'];
          $stock_info_details['stock_id'] = $stock_quantity_form['stocks_id'];
          $stock_info_details['unit_price'] = $stock_quantity_form['unit_price'];
          $stock_info_details['selling_price'] = $stock_quantity_form['selling_price'];
          $stock_info_details['lot_number'] = 0;
          $stock_info_details['stock_quantities_id'] = $stock_quantity_id;

          $dailySalesList = $StockInfos->addStockInfo($stock_info_details);
          return redirect()->route('stock_search')->with('success','Stock Quantity has been updated successfully!');
        }

        if($isDuplicate && $isStockExist) {
          return redirect()->route('stock_search')->with('error','Something got wrong in your input! Check if the data is duplicated');
        }
      } else {
        return view('pages.daily_sales.index',compact('dailySalesList', 'brandList', 'categoryList','stockList'));
      }
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
          return redirect()->route('sales_report')->with('error','Check Item Quantity');
        }

        if ($currentQuantity) {
          $stock_quantity_details['quantity'] = $currentQuantity->quantity + $stock_quantity_form['quantity'];
          $stock_quantity_details['date_sold'] = $stock_quantity_form['date_sold'];
          $dailySalesList = $StockQuantities->updateQuantityToStock($stock_quantity_details, $currentQuantity->id);

          return redirect()->route('sales_report')->with('success','Stock Quantity has been updated successfully!');
        } else {
          $stock_quantity_details['stock_id'] = $stock_quantity_form['stock_id'];
          $stock_quantity_details['quantity'] = $stock_quantity_form['quantity'];
          $stock_quantity_details['date_sold'] = $stock_quantity_form['date_sold'];
          $stock_quantity_details['type'] = 0;

          $hasQuantity = $StockQuantities->checkIfHasQuantity($stock_quantity_details['stock_id']);

          if(!empty($hasQuantity)) {
            $dailySalesList = $StockQuantities->addQuantityToStock($stock_quantity_details);
            return redirect()->route('sales_report')->with('success','Stock Quantity has been updated successfully!');
          }else{
            return redirect()->route('sales_report')->with('error','There is no Stock for the Item');
          }
        }
      }
    }

    public function deleteStock(Request $request)
    {
      if($request->has('_token')) {
        $stock_form = $request->all();
        $stock_details['status'] = 0;
        $StockQuantities = new StockQuantities;
        $stock_id = $StockQuantities->updateStock($stock_details, $stock_form['stock_quantity_id']);
      }
      return redirect()->route('stock_search')->with('success','Stock has been removed successfully!');
    }
}
