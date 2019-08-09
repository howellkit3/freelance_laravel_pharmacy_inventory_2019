<?php

namespace App\Http\Controllers;

use Session;
use App\Http\Models\Stocks;
use App\Http\Models\StockQuantities;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\StocksExport;
use App\Http\Models\Brands;
use App\Http\Models\Generics;
use App\Http\Models\Categories;
use App\Http\Models\Suppliers;

class ExcelController extends Controller
{
    public function getExcel()
    {
        return view('excel.stocks');
    }

    public function exportStocks()
    {
      $Stocks = new Stocks;
      $StockQuantities = new StockQuantities;

      //$stockList = $stockList = $Stocks->getStocksExport();
      $stockList = $StockQuantities->getStocksOverAll(10000, 'overall');
      $stockList =  $StockQuantities->insertStockQuantityExcel($stockList);

      $Suppliers = new Suppliers;
      $suppliers = $Suppliers->getAllSuppliers();

      $Brands = new Brands;
      $brands = $Brands->getAllBrands();

      $Categories = new Categories;
      $categories = $Categories->getAllCategories();

      $Generics = new Generics;
      $generics = $Generics->getAllGenerics();

      $stockList = $StockQuantities->insertStockQuantity($stockList);

      return view('excel.stocks',compact('stockList','suppliers','brands','categories','generics'));
    }

    public function exportDailySales()
    {
      $input_dates['date_from'] = Session::get('date_from');
      $input_dates['date_to'] =  Session::get('date_to');

      if(empty($input_dates['date_from']) && empty($input_dates['date_to'])) {
        $input_dates = null;
      }

      $StockQuantities = new StockQuantities;
      $Stocks = new Stocks;
      $dailySalesList = $StockQuantities->getSoldDates($input_dates);
      $dailySalesList = $StockQuantities->computeProfit($dailySalesList);
      $brandList = $Stocks->getBrandListAll();
      $genericList = $Stocks->getGenericListAll();

      return view('excel.daily_sales',compact('dailySalesList', 'brandList', 'genericList' ));
    }
}
