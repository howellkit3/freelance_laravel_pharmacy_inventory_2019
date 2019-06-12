<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\Stocks;
use App\Http\Models\StockInfos;
use App\Http\Models\StockQuantities;
use App\Http\Models\Brands;
use App\Http\Models\Generics;
use App\Http\Models\Categories;
use App\Http\Models\Suppliers;

class StocksController extends Controller
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

    public function stocks()
    {
      $Stocks = new Stocks;
      $stockList = $Stocks->getStocks();
      $suppliers = $Stocks->getSupplierList();
      $brands = $Stocks->getBrandList();
      $categories = $Stocks->getCategoryList();
      $generics = $Stocks->getGenericList();

      $StockQuantities = new StockQuantities;
      $stockList = $StockQuantities->insertStockQuantity($stockList);

      $Brands = new Brands;
      $brandList = $Brands->getBrands();

      $Generics = new Generics;
      $genericList = $Generics->getGenerics();

      $Categories = new Categories;
      $categoryList = $Categories->getCategories();

      $Suppliers = new Suppliers;
      $supplierList = $Suppliers->getSuppliers();

      return view('pages.stocks.index',compact('stockList', 'supplierList', 'suppliers', 'brandList', 'categoryList', 'categories','genericList', 'brands', 'generics'));
    }

    public function searchStock()
    {
      $Stocks = new Stocks;
      $stockList = $Stocks->getStocksOverAll();

      $Suppliers = new Suppliers;
      $suppliers = $Suppliers->getAllSuppliers();

      $Brands = new Brands;
      $brands = $Brands->getAllBrands();

      $Categories = new Categories;
      $categories = $Categories->getAllCategories();

      $Generics = new Generics;
      $generics = $Generics->getAllGenerics();

      $StockQuantities = new StockQuantities;
      $stockList = $StockQuantities->insertStockQuantity($stockList);

      return view('pages.stocks.overall',compact('stockList','brands','generics','categories','suppliers'));
    }

    public function addStock(Request $request)
    {
      if($request->has('_token')) {
        $request->validate([
          'brand_id' => 'required',
          'category_id' => 'required',
          'generic_id' => 'required',
          'supplier_id' => 'required',
        ]);
        $stock_form = $request->all();
        $stock_details['stock_num'] = mt_rand(1,10000000);
        $stock_details['brand_id'] = $stock_form['brand_id'];
        $stock_details['category_id'] = $stock_form['category_id'];
        $stock_details['supplier_id'] = $stock_form['supplier_id'];
        $stock_details['generic_id'] = $stock_form['generic_id'];
        $stock_details['size'] = $stock_form['size'];
        $stock_details['status'] = 1;
        $Stocks = new Stocks;

        $isDuplicate = $Stocks->checkDuplicate($stock_details);

        if(!$isDuplicate) {
          $stock_id = $Stocks->addStock($stock_details);

          $stock_info_details['stock_id'] = $stock_id;
          $stock_info_details['lot_number'] = $stock_form['lot_number'];
          $stock_info_details['expiry_date'] = $stock_form['expiry_date'];
          $stock_info_details['unit_price'] = $stock_form['unit_price'];
          $stock_info_details['selling_price'] = $stock_form['selling_price'];

          $StockInfos = new StockInfos;
          $StockInfos->addStockInfo($stock_info_details);
        } else {
          return redirect()->route('stocks')->with('error','The Stock you created already Exist');
        }
      }

      return redirect()->route('stocks')->with('success','Stock has been created successfully!');
    }

    public function updateStock(Request $request)
    {
      if($request->has('_token')) {
        $stock_form = $request->all();
        $stock_details['brand_id'] = $stock_form['brand_id'];
        $stock_details['category_id'] = $stock_form['category_id'];
        $stock_details['supplier_id'] = $stock_form['supplier_id'];
        $stock_details['generic_id'] = $stock_form['generic_id'];
        $stock_details['size'] = $stock_form['size'];
        $stock_details['status'] = 1;
        $Stocks = new Stocks;

        $stock_id = $Stocks->updateStock($stock_details, $stock_form['stocks_id']);

        $stock_info_details['lot_number'] = $stock_form['lot_number'];
        $stock_info_details['expiry_date'] = $stock_form['expiry_date'];
        $stock_info_details['unit_price'] = $stock_form['unit_price'];
        $stock_info_details['selling_price'] = $stock_form['selling_price'];
        $StockInfos = new StockInfos;
        $StockInfos->updateStockInfo($stock_info_details, $stock_form['stock_infos_id']);
      }
      return redirect()->route('stocks')->with('success','Stock has been updated successfully!');
    }

    public function deleteStock(Request $request)
    {
      if($request->has('_token')) {
        $stock_form = $request->all();
        $stock_details['status'] = 0;
        $Stocks = new Stocks;
        $stock_id = $Stocks->updateStock($stock_details, $stock_form['stocks_id']);
      }
      return redirect()->route('stock_search')->with('success','Stock has been removed successfully!');
    }

    public function deleteSupplier(Request $request)
    {
      if($request->has('_token')) {
        $stock_form = $request->all();
        $stock_details['id'] = $stock_form['id'];
        $stock_details['status'] = 0;

        $Stocks = new Stocks;
        $Stocks->deleteStock($stock_details);
      }
      return redirect()->route('stocks')->with('success','Stock has been deleted successfully!');
    }

    public function showSearchStock(Request $request)
    {
        $keyword = $request->input('keyword');
        $Stocks = new Stocks;
        $stockList = $Stocks->getSearch($keyword);

        $Suppliers = new Suppliers;
        $suppliers = $Suppliers->getAllSuppliers();

        $Brands = new Brands;
        $brands = $Brands->getAllBrands();

        $Categories = new Categories;
        $categories = $Categories->getAllCategories();

        $Generics = new Generics;
        $generics = $Generics->getAllGenerics();

        $StockQuantities = new StockQuantities;
        $stockList = $StockQuantities->insertStockQuantity($stockList);

        return view('pages.stocks.overall',compact('stockList','brands','generics','categories','suppliers'));
    }
}
