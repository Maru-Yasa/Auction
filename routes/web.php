<?php

use App\Models\Auction;
use App\Models\Bid;
use App\Models\User;
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
    return view('welcome', [
        'data' => Auction::with(['item', 'user'])->where('status', 'open')->orderBy('created_at', 'DESC')->get(),
    ]);
});


Route::group(['middleware' => 'auth'],  function(){

    Route::get('/print', 'App\Http\Controllers\PrintController@index')->name('print_auction')->middleware('staff');

    Route::group(['prefix' => 'home'], function(){
        Route::get('/', 'App\Http\Controllers\HomeController@index')->name('home');
        Route::get('/profile', 'App\Http\Controllers\ProfileController@index')->name('profile');

        Route::resource('users', 'App\Http\Controllers\UserController')->middleware('admin');
        Route::resource('items', 'App\Http\Controllers\ItemController')->middleware('staff');
        Route::resource('auctions', 'App\Http\Controllers\AuctionController')->middleware('staff');
        

        Route::get('/item/{auction_id}', 'App\Http\Controllers\BidController@detailItemAdmin')->name('item_detail_admin')->middleware('staff');
        Route::get('/bids', 'App\Http\Controllers\BidController@index')->name('bids.index')->middleware('staff');
    });

    Route::get('/item/{item_id}', 'App\Http\Controllers\BidController@detailItem')->name('item_detail');
    Route::post('/item/bid', 'App\Http\Controllers\BidController@create')->name('place_bid');
    Route::get('/item/bid/best', 'App\Http\Controllers\BidController@getBest')->name('best_bid');

});