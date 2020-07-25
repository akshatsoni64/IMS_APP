<?php

use Illuminate\Support\Facades\Route;
use App\{User, Product, Customer, Stock, Transaction};

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
    $username = (Auth::check()) ? Auth::user()->name : "";
    return view('welcome', ["username" => $username]);
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/fetch_id', 'HomeController@fetch_id')->name('getid');
Route::get('/get_prod/{id}', 'HomeController@get_prod')->name('getprod');
Route::any('/report', 'HomeController@report')->name('report');
Route::get('/export-pdf', 'HomeController@export_pdf')->name('getpdf');
Route::get('/transaction_report','HomeController@transaction_report')->name('get_transactions_report');
Route::get('/stock-prod/{id}','HomeController@fetch_stock_products')->name('get_s_prod');
// Route::get('export-xls')->name('getxls');

Route::resource('/customer','CustomerController');
Route::resource('/transaction','TransactionController');
Route::resource('/product','ProductController');
Route::resource('/stock','StockController');