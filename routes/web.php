<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Member\MemberController;
use App\Http\Controllers\File\FileController;
use App\Http\Controllers\Bbs\BbsController;
use App\Http\Controllers\PopUp\PopUpController;

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

// Route::get('/', function () {
//     return view('index');
// });

Route::get('', 'App\Http\Controllers\HomeController@index')->name('index');

Route::prefix('member')->group(function () {

    Route::get('login'  ,[MemberController::class, 'loginView'] )->name('member.login');
    Route::post('login' ,[MemberController::class, 'login'] )->name('member.login');

    Route::post('logout',[MemberController::class, 'logout'])->name('member.logout');
    // Route::get('admin', 'App\Http\Controllers\MemberController@adminList')->name('member.admin');
    // Route::post('create', 'App\Http\Controllers\MemberController@createMember')->name('member.create');
    // Route::post('update', 'App\Http\Controllers\MemberController@updateMember')->name('member.update');
    // Route::get('destroy', 'App\Http\Controllers\MemberController@destroyMember')->name('member.destroy');

});

Route::prefix('bbs/{bbs_name}')->group(function () {
    Route::get( ''              ,[BbsController::class, 'list'] )->name('bbs.list');
    Route::get( 'create'        ,[BbsController::class, 'create'] )->name('bbs.create');
    Route::post('store'         ,[BbsController::class, 'store'] )->name('bbs.store');
    Route::get( 'show'          ,[BbsController::class, 'show'])->name('bbs.show');
    Route::get( 'edit/{sid}'    ,[BbsController::class, 'edit'])->name('bbs.edit');
    Route::post('update/{sid}'  ,[BbsController::class, 'update'])->name('bbs.update');
    Route::get('{sid}/destroy'  ,[BbsController::class, 'destroy'])->name('bbs.destroy');
    Route::get('{sid}/change'   ,[BbsController::class, 'change'])->name('bbs.change');
//    Route::get('{post}/reply/create', 'BbsController@create')->name('post.reply.create');

   Route::get('calender', [BbsController::class, 'calender'])->name('bbs.calender');
});

Route::prefix('file')->group(function () {
    Route::post('upload/{path}' ,[FileController::class, 'upload'] )->name('file.upload');
    Route::get('download/{sid}' ,[FileController::class, 'download'] )->name('file.download');
    Route::get('download2/{sid}',[FileController::class, 'download2'] )->name('file.download2');
//    Route::get('file_download/{attachment}', 'FileController@file_download')->name('file.file_download');
});

Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});

Route::prefix('popup')->group(function () {
    Route::get('email_security' ,[PopUpController::class, 'showEmailSecurity'] )->name('popup.email_security');
    Route::post('preview'       ,[PopUpController::class, 'preview'] )->name('popup.preview');
    Route::get('{sid}/show'     ,[PopUpController::class, 'show'] )->name('popup.show');
    Route::post('close'         ,[PopUpController::class, 'close'])->name('popup.close');
});