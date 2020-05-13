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
Route::post('/Event/EventDate/AddReview', 'EventController@AddReview');

Route::get('Artists', 'ArtistController@index');
Route::get('Artist/{id}', 'ArtistController@Artist');

Route::get('Login', 'LoginController@index');
Route::get('Register', 'LoginController@Registration');
Route::post('NewRegister', 'LoginController@AddUser');
Route::post('CheckLogin', 'LoginController@CheckLogin');
Route::get('logout', 'LoginController@Logout');

Route::get('upload/{filename}', 'ImageController@displayImage')->name('image.displayImage');

Route::get('admin', function(){
    return redirect("/admin/events");
});

// admin event
Route::get('admin/events', 'Admin\EventController@index');
Route::get('admin/event/', 'Admin\EventController@Event');
Route::post('admin/createEvent', 'Admin\EventController@SaveEvent');
Route::get('admin/event/{id}', 'Admin\EventController@Event');
Route::get('admin/event/delete/{id}', 'Admin\EventController@DeleteEvent');
Route::post('admin/event/Datatable_Events', 'Admin\EventController@Datatable_Events');


// admin eventdate
Route::get('admin/eventdates/{name}/{id}', 'Admin\EventController@EventDateItems');
Route::get('admin/eventdate/{id}', 'Admin\EventController@EventDate');
Route::get('admin/eventdate/delete/{id}', 'Admin\EventController@DeleteEventDate');
Route::post('admin/dateplanning/Datatable_Plannings', 'Admin\EventController@Datatable_Plannings');