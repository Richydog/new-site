<?php
use \Illuminate\Support\Facades\Route;
use \Illuminate\Support\Facades\Auth;
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

Auth::routes(['verify'=>true]);

Route::get('profile', function () {

})->middleware('verified');
Route::get('/home', 'HomeController@index')->name('home');

Route::middleware('auth','can:admin-panel')->group(
     function () {

   Route::get('/admin','Admin\HomeController@index')->name('admin.home');

   Route::resource('/admin/users','Admin\UserController');
         Route::resource('/admin/regions','Admin\RegionController');
         Route::resource('/admin/adverts/categories','Admin\Adverts\CategoryController');

         Route::group(['prefix' => 'categories/{category}', 'as' => 'categories.'], function () {
             Route::post('/admin/adverts/categories/first', 'Admin\Adverts\CategoryController@first')->name('first');
             Route::post('/admin/adverts/categories/up', 'Admin\Adverts\CategoryController@up')->name('up');
             Route::post('/admin/adverts/categories/down', 'Admin\Adverts\CategoryController@down')->name('down');
             Route::post('/admin/adverts/categories/last', 'Admin\Adverts\CategoryController@last')->name('last');
             Route::resource('attributes', 'Admin\Adverts\AttributeController')->except('index');
         });
});