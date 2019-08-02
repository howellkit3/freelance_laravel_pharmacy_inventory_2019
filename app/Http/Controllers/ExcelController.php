<?php

namespace App\Http\Controllers;

use App\Http\Models\Stocks;
use App\Http\Models\StockQuantities;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\StocksExport;

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

      $stockList = $stockList = $Stocks->getStocksExport();
      $stockList =  $StockQuantities->insertStockQuantityExcel($stockList);

      return view('excel.stocks',compact('stockList'));
    }

    public function exportDailySales()
    {
      $StockQuantities = new StockQuantities;
      $Stocks = new Stocks;
      $dailySalesList = $StockQuantities->getSoldDates();
      $dailySalesList = $StockQuantities->getStockQuantityByDate($dailySalesList);
      $dailySalesList = $StockQuantities->computeProfit($dailySalesList);
      $brandList = $Stocks->getBrandListAll();
      $genericList = $Stocks->getGenericListAll();

      return view('excel.daily_sales',compact('dailySalesList', 'brandList', 'genericList' ));
    }
}
