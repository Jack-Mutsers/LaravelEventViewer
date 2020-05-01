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

Route::get('/', 'HomeController@index');
Route::get('Home', 'HomeController@index');

Route::get('Events', 'EventController@index');
Route::get('Event/{id}', 'EventController@Event');
Route::get('Event/EventDate/{id}', 'EventController@EventDate');

Route::get('Artists', 'ArtistController@index');
Route::get('Artist/{id}', 'ArtistController@Artist');

Route::get('Login', 'LoginController@index');
Route::get('Register', 'LoginController@Registration');
Route::post('NewRegister', 'LoginController@AddUser');
Route::post('CheckLogin', 'LoginController@CheckLogin');
Route::get('logout', 'LoginController@Logout');


Route::get('admin', function(){
    return redirect("/admin/events");
});

Route::get('admin/events', 'Admin\EventController@index');