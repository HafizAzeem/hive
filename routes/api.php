<?php
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::match(['POST','GET'],'get-room-num-list', 'AjaxController@getRoomNumList')->name('rooms_list');
Route::match(['POST','GET'],'checkin-get-room-num-list', 'AjaxController@checkin_getRoomNumList');
Route::post('get-room-details', 'AjaxController@getRoomDetails');
Route::get('clean-cache', 'AjaxController@cleanCache');
Route::get('get-daily-report', 'AjaxController@getDailyReport');
Route::get('get-room-price', 'AjaxController@getRoomPrice');
Route::get('get-filter-daily-report', 'AjaxController@getFilteredReportApiData');
Route::get('user-login', 'AjaxController@userLogin');
Route::get('get-dashboard-data', 'AjaxController@getDashboardData');
Route::post('getCheckinDetails','ApiController@getCheckinDetails');

Route::post('emailLogin','ApiController@emailLogin');
Route::post('newchecking','ApiController@newchecking');
Route::get('referred_by','ApiController@referred_by');
Route::post('referred_by_data','ApiController@referred_by_data');
Route::post('getRoom','ApiController@getRoom');
Route::get('roomType','ApiController@roomType');
Route::get('paymentMode','ApiController@paymentMode');
Route::post('search','ApiController@search');
Route::post('f9alist','ApiController@f9alist');

