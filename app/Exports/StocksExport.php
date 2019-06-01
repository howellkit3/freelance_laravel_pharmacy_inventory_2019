<?php

namespace App\Exports;

use App\Http\Models\Stocks;
use App\Http\Models\StockQuantities;
use Maatwebsite\Excel\Concerns\FromCollection;

class StocksExport implements FromCollection
{
    public function collection()
    {
        $Stocks = new Stocks;
        $StockQuantities = new StockQuantities;

        $stockList = $stockList = $Stocks->getStocksExport();
        $stockList =  $StockQuantities->insertStockQuantityExcel($stockList);

        return view('excel.stocks',compact('stockList'));
    }
}
