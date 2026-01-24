<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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
    return view('home');
});

Auth::routes();

Route::get('/list', [App\Http\Controllers\ProductController::class, 'index'])->name('list');
//商品一覧画面
Route::get('/regist', [App\Http\Controllers\ProductController::class, 'showRegistForm'])->name('regist');
//新規登録画面フォーム
Route::post('/regist', [App\Http\Controllers\ProductController::class, 'registSubmit'])->name('submit');
//新規登録画面
Route::get('/modification/{id}', [App\Http\Controllers\ProductController::class, 'showModificationForm'])->name('modification');
//編集フォーム
Route::put('modification/{id}', [App\Http\Controllers\ProductController::class, 'update'])->name('modification.update');
//更新処理
Route::get('/show/{id}', [App\Http\Controllers\ProductController::class, 'show'])->name('show');
//詳細画面
Route::delete('/products/{id}', [App\Http\Controllers\ProductController::class, 'destroy'])->name('destroy');
//削除ボタン
Route::get('/products/ajax-search', [App\Http\Controllers\ProductController::class, 'ajaxSearch'])->name('products.ajaxSearch');
