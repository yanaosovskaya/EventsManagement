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

Auth::routes();
Route::get('/logout', 'Auth\LoginController@logout')->name('logout-get');

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/contact', 'ContactFormController@create')->name('contact-form.create');
Route::post('/contact', 'ContactFormController@store')->name('contact-form.store');

Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::get('/', 'DashboardController@index')->name('admin.index');
    Route::resource('/user', 'UserController', ['as' => 'admin']);
    Route::resource('/setting', 'SettingController', ['as' => 'admin']);
    Route::resource('/menu', 'Menu\MenuController', ['as' => 'admin']);
    Route::resource('/snippet', 'SnippetController', ['as' => 'admin']);

    Route::post('/menu-item', 'Menu\MenuItemController@store')->name('admin.menu-item.store');
    Route::get('/menu-item-tree/{menu}', 'Menu\MenuItemController@showTree')->name('admin.menu-item.showTree');
    Route::delete('/menu-item-tree/{menuItem}', 'Menu\MenuItemController@destroy')->name('admin.menu-item.destroy');
    Route::put('/menu-item-sorting/{menuItem}', 'Menu\MenuItemController@updateSorting');
});


Route::group(['middleware' => ['auth']], function () {
    Route::resource('/profiles', 'ProfileController');

});

