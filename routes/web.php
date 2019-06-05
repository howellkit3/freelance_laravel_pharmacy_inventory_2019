<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('stocks', function()
{
    return View::make('pages.stocks.index');
});
Route::get('suppliers', function()
{
    return View::make('suppliers.index');
});

Route::get("/categories", ["uses" => "CategoriesController@categories", "as" => "category"]);
Route::post("/category_add", ["uses" => "CategoriesController@addCategory", "as" => "category.add"]);
Route::post("/category_update", ["uses" => "CategoriesController@updateCategory", "as" => "category.update"]);
Route::post("/category_delete", ["uses" => "CategoriesController@deleteCategory", "as" => "category.delete"]);

Route::get("/brands", ["uses" => "BrandsController@brands", "as" => "brand"]);
Route::post("/brand_add", ["uses" => "BrandsController@addBrand", "as" => "brand.add"]);
Route::post("/brand_update", ["uses" => "BrandsController@updateBrand", "as" => "brand.update"]);
Route::post("/brand_delete", ["uses" => "BrandsController@deleteBrand", "as" => "brand.delete"]);

Route::get("/generics", ["uses" => "GenericsController@generics", "as" => "generic"]);
Route::post("/generic_add", ["uses" => "GenericsController@addGeneric", "as" => "generic.add"]);
Route::post("/generic_update", ["uses" => "GenericsController@updateGeneric", "as" => "generic.update"]);
Route::post("/generic_delete", ["uses" => "GenericsController@deleteGeneric", "as" => "generic.delete"]);

Route::get("/suppliers", ["uses" => "SuppliersController@suppliers", "as" => "suppliers"]);
Route::post("/supplier_add", ["uses" => "SuppliersController@addSupplier", "as" => "supplier.add"]);
Route::post("/supplier_update", ["uses" => "SuppliersController@updateSupplier", "as" => "supplier.update"]);
Route::post("/supplier_delete", ["uses" => "SuppliersController@deleteSupplier", "as" => "supplier.delete"]);

Route::get("/stocks", ["uses" => "StocksController@stocks", "as" => "stocks"]);
Route::post("/stock_add", ["uses" => "StocksController@addStock", "as" => "stock.add"]);
Route::post("/stock_update", ["uses" => "StocksController@updateStock", "as" => "stock.update"]);
Route::post("/stock_delete", ["uses" => "StocksController@deleteStock", "as" => "stock.delete"]);

Route::get("/stock_search", ["uses" => "StocksController@searchStock", "as" => "stock_search"]);

Route::post("/add_quantity", ["uses" => "StockQuantitiesController@addQuantity", "as" => "stock.addQuantity"]);
Route::post("/add_sale", ["uses" => "StockQuantitiesController@addSale", "as" => "stock.addSale"]);

Route::get("/daily_sales", ["uses" => "DailySalesController@showStockQuantities", "as" => "daily_sales"]);
Route::post("/sales_report", ["uses" => "DailySalesController@addDailyStockSale", "as" => "sales_report"]);
Route::post("/daily_sales_update", ["uses" => "DailySalesController@updateDailyStockSale", "as" => "daily_sales.update"]);
Route::post("/daily_sales_delete", ["uses" => "DailySalesController@deleteDailyStockSale", "as" => "daily_sales.delete"]);

Route::get("/sales_report", ["uses" => "DailySalesController@showReportPage", "as" => "sales_report"]);
Route::get("/stocks-excel", ["uses" => "ExcelController@exportStocks", "as" => "stocks-excel"]);
Route::get("/daily-sales-excel", ["uses" => "ExcelController@exportDailySales", "as" => "daily-sales-excel"]);

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
