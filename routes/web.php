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
Route::get('Event/EventDate/{id}', 'EventDateController@EventDate');
Route::post('/Event/EventDate/AddReview', 'EventDateController@AddReview');

Route::get('Artists', 'ArtistController@index');
Route::get('Artist/{id}', 'ArtistController@Artist');

Route::get('Login', 'LoginController@index');
Route::get('Register', 'LoginController@Registration');
Route::post('NewRegister', 'LoginController@Register');
Route::post('CheckLogin', 'LoginController@CheckLogin');
Route::get('logout', 'LoginController@Logout');

Route::get('upload/{filename}', 'ImageController@displayImage')->name('image.displayImage');

Route::get('admin', function(){
    return redirect("/admin/events");
});

// admin event
Route::get('admin/events', 'Admin\EventController@index');
Route::get('admin/event/', 'Admin\EventController@Event');
Route::post('admin/event/SaveEvent', 'Admin\EventController@SaveEvent');
Route::get('admin/event/{id}', 'Admin\EventController@Event');
Route::get('admin/event/delete/{id}', 'Admin\EventController@DeleteEvent');
Route::post('admin/event/Datatable_Events', 'Admin\EventController@Datatable_Events');


// admin eventdate
Route::get('admin/eventdates/{name}/{id}', 'Admin\EventDateController@Index');
Route::get('admin/eventdate/{id}', 'Admin\EventDateController@EventDate');
Route::get('admin/eventdate/delete/{id}', 'Admin\EventDateController@DeleteEventDate');
Route::post('admin/dateplanning/Datatable_Plannings', 'Admin\EventDateController@Datatable_Plannings');