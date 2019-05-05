<?php
use Illuminate\Support\Facades\Route;

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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::middleware('auth')->group( function() {
    Route::resource('pedidos', 'OrderController')->parameters([
        'pedidos' => 'order'
    ]);
    Route::resource('precios', 'OrderPriceController')->parameters([
        'precios' => 'orderPrice',
    ]);
    Route::resource('precios/{precio}/descuentos', 'PriceDiscountController')->parameters([
        'precios' => 'orderPrice',
        'descuentos' => 'priceDiscount',
    ]);
    Route::resource('horarios', 'TimeBlockController')->parameters([
        'horarios' => 'timeBlock',
    ]);
});
