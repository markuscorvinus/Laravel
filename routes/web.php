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

Route::post('/books', 'BookController@store')->name('book.store');
Route::patch('/books/{book}-{slug}', 'BookController@update')->name('book.update');
Route::delete('/books/{book}-{slug}', 'BookController@destroy')->name('book.delete');


Route::post('/authors', 'AuthorController@store')->name('author.store');
Route::patch('/authors/{author}', 'AuthorController@update')->name('author.update');
Route::delete('/authors/{author}', 'AuthorController@destroy')->name('author.delete');

Route::group(['middleware' => ['auth']], function () {
    Route::post('/checkout/{book}', 'CheckoutBookController@store')->name('checkout');
    Route::post('/checkin/{book}', 'CheckinBookController@store')->name('checkin');
});

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');    


