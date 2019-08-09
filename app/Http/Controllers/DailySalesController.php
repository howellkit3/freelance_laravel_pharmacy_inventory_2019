<?php

namespace App\Http\Controllers;

use Session;
use Illuminate\Http\Request;
use App\Http\Models\StockQuantities;
use App\Http\Models\Stocks;
use App\Http\Models\Brands;
use App\Http\Models\Generics;

class DailySalesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function showStockQuantities()
    {
      $StockQuantities = new StockQuantities;
      $Stocks = new Stocks;
      $dailySalesList = $StockQuantities->getStockQuantities();
      $brandList = $Stocks->getBrandList();
      $categoryList = $Stocks->getCategoryList();
      $stockList = $Stocks->getStocks();

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

    public function showReportPage()
    {
      Session::put('date_from', null);
      Session::put('date_to', null);

      $Stocks = new Stocks;
      $StockQuantities = new StockQuantities;
      $stockList = $Stocks->getStocksAll();
      $stockList = $StockQuantities->insertStockQuantity($stockList);
      $brands = $Stocks->getBrandList();
      $categories = $Stocks->getCategoryList();

      $dailySalesList = $StockQuantities->getSoldDates();
      $dailySalesList = $StockQuantities->computeProfit($dailySalesList);

      $Brands = new Brands;
      $brandList = $Brands->getAllBrands();

      $Generics = new Generics;
      $genericList = $Generics->getAllGenerics();

      return view('pages.daily_sales.sales_report',compact('dailySalesList','categories','brands','stockList','brandList', 'genericList'));
    }

    public function voidStock(Request $request)
    {
      if($request->has('_token')) {
        $request->validate([
          'quantity_stock_id' => 'required',
        ]);

        $daily_sales_form = $request->all();

        $StockQuantities = new StockQuantities;
        $isSuccess = $StockQuantities->getStockSold($daily_sales_form['quantity_stock_id']);

        if($isSuccess) {
          return redirect()->route('sales_report')->with('success','The Quantity has been voided!');
        } else {
          return redirect()->route('sales_report')->with('error','Something went wrong');
        }
      }
    }

    public function filterSaleByDate(Request $request)
    {
      if($request->has('_token')) {
        $request->validate([
          'date_from' => 'required',
          'date_to' => 'required',
        ]);

        $input_dates = $request->all();

        Session::put('date_from', $input_dates['date_from']);
        Session::put('date_to', $input_dates['date_to']);

        $Stocks = new Stocks;
        $StockQuantities = new StockQuantities;
        $stockList = $Stocks->getStocksAll();
        $stockList = $StockQuantities->insertStockQuantity($stockList);
        $brands = $Stocks->getBrandList();
        $categories = $Stocks->getCategoryList();

        $dailySalesList = $StockQuantities->getSoldDates($input_dates);
        $dailySalesList = $StockQuantities->computeProfit($dailySalesList);

        $Brands = new Brands;
        $brandList = $Brands->getAllBrands();

        $Generics = new Generics;
        $genericList = $Generics->getAllGenerics();

        return view('pages.daily_sales.sales_report',compact('dailySalesList','categories','brands','stockList','brandList', 'genericList'));
      }
    }
}
