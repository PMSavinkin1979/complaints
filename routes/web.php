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

Route::get('/',['uses'=>'Admin\IndexController@show','as'=>'index']);


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

/*Auth::routes();*/

Route::post('/axios-send/save','Admin\AxiosController@save');
Route::post('/axios-send/garantiy','Admin\AxiosController@garantiy');
Route::post('/axios-send/garantiyEditOrNew','Admin\AxiosController@garantiyEditOrNew');
Route::post('/axios-send/garantiyDelete','Admin\AxiosController@garantiyDelete');
Route::post('/axios-send/vidgarantiy','Admin\AxiosController@vidgarantiy');
Route::post('/axios-send/vidgarantiyEditOrNew','Admin\AxiosController@vidgarantiyEditOrNew');
Route::post('/axios-send/vidgarantiyDelete','Admin\AxiosController@vidgarantiyDelete');
Route::post('/axios-send/status','Admin\AxiosController@status');
Route::post('/axios-send/statusEditOrNew','Admin\AxiosController@statusEditOrNew');
Route::post('/axios-send/statusDelete','Admin\AxiosController@statusDelete');
Route::post('/axios-send/vina','Admin\AxiosController@vina');
Route::post('/axios-send/vinaEditOrNew','Admin\AxiosController@vinaEditOrNew');
Route::post('/axios-send/vinaDelete','Admin\AxiosController@vinaDelete');
Route::post('/axios-send/ustran','Admin\AxiosController@ustran');
Route::post('/axios-send/ustranEditOrNew','Admin\AxiosController@ustranEditOrNew');
Route::post('/axios-send/ustranDelete','Admin\AxiosController@ustranDelete');
Route::post('/axios-send/workStatus','Admin\AxiosController@workStatus');
Route::post('/axios-send/workStatusEditOrNew','Admin\AxiosController@workStatusEditOrNew');
Route::post('/axios-send/workStatusDelete','Admin\AxiosController@workStatusDelete');
Route::post('/axios-send/purpose','Admin\AxiosController@purpose');
Route::post('/axios-send/purposeEditOrNew','Admin\AxiosController@purposeEditOrNew');
Route::post('/axios-send/purposeDelete','Admin\AxiosController@purposeDelete');
Route::post('/select-files','Admin\AxiosController@upsavefiles');

Route::post('/axios-get/files','Admin\AxiosController@uploadfiles');
Route::post('/axios-get/readFile','Admin\AxiosController@readFile');

Route::post('/axios/deleteFile','Admin\AxiosController@deleteFile');

Route::post('/axios-send/changeYear','Admin\AxiosController@changeYear');
Route::post('/axios-send/statusChangeCard','Admin\AxiosController@statusChangeCard');
Route::post('/axios-send/statusChange','Admin\AxiosController@statusChange');

Route::post('/axios-send/newSave','Admin\AxiosController@newSave');
Route::post('/axios-send/inExcel','Admin\AxiosController@inExcel');

Route::post('/axios/deleteExcel','Admin\AxiosController@deleteExcel');

Route::post('/axios-send/summaZatraty','Admin\AxiosController@summaZatraty');
Route::post('/axios-send/selectMonths','Admin\AxiosController@selectMonths');

Route::post('/axios-send/allEntries','Admin\AxiosController@allEntries');
Route::post('/axios-send/start','Admin\AxiosController@start');

Route::post('/axios-send/chartStart','Admin\AxiosController@chartStart');
