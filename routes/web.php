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
	return redirect()->route('login');
});
// Room Light
    Route::get('/roomlight', [App\Http\Controllers\HomeController::class, 'roomlight'])->name('roomlight');
    // Route::post('/room_light', [App\Http\Controllers\HomeController::class, 'room_light'])->name('room_light');
    
    Route::get('/roomlight_action', [App\Http\Controllers\HomeController::class, 'roomlight_action'])->name('roomlight_action');
     Route::get('/get_detail', [App\Http\Controllers\HomeController::class, 'get_detail'])->name('get_detail');
      Route::get('/deleteCoupon', [App\Http\Controllers\HomeController::class, 'deleteCoupon'])->name('deleteCoupon');
    // Room Light code end


Route::group(['prefix' => 'install'], function() {
	Route::get('/', ['uses' => 'InstallController@index'])->name('checklist');
	Route::get('set-database', ['uses' => 'InstallController@databaseView'])->name('set-database');
	Route::post('save-database', ['uses' => 'InstallController@databaseSave'])->name('save-database');

	Route::get('set-siteconfig', ['uses' => 'InstallController@siteconfigView'])->name('set-siteconfig');
	Route::post('save-siteconfig', ['uses' => 'InstallController@siteconfigSave'])->name('save-siteconfig');

	Route::get('done', ['uses' => 'InstallController@doneView'])->name('done');
});
Route::group(['prefix' => 'admin'], function() {
	Route::get('/', ['uses' => 'LoginController@adminLogin'])->name('login');
	Route::post('do-login', ['uses' => 'LoginController@doLogin'])->name('do-login');
	Route::get('logout', ['uses' => 'LoginController@logout'])->name('logout');
	Route::get('autocomplete', 'AdminController@autocomplete')->name('autocomplete');
	Route::get('sendpaymentlink', 'AdminController@sendPaymentLink')->name('sendpaymentlink');
	Route::get('paytmSendLink', 'AdminController@paytmSendLink')->name('paytmSendLink');
	
	
    // Budget Estimate
    Route::get('add-budget', ['uses' => 'BudgetController@addbudget'])->name('add-budget');
    Route::post('update-budget', ['uses' => 'BudgetController@updatebudget'])->name('update-budget');
	Route::get('edit-budget/{id}', ['uses' => 'BudgetController@editbudget'])->name('edit-budget');
	Route::post('save-budget', ['uses' => 'BudgetController@savebudget'])->name('save-budget');
	Route::get('list-budget', ['uses' => 'BudgetController@listbudget'])->name('list-budget');
	Route::get('delete-budget/{id}', ['uses' => 'BudgetController@deletebudget'])->name('delete-budget');
	Route::get('budget-chart', ['uses' => 'BudgetController@budgetchart'])->name('budget-chart');
	Route::get('save-tags', ['uses' => 'BudgetController@savetags'])->name('save-tags');
    // Budget Estimate finish routes
    
    ///////////OTA WITH PAYMENT MODE////////////////
// 		Route::get('add-ota-with-payment-mode', ['uses' => 'AdminController@addOTAWithPaymentMode'])->name('add-ota-with-payment-mode');
// 		Route::post('save-ota-withpaymentmode', ['uses' => 'AdminController@saveOTAWithPaymentMode'])->name('save-ota-withpaymentmode');
// 		Route::get('list-ota-with-paymentmode', ['uses' => 'AdminController@listOTAWithPaymentMode'])->name('list-ota-with-paymentmode');
// 		Route::get('edit-ota-with-paymentmode/{id}', ['uses' => 'AdminController@editOTAWithPaymentMode'])->name('edit-ota-with-paymentmode');
// 		Route::get('delete-ota-with-paymentmode/{id}', ['uses' => 'AdminController@deleteOTAWithPaymentMode'])->name('delete-ota-with-paymentmode');
	///////////OTA WITH PAYMENT MODE END////////////////
	
	//12-8-22 jc
		Route::post('updateviewReservation', ['uses' => 'AdminController@updateviewReservation'])->name('updateviewReservation');
	//12-8-22 end
	//18-8-22 jc
	    Route::get('today-expenses', ['uses' => 'AdminController@listExpensetoday'])->name('today-expenses');
	//18-8-22 jc
	
	
	Route::get('continue-rooms-list', ['uses' => 'AdminController@continueRoomslist'])->name('continuerooms-list');
	
	
	Route::get('collection_report', 'AdminController@collection_report')->name('collection_report');
	
    Route::post('collection_report_action', 'AdminController@collection_report_action')->name('collection_report_action');
		
	Route::get('exportExcel/{start}/{end}','AdminController@exportExcel')->name('exportExcel');
// 		 Route::get('collectionReportview/{start}/{end}','AdminController@collectionReportview')->name('collectionReportview');
	
	Route::get('user-activity', ['uses' => 'AdminController@activity'])->name('user-activity');
	Route::get('getDocument', ['uses' => 'AdminController@getDocument'])->name('getDocument');
	//room-order
	    Route::get('room-order/{reservation_id?}', ['uses' => 'AdminController@roomfoodOrder'])->name('room-order');
		Route::get('room-order-table/{order_id}', ['uses' => 'AdminController@roomfoodOrderTable'])->name('room-order-table');
		Route::get('room-order-final/{order_id}', ['uses' => 'AdminController@roomfoodOrderFinal'])->name('room-order-final');
		Route::post('save-room-order', ['uses' => 'AdminController@saveFoodOrderRoom'])->name('save-room-order');
		Route::get('roomorder-invoice-final/{order_id}', ['uses' => 'AdminController@roomorderInvoiceFinal'])->name('roomorder-invoice-final');
		Route::get('onlineorder-invoice-final/{order_id}', ['uses' => 'AdminController@onlineorderInvoiceFinal'])->name('onlineorder-invoice-final');
		Route::get('room-kitchen-invoice/{order_id}/{order_type}', ['uses' => 'AdminController@roomkitchenInvoice'])->name('room-kitchen-invoice');
	//room-order-url-end
	Route::group(['middleware'=>['permission','userlogs']], function()
	 {
		Route::get('dashboard', ['uses' => 'AdminController@index'])->name('dashboard');
		Route::get('new-dashboard', 'AdminController@dashboard')->name('new-dashboard');
		Route::post('new-dashboard', 'AdminController@dashboard')->name('new-dashboard');
		
		Route::get('profile', ['uses' => 'AdminController@editLoggedUserProfile'])->name('profile');
		Route::post('save-profile', ['uses' => 'AdminController@saveProfile'])->name('save-profile');
		
		Route::get('add-user', ['uses' => 'AdminController@addUser'])->name('add-user');
		Route::get('edit-user/{id}', ['uses' => 'AdminController@editUser'])->name('edit-user');
		Route::post('save-user', ['uses' => 'AdminController@saveUser'])->name('save-user');
		Route::get('list-user', ['uses' => 'AdminController@listUser'])->name('list-user');
		
		//extra revenue
        Route::get('add-extrarevenue', ['uses' => 'AdminController@addExtrarevenue'])->name('add-extrarevenue');
        Route::post('update-extrarevenue', ['uses' => 'AdminController@updateExtrarevenue'])->name('update-extrarevenue');
		//Route::get('edit-extrarevenue/{id}', ['uses' => 'AdminController@editExtrarevenue'])->name('edit-extrarevenue');
		Route::get('edit-revenue/{id}', ['uses' => 'AdminController@editrevenue'])->name('edit-revenue');
		Route::post('save-extrarevenue', ['uses' => 'AdminController@saveExtrarevenue'])->name('save-extrarevenue');
		Route::get('list-extrarevenue', ['uses' => 'AdminController@listExtrarevenue'])->name('list-extrarevenue');
		Route::get('delete-extrarevenue/{id}', ['uses' => 'AdminController@deleteExtrarevenue'])->name('delete-extrarevenue');
	    // extra revenue end
	    
	    //performa invoice
        Route::get('add-performa', ['uses' => 'AdminController@addPerforma'])->name('add-performa');
        Route::post('update-performa', ['uses' => 'AdminController@updatePerforma'])->name('update-performa');
		Route::get('edit-performa/{id}', ['uses' => 'AdminController@editperforma'])->name('edit-performa');
		Route::post('save-performa', ['uses' => 'AdminController@savePerforma'])->name('save-performa');
		Route::get('list-performa', ['uses' => 'AdminController@listPerforma'])->name('list-performa');
		Route::get('delete-performa/{id}', ['uses' => 'AdminController@deletePerforma'])->name('delete-performa');
		Route::get('invoice-performa/{id}/{type}', ['uses' => 'AdminController@invoiceperforma'])->name('invoice-performa');
	    // performa invoice end
		
		//booking process && searching
		Route::get('search', ['uses'=>'SearchController@index'])->name('search');
			
  	    Route::get('newcheckin/{mobile}', ['uses' => 'SearchController@newcheckin'])->name('newcheckin');
  	
  	    Route::get('newexistscheckin/{id}', ['uses' => 'SearchController@newexistscheckin'])->name('newexistscheckin');
  	
  	    Route::post('savecheckin', ['uses' => 'SearchController@savecheckin'])->name('savecheckin');
  	    
  	 //   Route::post('mobotpchekin', ['uses' => 'SearchController@mobotpnewchekin'])->name('mobotpchekin');
    //     Route::post('verifyotpchekin', ['uses' => 'SearchController@verifyotpchekin'])->name('verifyotpchekin');

		///////////Corporate////////////////
		Route::get('add-corporate', ['uses' => 'AdminController@addCorporate'])->name('add-corporate');
		Route::get('edit-corporate/{id}', ['uses' => 'AdminController@editCorporate'])->name('edit-corporate');
		Route::post('save-corporate', ['uses' => 'AdminController@saveCorporate'])->name('save-corporate');
		Route::get('list-corporate', ['uses' => 'AdminController@listCorporate'])->name('list-corporate');
		Route::get('delete-corporate/{id}', ['uses' => 'AdminController@deleteCorporate'])->name('delete-corporate');
		///////////TAs////////////////
		Route::get('add-ta', ['uses' => 'AdminController@addTa'])->name('add-ta');
		Route::get('edit-ta/{id}', ['uses' => 'AdminController@editTa'])->name('edit-ta');
		Route::post('save-ta', ['uses' => 'AdminController@saveTa'])->name('save-ta');
		Route::get('list-ta', ['uses' => 'AdminController@listTa'])->name('list-ta');
		Route::get('delete-ta/{id}', ['uses' => 'AdminController@deleteTa'])->name('delete-ta');
		///////////OTA////////////////
		Route::get('add-ota', ['uses' => 'AdminController@addOTA'])->name('add-ota');
		Route::get('edit-ota/{id}', ['uses' => 'AdminController@editOTA'])->name('edit-ota');
		Route::post('save-ota', ['uses' => 'AdminController@saveOTA'])->name('save-ota');
		Route::get('list-ota', ['uses' => 'AdminController@listOTA'])->name('list-ota');
		Route::get('delete-ota/{id}', ['uses' => 'AdminController@deleteOTA'])->name('delete-ota');
		
		///////////Email////////////////
		Route::get('add-email', ['uses' => 'AdminController@addEmail'])->name('add-email');
		Route::get('edit-email/{id}', ['uses' => 'AdminController@editEmail'])->name('edit-email');
		Route::post('save-email', ['uses' => 'AdminController@saveEmail'])->name('save-email');
		Route::get('list-email', ['uses' => 'AdminController@listEmail'])->name('list-email');
		Route::get('delete-email/{id}', ['uses' => 'AdminController@deleteEmail'])->name('delete-email');
	    //////////////////Billing /////////////////
		Route::match(['GET','POST'],'billing/{type?}/{subtype?}', ['uses' => 'AdminController@CorporateBill'])->name('billing');

		Route::post('set-time', ['uses' => 'AdminController@setTime'])->name('set-time');
		Route::get('delete-user/{id}', ['uses' => 'AdminController@deleteUser'])->name('delete-user');


		Route::get('add-customer', ['uses' => 'CustomerController@addCustomer'])->name('add-customer');
		Route::get('edit-customer/{id}', ['uses' => 'CustomerController@editCustomer'])->name('edit-customer');

		Route::post('save-customer', ['uses' => 'CustomerController@saveCustomer'])->name('save-customer');
		Route::get('list-customer', ['uses' => 'CustomerController@listCustomer'])->name('list-customer');
		Route::get('delete-customer/{id}', ['uses' => 'CustomerController@deleteCustomer'])->name('delete-customer');

		Route::get('add-room', ['uses' => 'AdminController@addRoom'])->name('add-room');
		Route::get('edit-room/{id}', ['uses' => 'AdminController@editRoom'])->name('edit-room');
		Route::post('save-room', ['uses' => 'AdminController@saveRoom'])->name('save-room');
		Route::get('list-room', ['uses' => 'AdminController@listRoom'])->name('list-room');
		Route::get('delete-room/{id}', ['uses' => 'AdminController@deleteRoom'])->name('delete-room');

		Route::get('add-room-types', ['uses' => 'AdminController@addRoomType'])->name('add-room-types');
		Route::get('edit-room-types/{id}', ['uses' => 'AdminController@editRoomType'])->name('edit-room-types');
		Route::post('save-room-types', ['uses' => 'AdminController@saveRoomType'])->name('save-room-types');
		Route::get('list-room-types', ['uses' => 'AdminController@listRoomType'])->name('list-room-types');

		Route::get('room-types', ['uses' => 'AdminController@getroomtype'])->name('room-types');
		Route::get('report', ['uses' => 'AdminController@report'])->name('report');
		Route::get('daily-report', ['uses' => 'AdminController@dailyReport'])->name('daily-report');

		

		Route::get('delete-room-types/{id}', ['uses' => 'AdminController@deleteRoomType'])->name('delete-room-types');

		Route::get('add-amenities', ['uses' => 'AdminController@addAmenities'])->name('add-amenities');
		Route::get('edit-amenities/{id}', ['uses' => 'AdminController@editAmenities'])->name('edit-amenities');
		Route::post('save-amenities', ['uses' => 'AdminController@saveAmenities'])->name('save-amenities');
		Route::get('list-amenities', ['uses' => 'AdminController@listAmenities'])->name('list-amenities');
		Route::get('delete-amenities/{id}', ['uses' => 'AdminController@deleteAmenities'])->name('delete-amenities');

		

		Route::get('check-in/{id?}', ['uses' => 'AdminController@roomReservation'])->name('room-reservation');
		
		
		Route::get('ta_report', ['uses' => 'AdminController@ta_report'])->name('ta_report');
		
		Route::post('ta_report_action', ['uses' => 'AdminController@ta_report_action'])->name('ta_report_action');
		
		Route::get('cancel-arrival/{id?}', ['uses' => 'AdminController@cancelArrival'])->name('cancel-arrival');
		Route::get('arrival-check-in', ['uses' => 'AdminController@roomArrivalReservation'])->name('room-arrival-reservation');
		Route::get('check-in-available/{id}', ['uses' => 'AdminController@roomReservationAvailable'])->name('room-reservation-available');
		Route::get('edit-check-in/{unique_id}', ['uses' => 'AdminController@editRoomReservation'])->name('edit-room-reservation');
		
		
		
		Route::get('check-out/{id}', ['uses' => 'AdminController@editReservation'])->name('edit-reservation');
		Route::post('save-reservation', ['uses' => 'AdminController@saveReservation'])->name('save-reservation');
		Route::post('update-reservation', ['uses' => 'AdminController@updateReservation'])->name('update-room-reservation');
		Route::post('save-arrival', ['uses' => 'AdminController@saveArrival'])->name('save-arrival');
		Route::post('update-arrival', ['uses' => 'AdminController@updateArrival'])->name('update-room-arrival');

		Route::get('delete-mediafile/{id}', ['uses' => 'AdminController@deleteMediaFile'])->name('delete-mediafile');

		Route::get('check-out/{id}', ['uses' => 'AdminController@checkOut'])->name('check-out-room');
		Route::post('check-out', ['uses' => 'AdminController@saveCheckOutData'])->name('check-out');
		Route::get('list-check-ins', ['uses' => 'AdminController@listReservationtoday'])->name('list-reservation');
		Route::get('single-list-reservation', ['uses' => 'AdminController@singleListReservation'])->name('single-list-reservation');
		
		Route::get('pending_amount', ['uses' => 'AdminController@pending_amount'])->name('pending_amount');
		
		Route::get('multi-list-reservation', ['uses' => 'AdminController@multiListReservation'])->name('multi-list-reservation');
		Route::get('housekeeping', ['uses' => 'AdminController@housekeeping'])->name('housekeeping');
		Route::get('outlet', ['uses' => 'AdminController@outlet'])->name('outlet');
		Route::post('outlet_action', ['uses' => 'AdminController@outlet_action'])->name('outlet_action');
		
		Route::post('remark_action', ['uses' => 'AdminController@remark_action'])->name('remark_action');
		
		Route::get('list-arrivals', ['uses' => 'AdminController@listArrivalReservation'])->name('list-arrival-reservation');
		
// 		Route::get('foodorderlistnew', ['uses' => 'AdminController@foodorderlistnew'])->name('foodorderlistnew');

		
		Route::get('list-check-outs', ['uses' => 'AdminController@listCheckOuts'])->name('list-check-outs');
		Route::get('view-reservation/{id}', ['uses' => 'AdminController@viewReservation'])->name('view-reservation');
		Route::get('delete-reservation/{id}', ['uses' => 'AdminController@deleteReservation'])->name('delete-reservation');
		Route::get('invoice/{id}/{type}', ['uses' => 'AdminController@invoice'])->name('invoice');
		
		Route::get('arrival_invoice/{id}', ['uses' => 'AdminController@arrival_invoice'])->name('arrival_invoice');
    // Crud food items 
		Route::get('add-food-category', ['uses' => 'AdminController@addFoodCategory'])->name('add-food-category');
		Route::get('edit-food-category/{id}', ['uses' => 'AdminController@editFoodCategory'])->name('edit-food-category');
		Route::post('save-food-category', ['uses' => 'AdminController@saveFoodCategory'])->name('save-food-category');
		Route::get('list-food-category', ['uses' => 'AdminController@listFoodCategory'])->name('list-food-category');
		Route::get('delete-food-category/{id}', ['uses' => 'AdminController@deleteFoodCategory'])->name('delete-food-category');
    
		Route::get('add-food-item', ['uses' => 'AdminController@addFoodItem'])->name('add-food-item');
		Route::get('edit-food-item/{id}', ['uses' => 'AdminController@editFoodItem'])->name('edit-food-item');
		Route::post('save-food-item', ['uses' => 'AdminController@saveFoodItem'])->name('save-food-item');
		Route::get('list-food-item', ['uses' => 'AdminController@listFoodItem'])->name('list-food-item');
		Route::get('delete-food-item/{id}', ['uses' => 'AdminController@deleteFoodItem'])->name('delete-food-item');
    // crud food items end
		Route::get('add-expense-category', ['uses' => 'AdminController@addExpenseCategory'])->name('add-expense-category');
		Route::get('edit-expense-category/{id}', ['uses' => 'AdminController@editExpenseCategory'])->name('edit-expense-category');
		Route::post('save-expense-category', ['uses' => 'AdminController@saveExpenseCategory'])->name('save-expense-category');
		Route::get('list-expense-category', ['uses' => 'AdminController@listExpenseCategory'])->name('list-expense-category');
		Route::get('delete-expense-category/{id}', ['uses' => 'AdminController@deleteExpenseCategory'])->name('delete-expense-category');

		Route::get('add-expense', ['uses' => 'AdminController@addExpense'])->name('add-expense');
		Route::get('edit-expense/{id}', ['uses' => 'AdminController@editExpense'])->name('edit-expense');
		Route::post('save-expense', ['uses' => 'AdminController@saveExpense'])->name('save-expense');
		Route::get('list-expense', ['uses' => 'AdminController@listExpense'])->name('list-expense');
		Route::get('delete-expense/{id}', ['uses' => 'AdminController@deleteExpense'])->name('delete-expense');

Route::get('invoice/{id}', ['uses' => 'AdminController@invoice'])->name('invoice');

		//table order
		
		Route::get('food-order/{reservation_id?}', ['uses' => 'AdminController@FoodOrder'])->name('food-order');
		Route::get('food-order-table/{order_id}', ['uses' => 'AdminController@FoodOrderTable'])->name('food-order-table');
		Route::get('food-order-final/{order_id}', ['uses' => 'AdminController@FoodOrderFinal'])->name('food-order-final');
		Route::post('save-food-order', ['uses' => 'AdminController@saveFoodOrder'])->name('save-food-order');

		Route::get('orders-list', ['uses' => 'AdminController@listOrders'])->name('orders-list');
		Route::get('order-invoice/{id}', ['uses' => 'AdminController@orderInvoice'])->name('order-invoice');
		
		Route::get('order-invoice-final/{order_id}', ['uses' => 'AdminController@orderInvoiceFinal'])->name('order-invoice-final');
		Route::get('kitchen-invoice/{order_id}/{order_type}', ['uses' => 'AdminController@kitchenInvoice'])->name('kitchen-invoice');
		
		Route::get('delete-order-item/{id}', ['uses' => 'AdminController@deleteOrderItem'])->name('delete-order-item');

		//table order end

		Route::get('add-product', ['uses' => 'AdminController@addProduct'])->name('add-product');
		Route::get('edit-product/{id}', ['uses' => 'AdminController@editProduct'])->name('edit-product');
		Route::post('save-product', ['uses' => 'AdminController@saveProduct'])->name('save-product');
		Route::get('list-product', ['uses' => 'AdminController@listProduct'])->name('list-product');
		Route::get('delete-product/{id}', ['uses' => 'AdminController@deleteProduct'])->name('delete-product');

		Route::get('io-stock', ['uses' => 'AdminController@inOutStock'])->name('io-stock');
		Route::post('save-stock', ['uses' => 'AdminController@saveStock'])->name('save-stock');
		Route::get('stock-history', ['uses' => 'AdminController@stockHistory'])->name('stock-history');

		Route::get('settings', 'AdminController@settingsForm')->name('settings');
    	Route::post('/save-settings', 'AdminController@saveSettings')->name('save-settings');

		Route::get('permissions-list', 'AdminController@listPermission')->name('permissions-list');
    	Route::post('/save-permissions', 'AdminController@savePermission')->name('save-permissions');

    	Route::post('/search-orders', 'ReportController@searchOrders')->name('search-orders');
    	Route::post('/export-orders', 'ReportController@exportOrders')->name('export-orders');

    	Route::post('/search-stocks', 'ReportController@searchStockHistory')->name('search-stocks');
    	Route::post('/export-stocks', 'ReportController@exportStockHistory')->name('export-stocks');

    	Route::post('/search-checkins', 'ReportController@searchCheckins')->name('search-checkins');
    	Route::post('/export-checkins', 'ReportController@searchCheckins')->name('export-checkins');

    	Route::post('/search-checkouts', 'ReportController@searchCheckouts')->name('search-checkouts');
    	Route::post('/export-checkouts', 'ReportController@searchCheckouts')->name('export-checkouts');

		Route::post('/search-reports', 'ReportController@searchReport')->name('search-reports');
    	Route::post('/export-reports', 'ReportController@searchReport')->name('export-reports');

    	Route::post('/search-expenses', 'ReportController@searchExpense')->name('search-expenses');
    	Route::post('/export-expenses', 'ReportController@exportExpense')->name('export-expenses');

		Route::any('save-guest-card', ['uses' => 'AdminController@saveGuestCard'])->name('save-guest-card');


	});

});
Route::get('meal-master', ['uses' => 'AdminController@mealMaster'])->name('meal-master');
Route::get('add-meal-plan', ['uses' => 'AdminController@addMealPlan'])->name('add-meal-plan');
Route::post('save-meal-plan', ['uses' => 'AdminController@saveMealPlan'])->name('save-meal-plan');
Route::get('package-master', ['uses' => 'AdminController@packageMaster'])->name('package-master');
Route::get('add-package', ['uses' => 'AdminController@addPackage'])->name('add-package');
Route::post('save-package', ['uses' => 'AdminController@savePackage'])->name('save-package');
Route::get('edit-package/{id}', ['uses' => 'AdminController@editPackage'])->name('edit-package');
Route::post('update-package/', ['uses' => 'AdminController@updatePackage'])->name('update-package');
Route::get('delete-package/{id}', ['uses' => 'AdminController@deletePackage'])->name('delete-package');
Route::get('rooms-inventory', ['uses' => 'AdminController@roomsInventory'])->name('rooms-inventory');
Route::get('get-filtered-room-data', ['uses' => 'AdminController@getFilteredRoomData'])->name('get-filtered-room-data');
Route::get('get-filtered-report-data', ['uses' => 'AjaxController@getFilteredReportData'])->name('get-filtered-report-data');
Route::get('get-report-data', ['uses' => 'AjaxController@getReportData'])->name('get-report-data');
Route::get('view-customer/{id}', ['uses' => 'CustomerController@viewCustomer'])->name('view-customer');
Route::get('payment-master', ['uses' => 'AdminController@paymentmodeMaster'])->name('payment-master');
Route::get('add-payment-mode', ['uses' => 'AdminController@addPaymentMode'])->name('add-payment-mode');
Route::post('save-paymentmode', ['uses' => 'AdminController@savePaymentmode'])->name('save-paymentmode');

Route::get('demo', ['uses' => 'AdminController@demo'])->name('demo');

Route::get('access-denied',function() {
		return view('page_403');
})->name('access-denied');

//Clear Cache facade value:
Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('cache:clear');
    return '<h1>Cache facade value cleared</h1>';
});

//Re-optimized class loader:
Route::get('/optimize', function() {
    $exitCode = Artisan::call('optimize');
    return '<h1>Re-optimized class loader</h1>';
});

//Route cache:
Route::get('/route-cache', function() {
    $exitCode = Artisan::call('route:cache');
    return '<h1>Routes cached</h1>';
});

//Clear Route cache:
Route::get('/route-clear', function() {
    $exitCode = Artisan::call('route:clear');
    return '<h1>Route cache cleared</h1>';
});

//Clear View cache:
Route::get('/view-clear', function() {
    $exitCode = Artisan::call('view:clear');
    return '<h1>View cache cleared</h1>';
});

//Clear Config cache:
Route::get('/config-cache', function() {
    $exitCode = Artisan::call('config:cache');
    return '<h1>Clear Config cleared</h1>';
});

//DB migrate
Route::get('/migrate', function() {
    $exitCode = Artisan::call('migrate');
    return '<h1>Data tables import success</h1>';
});

Route::get('reportExcel', 'AdminController@reportExcel')->name('reportExcel');

Route::get('list-date_price_range', ['uses' => 'AdminController@listDatePriceRange'])->name('list-date_price_range');
Route::get('Add_hotal_amenities', ['uses' => 'AdminController@Addhotalamenities'])->name('Add_hotal_amenities');
Route::post('save-hotalamenities', ['uses' => 'AdminController@savehotalamenities'])->name('save-hotalamenities');

Route::post('save-Addavailedservices', ['uses' => 'AdminController@saveAddavailedservices'])->name('save-Addavailedservices');
Route::get('Add_availed_services', ['uses' => 'AdminController@Addavailedservices'])->name('Add_availed_services');

Route::post('UploadFile','ReportController@UploadFile')->name('UploadFile');

Route::get('mob','AjaxController@mob')->name('mob');


Route::get('list-hotal-amenities','AdminController@listHotalAmenities')->name('list-hotal-amenities');

Route::get('edit-hotel-amenities/{id}', 'AdminController@editHotelAmenities')->name('edit-hotel-amenities');


Route::get('delete-hotel-amenities/{id}' , 'AdminController@deleteHotelAmenities')->name('delete-hotel-amenities');


Route::post('update-hotelamenities' , 'AdminController@updatehotelamenities')->name('update-hotelamenities');









Route::get('list-availed-services','AdminController@listAvailedServices')->name('list-availed-services');

Route::get('edit-availed-services/{id}', 'AdminController@editAvailedServices')->name('edit-availed-services');


Route::get('delete-availed-services/{id}', 'AdminController@deleteAvailedServices')->name('delete-availed-services');


Route::post('update-availed-services' , 'AdminController@updateAvailedServices')->name('update-availed-services');

Route::get('inventory', ['uses' => 'FullCalenderController@index'])->name('inventory');
Route::post('fullcalenderAjax', ['uses' => 'FullCalenderController@ajax']);

// Route::get('testmail' , 'MailtestNew@index')->name('testmail');

// Route::get('send-mail', function () {
   
//     $details = [
//         'title' => 'Mail from ItSolutionStuff.com',
//         'body' => 'This is for testing email using smtp'
//     ];
   
//     Mail::to('jackchauhan8882@gmail.com')->send(new \App\Mail\MyTestMail($details));
   
//     dd("Email is Sent.");
// });
Route::get('todays-upcoming', ['uses' => 'AdminController@todaysupcoming'])->name('todays-upcoming');
Route::get('placeCall', ['uses' => 'AdminController@clicktocallnew'])->name('placeCall');

// Route::get('/menu/{id}', ['uses' => 'OrderController@menu'])->name('menu');
// Route::get('thank-you', ['uses' => 'OrderController@RazorThankYou'])->name('thank-you');
// Route::get('payment-failed', ['uses' => 'OrderController@Paymentfailed'])->name('payment-failed');

Route::get('razorpay', 'RazorpayController@razorpay')->name('razorpay');
Route::post('payment','RazorpayController@payment')->name('payment');

Route::get('menu/{id}', ['uses' => 'ProductController@indexnew'])->name('menu');  
Route::get('cart', 'ProductController@cart')->name('cart');
Route::get('menu/add-to-cart/{id}', 'ProductController@addToCart')->name('add-to-cart');
Route::patch('update-cart', 'ProductController@update')->name('update.cart');
Route::delete('remove-from-cart', 'ProductController@remove')->name('remove.from.cart');

// Route::get('menucategory', ['uses' => 'ProductController@indexnewtwo'])->name('menucategory');

Route::post('mobotp','ProductController@mobotpnew')->name('mobotp');
Route::post('verifyotp','ProductController@verifyotp')->name('verifyotp');
Route::get('thank-you', ['uses' => 'ProductController@RazorThankYou'])->name('thank-you');
Route::get('payment-failed', ['uses' => 'ProductController@Paymentfailed'])->name('payment-failed');

Route::post('mobotpchekin', ['uses' => 'SearchController@mobotpnewchekin'])->name('mobotpchekin');
Route::post('verifyotpchekin', ['uses' => 'SearchController@verifyotpchekin'])->name('verifyotpchekin');
Route::post('skipotp', ['uses' => 'SearchController@skipotpcheckin'])->name('skipotp');

Route::post('getmobnumb','ProductController@getmobnumb')->name('getmobnumb');

Route::get('foodorderlistnew', ['uses' => 'AdminController@foodorderlistnew'])->name('foodorderlistnew');
Route::get('ordercount', ['uses' => 'AdminController@ordercount'])->name('ordercount');
Route::post('markpreparing', ['uses' => 'AdminController@markpreparing'])->name('markpreparing');
Route::post('markpreparinglocal', ['uses' => 'AdminController@markpreparinglocal'])->name('markpreparinglocal');
Route::post('closeroomorder', ['uses' => 'AdminController@closeroomorder'])->name('closeroomorder');
Route::post('closeroomorderlocal', ['uses' => 'AdminController@closeroomorderlocal'])->name('closeroomorderlocal');
Route::post('printbill', ['uses' => 'AdminController@printbill'])->name('printbill');

Route::post('bulk-food-upload', ['uses' => 'AdminController@saveFocuskeyword'])->name('bulk-food-upload');

Route::get('latest-orders', ['uses' => 'AdminController@latestOrders'])->name('latest-orders');

Route::get('food-sales-report', ['uses' => 'AdminController@foodsalesreport'])->name('food-sales-report');
Route::post('/search-foodreport', 'ReportController@searchFoodreport')->name('search-foodreport');
//get data according to room number food order
Route::post('getrooomdatacustomer', ['uses' => 'AdminController@getrooomdatacustomer'])->name('getrooomdatacustomer');
//get data according to room number food order code end
Route::post('myotaalldata', ['uses' => 'AdminController@myotaalldata'])->name('myotaalldata');
// Route::post('myotaalldata2', ['uses' => 'AdminController@myotaalldata2'])->name('myotaalldata2');
Route::post('myotaalldata3', ['uses' => 'AdminController@myotaalldata3'])->name('myotaalldata3');

Route::get('delivery', ['uses' => 'DeliveryController@deliveryindex'])->name('delivery');
Route::post('savedeliveryorder', 'DeliveryController@savedeliveryorder')->name('savedeliveryorder');
Route::post('savecustomerdetails', 'DeliveryController@savecustomerdetails')->name('savecustomerdetails');






















