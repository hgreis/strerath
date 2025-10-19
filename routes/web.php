<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DomPdfController;
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


Route::get('/', function () {return view('welcome');}
	);
Route::get('/get-PDF', [DomPdfController::class, 'getPDF']);


Auth::routes();

Route::get('/home', 'App\Http\Controllers\HomeController@index');
Route::get('/menu', 'App\Http\Controllers\HomeController@menu');
Route::get('/menu_invoice', 'App\Http\Controllers\HomeController@menu_invoice');
Route::get('/menu_config', 'App\Http\Controllers\HomeController@menu_config');
Route::post('/mission/new', 'App\Http\Controllers\MissionController@mission_submit');
Route::get('/mission/new', 'App\Http\Controllers\MissionController@mission_new');
Route::get('/mission/new/{date}', 'App\Http\Controllers\MissionController@mission_newDate');
Route::get('/mission/view', 'App\Http\Controllers\MissionController@viewMissions');
Route::get('/mission/view/{id}', 'App\Http\Controllers\MissionController@viewMission');
Route::get('/mission/view/{id}/driver','App\Http\Controllers\MissionController@viewMissionDriver');
Route::get('/mission/view/{id}/customer', 'App\Http\Controllers\MissionController@viewMissionCustomer');
Route::get('/mission/viewNoDriver', 'App\Http\Controllers\MissionController@viewNoDriver');
Route::get('/mission/viewNoDeliveryNote', 'App\Http\Controllers\MissionController@viewNoDeliveryNote');
Route::get('/mission_overview/{id}', 'App\Http\Controllers\MissionController@overview');
Route::get('/customer', 'App\Http\Controllers\DriverController@customer');
Route::get('/bill1', 'App\Http\Controllers\BillController@createBill1');
Route::get('/bill2', 'App\Http\Controllers\BillController@createBill2');
Route::post('/saveBill', 'App\Http\Controllers\MissionController@saveBill');
Route::get('/invoices/{id}', 'App\Http\Controllers\MissionController@listInvoices');
Route::get('/invoicesPaid/{id}', 'App\Http\Controllers\MissionController@paidInvoices');
Route::get('/bill/{id}', 'App\Http\Controllers\MissionController@showBill');
Route::get('/bill/{id}/printPDF', 'App\Http\Controllers\BillController@printPDF');
Route::get('/payBill/{id}', 'App\Http\Controllers\BillController@payBill');
Route::get('/credits/{company}', 'App\Http\Controllers\CreditController@listForCredits');
Route::post('/saveCredit', 'App\Http\Controllers\CreditController@saveCredit');
Route::get('/listCredits/{company}', 'App\Http\Controllers\CreditController@listCredits');
Route::get('/payCredits/{company}', 'App\Http\Controllers\CreditController@payCredits');
Route::get('/payCredit/{id}', 'App\Http\Controllers\CreditController@payCredit');
Route::get('/listing', 'App\Http\Controllers\ListingController@listForListings');
Route::post('/listingSave', 'App\Http\Controllers\ListingController@listingSave');
Route::get('/listings', 'App\Http\Controllers\ListingController@listListings');
Route::get('/drivers/{id}', 'App\Http\Controllers\DriverController@edit');
Route::get('/drivers', 'App\Http\Controllers\DriverController@new');
Route::get('/drivers/{id}/delete', 'App\Http\Controllers\DriverController@driverDelete');
Route::post('/drivers', 'App\Http\Controllers\DriverController@submit');
Route::get('/unpaidMissions/{company}', 'App\Http\Controllers\MissionController@unpaidMissions');
Route::get('payMission/{id}', 'App\Http\Controllers\MissionController@payMission');
Route::get('/missionsPayDriver/{company}', 'App\Http\Controllers\MissionController@payDriverList');
Route::get('/mission/{id}/payDriver', 'App\Http\Controllers\MissionController@PayDriver');
Route::get('/mission/{id}/delete', 'App\Http\Controllers\MissionController@mission_delete');
Route::get('/mission/{id}/details', 'App\Http\Controllers\MissionController@overview');
Route::get('/mission/{id}/edit', 'App\Http\Controllers\MissionController@edit');
Route::get('/mission/calendar', 'App\Http\Controllers\MissionController@calendar');
Route::get('/mission/calendar/{lastMissionID}', 'App\Http\Controllers\MissionController@calendar');
Route::get('/credit/{id}/edit', 'App\Http\Controllers\CreditController@edit');
Route::get('/credit/{id}/delete/{mission}', 'App\Http\Controllers\CreditController@deleteMission');
Route::get('/credit/{id}/add/{mission}', 'App\Http\Controllers\CreditController@addMission');
Route::get('/credit/{id}/printPDF/{taxes}', 'App\Http\Controllers\CreditController@printPDF');
Route::get('/chart/', 'App\Http\Controllers\ChartController@missionsWithoutDates');
Route::post('/chart/', 'App\Http\Controllers\ChartController@missions');
Route::get('/chart/{company}', 'App\Http\Controllers\ChartController@report');
Route::get('/listing/{id}/edit', 'App\Http\Controllers\ListingController@edit');
Route::get('/listing/{id}/delete/{mission}', 'App\Http\Controllers\ListingController@deleteMission');
Route::get('/listing/{id}/add/{mission}', 'App\Http\Controllers\ListingController@addMission');
Route::get('/listing/{id}/printPDF', 'App\Http\Controllers\ListingController@printPDF');
Route::get('rechnung/new/{customer}', 'App\Http\Controllers\RechnungController@new' );
Route::post('rechnung/new', 'App\Http\Controllers\RechnungController@submit');
Route::get('rechnung/add/{rechnung}/{mission}', 'App\Http\Controllers\RechnungController@addMission');
Route::get('rechnung/sub/{rechnung}/{mission}', 'App\Http\Controllers\RechnungController@subMission');
Route::get('rechnung/list/{company}', 'App\Http\Controllers\RechnungController@list');
Route::get('rechnung/edit/{id}', 'App\Http\Controllers\RechnungController@edit');
Route::get('rechnung/edit/{id}/delete', 'App\Http\Controllers\RechnungController@delete');
Route::get('rechnung/payList/{company}', 'App\Http\Controllers\RechnungController@payList');
Route::get('rechnung/pay/{rechnungs_id}', 'App\Http\Controllers\RechnungController@pay');
Route::get('dekra/new_customer/{id}/delete', 'HomeController@customerDelete');
Route::get('/dekra/new_customer', 'DriverController@newCustomer');
Route::get('/dekra/new_customer/{id}', 'DriverController@editCustomer');
Route::post('/dekra/save_customer', 'DriverController@saveCustomer');
Route::get('/uploadfile','UploadFileController@index') ;
Route::post('/uploadfile','UploadFileController@showUploadFile');
Route::get('/config','HomeController@config');
Route::post('/config','HomeController@configSafe');
Route::get('edit_customer/{id}', 'App\Http\Controllers\CustomerController@editCustomer');

