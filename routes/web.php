<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\SavingAccountController;
use App\Http\Controllers\SavingController;
use App\Http\Controllers\SavingProductController;
use App\Http\Controllers\ShareTransactionController;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return redirect('login');
});
Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
/*
 * Members
 * */
Route::group(['prefix'=>'members'],function (){
    Route::get('/',[MemberController::class,'index']);
    Route::post('/store',[MemberController::class,'store']);
    Route::get('/view/{id}',[MemberController::class,'view']);
});
Route::group(['prefix'=>'saving'],function (){
    Route::get('products',[SavingProductController::class,'saving_product']);
    Route::get('products/getProducts',[SavingProductController::class,'getSavingProducts']);
    Route::post('store/products',[SavingProductController::class,'store_saving_product']);
    Route::post('update/product',[SavingProductController::class,'update_saving_product']);
    /*
     * Share Accounts
     * */
    Route::get('share/view/{id}',[SavingAccountController::class,'viewShare']);
    /*
     * Savings
     * */
    Route::get('savings',[SavingController::class,'index']);
    Route::get('export',[SavingController::class,'exportTemplate']);
    Route::post('store',[SavingController::class,'store']);
    Route::get('receipt/{id}',[SavingController::class,'receipt']);
    /*
     * SavingAccounts
     * */
    Route::get('accounts',[SavingAccountController::class,'index']);
    Route::get('account/view/{id}',[SavingAccountController::class,'view']);
    Route::post('accounts',[SavingAccountController::class,'store']);
    Route::post('accounts/update',[SavingAccountController::class,'update']);
    Route::get('getAccountNo',[SavingAccountController::class,'getAccountNo']);
});
Route::group(['prefix'=>'share'],function (){
    Route::post('store',[ShareTransactionController::class,'store']);
});
