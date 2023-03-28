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

/*Route::get('/', function () {
    return view('home');
});*/

Auth::routes();
Route::get('/', 'HomeController@index');
Route::get('/investor/{q}', 'investorController@destroy');
Route::get('/investorRestore/{q}', 'investorRestoreController@destroy');
Route::get('/category/{q}', 'categoryController@destroy');
Route::get('/categoryRestore/{q}', 'categoryRestoreController@destroy');
Route::get('/units/{q}', 'unitsController@destroy');
Route::get('/unitsRestore/{q}', 'unitsRestoreController@destroy');
Route::get('/cin_list/{q}', 'cin_listController@destroy');
Route::get('/cin_listRestore/{q}', 'cin_listRestoreController@destroy');
Route::get('/cout_list/{q}', 'cout_listController@destroy');
Route::get('/cout_listRestore/{q}', 'cout_listRestoreController@destroy');
Route::get('/users_list/{q}', 'users_listController@destroy');
Route::get('/users_listRestore/{q}', 'users_listRestoreController@destroy');
Route::get('/menu/{q}', 'menuController@index');
Route::get('/menuRestore/{q}', 'menuRestoreController@index');
Route::get('/menu/ig', 'menuController@index')->name('igmenu');
Route::get('/menu/pd', 'menuController@index')->name('pdmenu');
Route::get('/menu/mn', 'menuController@index')->name('mnmenu');
Route::get('/menuRestore/ig', 'menuRestoreController@index')->name('igmenurest');
Route::get('/menuRestore/pd', 'menuRestoreController@index')->name('pdmenurest');
Route::get('/menuRestore/mn', 'menuRestoreController@index')->name('mnmenurest');
Route::get('/menu/delete/{q}', 'menuController@destroy');
Route::get('/menuRestore/restore/{q}', 'menuRestoreController@destroy');
Route::get('/myProfile/{q}', 'myProfileController@destroy');
Route::get('/myProfile/email', 'myProfileController@destroy')->name('pemail');
Route::get('/myProfile/pass', 'myProfileController@destroy')->name('ppass');
Route::get('/myProfile/photo', 'myProfileController@destroy')->name('pphoto');




Route::get('/home', 'HomeController@index')->name('home');
Route::get('/menuBadge', 'sseController@menuBadge')->name('menuBadge');
Route::get('/iopES/{bt}/{tb}/{user}', 'sseController@iopES');
Route::get('/iop/c/{tb}', 'iopController@cancel');
Route::get('/iop/cnf/{tb}', 'iopController@confirm');
Route::get('/popES/{bt}/{tb}/{user}', 'sseController@popES');
Route::get('/pop/c/{tb}', 'popController@cancel');
Route::get('/pop/cnf/{tb}', 'popController@serve');
Route::get('/changedES/{bt}/{tb}/{user}', 'sseController@changedES');


Route::resource('/products','productsController');
Route::resource('/r_products','r_productsController');
Route::resource('/backup','backupController');
Route::resource('/myProfile', 'myProfileController');
Route::resource('/investments', 'investmentsController');
Route::resource('/r_investments', 'r_investmentsController');
Route::resource('/cin_others', 'cin_othersController');
Route::resource('/r_cin_others', 'r_cin_othersController');
Route::resource('/cout_others', 'cout_othersController');
Route::resource('/r_cout_others', 'r_cout_othersController');
Route::resource('/salary_allow', 'salary_allowController');
Route::resource('/r_salary_allow', 'r_salary_allowController');
Route::resource('/payoff', 'payoffController');
Route::resource('/r_payoff', 'r_payoffController');

Route::resource('/ingredients', 'ingredientsController');
Route::resource('/r_ingredients', 'r_ingredientsController');
Route::resource('/menu', 'menuController');
Route::resource('/menuRestore', 'menuRestoreController');
Route::resource('/menuedit', 'menueditController');
Route::resource('/category', 'categoryController');
Route::resource('/categoryRestore', 'categoryRestoreController');
Route::resource('/units', 'unitsController');
Route::resource('/unitsRestore', 'unitsRestoreController');

Route::resource('/investor', 'investorController');
Route::resource('/investorRestore', 'investorRestoreController');
Route::resource('/invpayReport', 'invpayReportController');
Route::resource('/cin_list', 'cin_listController');
Route::resource('/cin_listRestore', 'cin_listRestoreController');
Route::resource('/cin_othersReport', 'cin_othersReportController');
Route::resource('/cout_list', 'cout_listController');
Route::resource('/cout_listRestore', 'cout_listRestoreController');
Route::resource('/cout_othersReport', 'cout_othersReportController');
Route::resource('/users_list', 'users_listController');
Route::resource('/users_listRestore', 'users_listRestoreController');
Route::resource('/salary_allowReport', 'salary_allowReportController');
Route::resource('/salary_allow_sheetReport', 'salary_allow_sheetReportController');
Route::resource('/ingredientsReport', 'ingredientsReportController');
Route::resource('/productsReport', 'productsReportController');

Route::resource('/take','takeController');
Route::resource('/iop','iopController');
Route::resource('/pop','popController');
Route::resource('/changed','changedController');
Route::resource('/confirmed','confirmedController');
Route::resource('/cancel','cancelController');
Route::resource('/prepared','preparedController');
Route::resource('/served','servedController');
Route::resource('/returned','returnedController');














