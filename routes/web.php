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
//Route::get('/', function () {
//    return view('welcome');
//})->middleware('checkAuth');
//Route::get('/working-tutorial', "DomainsController@tutorialWorking")->middleware('dashboard')->name('home')->middleware('dashboard');
//Route::get('add-password', "PasswordsController@addPassword")->middleware('dashboard');
//Route::post('add-password', "PasswordsController@savePassword")->middleware('dashboard');
//Route::post('/domain/update', "DomainsController@updateDomain")->middleware('dashboard');
//Route::post('/domain/delete', "DomainsController@deleteDomain")->middleware('dashboard');
//Route::get('edit/domain/{id}', "DomainsController@editDomain")->middleware('dashboard');
Auth::routes();
Route::get('/', "UserController@home");
Route::post('send-email', "UserController@sendEmail");
Route::post('open-payment', "UserController@openPayment");
Route::get('complete-payment/{userId}', "UserController@completePaymentView");
Route::get('user-login', "UserController@userLogin");
Route::post('complete-registration', "UserController@completeRegistration");
Route::post('userlogin', "UserController@userpostlogin");

Route::get('/home', "HomeController@showDashboard")->middleware('dashboard');
Route::get('/my-dreams', "HomeController@myDreams")->middleware('dashboard');
Route::get('/delete-dream/{id}', "HomeController@deleteDream")->middleware('dashboard');
Route::get('/add-dream', "HomeController@addDream")->middleware('dashboard');
Route::get('/my-profile', "HomeController@myProfile")->middleware('dashboard');
Route::get('/payment-method', "HomeController@paymentMethod")->middleware('dashboard');
Route::get('/my-payments', "HomeController@myPayments")->middleware('dashboard');
Route::get('/translate/{id}', "HomeController@translate")->middleware('dashboard');
Route::get('/my-payments', "HomeController@myPayments")->middleware('dashboard');
Route::get('/end-subscription/{id}', "HomeController@endSubscription")->middleware('dashboard');
Route::get('/activate-subscription/{id}', "HomeController@activateSubscription")->middleware('dashboard');
Route::get('/contact-users', "HomeController@contactUsers")->middleware('dashboard');
Route::get('/open-chat/{userId}', "HomeController@openChat")->middleware('dashboard');
Route::post('/save-dream', "HomeController@saveDream")->middleware('dashboard');
Route::post('/updateprofile', "HomeController@updateprofile")->middleware('dashboard');
Route::post('/updatecarddetails', "HomeController@updatecarddetails")->middleware('dashboard');
Route::post('/startchat', "HomeController@startchat")->middleware('dashboard');
Route::post('/send-message', "HomeController@sendMessage")->middleware('dashboard');
Route::get('/chat-details/', "HomeController@chatDetails")->middleware('dashboard');


Route::get('/unsubscribe/{token}', "HomeController@unsubscribe");

Route::get('logout-user', function (){
    \Illuminate\Support\Facades\Session::flush();
    \Illuminate\Support\Facades\Auth::logout();
    return redirect('/');
})->name('logout-user');

Route::get('import', function (){
    return view('import');
});
Route::post('/import_excel/import', 'HomeController@import');


//Route::get('/admin', "AdminController@loginPage")->middleware('checkAuth');
//Route::get('/get-chat-ping-count', "CustomerController@getChatCount");
//Route::post('/admin/login', "AdminController@login")->name('admin.login');
////Route::get('admin-dashboard', "AdminController@adminDashboard");
//Route::post('admin-logout', "AdminController@logout")->name('admin.logout');
//
////Route::get('fbx', function (){
////  return view('fbx');
////});
//
//Route::get('logout-user', function (){
//    \Illuminate\Support\Facades\Session::flush();
//    \Illuminate\Support\Facades\Auth::logout();
//    return redirect('/');
//})->name('logout-user');
//
//
//
////Route::get('category', 'CategoryController@getCategoryView')->middleware('dashboard');
////Route::get('add-category', "CategoryController@getAddCategoryView")->middleware('dashboard');
////Route::post('save-category', "CategoryController@saveCategory")->middleware('dashboard');
////Route::get('delete-category/{id}', "CategoryController@deleteCategory")->middleware('dashboard');
////Route::get('edit-category/{id}', "CategoryController@editCategory")->middleware('dashboard');
////Route::post('save-edited-category', "CategoryController@saveEditedCategory")->middleware('dashboard');
////
////Route::get('events', 'EventsController@getEventListView')->middleware('dashboard');
////Route::get('add-event', "EventsController@getAddEventView")->middleware('dashboard');
////Route::post('save-event', "EventsController@saveEvent")->middleware('dashboard');
////Route::get('delete-event/{id}', "EventsController@deleteEvent")->middleware('dashboard');
////Route::get('edit-event/{id}', "EventsController@editEvent")->middleware('dashboard');
////Route::post('save-edited-event', "EventsController@saveEditedEvent")->middleware('dashboard');
////
////Route::get('calender', 'CalenderController@getCalenderView')->middleware('dashboard');
////Route::get('get-calender', 'CalenderController@getCalendarData')->middleware('dashboard');
////Route::post('calendar/create','CalenderController@create');
////Route::post('calendar/update','CalenderController@update');
////Route::post('calendar/delete','CalenderController@destroy');
////
////new work
//Route::post('login', "AdminController@login")->name('login');
//
//Route::get('/chat', "HomeController@chat")->middleware('dashboard');
//Route::get('/chat-details/{id}', "HomeController@chatDetails")->middleware('dashboard');
//Route::post('/send-sms/{parentId}', "HomeController@sendSMS");
//
//Route::get('staff', 'StaffController@getStaffListView')->middleware('dashboard');
//Route::get('add-staff', "StaffController@getAddStaffView")->middleware('dashboard');
//Route::post('save-staff', "StaffController@saveStaff");
//Route::get('delete-staff/{id}', "StaffController@deleteStaff")->middleware('dashboard');
//Route::get('edit-staff/{id}', "StaffController@editStaff")->middleware('dashboard');
//Route::post('save-edited-staff', "StaffController@saveEditedStaff");
//
//Route::get('customer', 'CustomerController@getCustomerListView')->middleware('dashboard');
//Route::get('add-customer', "CustomerController@getAddCustomerView")->middleware('dashboard');
//Route::post('save-customer', "CustomerController@saveCustomer");
//Route::get('delete-customer/{id}', "CustomerController@deleteCustomer")->middleware('dashboard');
//Route::get('edit-customer/{id}', "CustomerController@editCustomer")->middleware('dashboard');
//Route::post('save-edited-customer', "CustomerController@saveEditedCustomer");
//
//Route::get('message-template', 'MessageTemplateController@getMessageTemplateListView')->middleware('dashboard');
//Route::get('add-message-template', "MessageTemplateController@getAddMessageTemplateView")->middleware('dashboard');
//Route::post('save-message-template', "MessageTemplateController@saveMessageTemplate");
//Route::get('delete-message-template/{id}', "MessageTemplateController@deleteMessageTemplate")->middleware('dashboard');
//Route::get('edit-message-template/{id}', "MessageTemplateController@editMessageTemplate")->middleware('dashboard');
//Route::post('save-edited-message-template', "MessageTemplateController@saveEditedMessageTemplate");
//
//Route::post('login-staff', "StaffController@login");
//Route::post('send-sms-to-checked', "CustomerController@sendSmsToChecked");
//Route::post('send-sms-to-checked-customers', "CustomerController@sendSmsToCheckedCustomer");
//Route::post('delete-checked-customers', "CustomerController@deleteCheckedCustomer");
//Route::post('delete-checked-chats', "CustomerController@deleteCheckedChats");
//Route::post('customers/all', "CustomerController@getAll");
//Route::post('chats/all', "CustomerController@getAllChats");
//
//Route::get('icoming-sms', 'HomeController@icomingSms');

