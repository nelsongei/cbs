<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AssetCategoryController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\DisbursmentOptionController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\JournalController;
use App\Http\Controllers\LoanApplicationController;
use App\Http\Controllers\LoanProductController;
use App\Http\Controllers\LoanTransactionController;
use App\Http\Controllers\MatrixController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\AccountTransactionController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\MemberDocumentController;
use App\Http\Controllers\MemberGuarantorController;
use App\Http\Controllers\ParticularController;
use App\Http\Controllers\PettyCashController;
use App\Http\Controllers\ProposalEntryController;
use App\Http\Controllers\SavingAccountController;
use App\Http\Controllers\SavingController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\SavingProductController;
use App\Http\Controllers\BankAccountController;
use App\Http\Controllers\ChargeController;
use App\Http\Controllers\FinanceReportController;
use App\Http\Controllers\LoanReportController;
use App\Http\Controllers\MemberReportController;
use App\Http\Controllers\SavingReportController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\ShareTransactionController;
use App\Http\Controllers\SupplierController;
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
Route::group(['prefix' => 'users'], function () {
    Route::get('/', [UsersController::class, 'index']);
    Route::post('/store', [UsersController::class, 'store']);
});

/*Organizatuion*/
Route::group(['prefix' => 'organization'], function () {
    Route::get('/', [OrganizationController::class, 'index']);
    Route::post('/update/{id}', [OrganizationController::class, 'update']);
});
/*
 * Members
 * */
Route::group(['prefix' => 'members'], function () {
    Route::get('/', [MemberController::class, 'index']);
    Route::post('/store', [MemberController::class, 'store']);
    Route::get('/view/{id}', [MemberController::class, 'view']);
    Route::post('/store/kin/{id}', [MemberController::class, 'kin']);
    Route::post('/update/kin/{id}', [MemberController::class, 'updateKin']);
    Route::post('/delete/kin/{id}', [MemberController::class, 'deleteKin']);
    Route::post('update/password', [MemberController::class, 'updatePassword']);
    Route::get('template', [MemberController::class, 'template']);
    Route::post('import', [MemberController::class, 'import']);
    /*
     * Guarantors
     * */
    Route::get('/guarantor/{id}', [MemberController::class, 'getGuarantor']);
    Route::get('guarantor/check/{id}', [MemberGuarantorController::class, 'getGuarantor']);
    Route::get('guarantor/check/savings/{id}', [MemberGuarantorController::class, 'getSavings']);
    Route::post('guarantor/store', [MemberGuarantorController::class, 'store']);
    Route::get('guarantor/amount/{guarantor_id}/{member_id}', [MemberGuarantorController::class, 'getAmount']);
    /*
     * Upload Profile
     * */
    Route::post('/upload/profile', [MemberController::class, 'uploadProfile']);
    /*
     * Member Documents
     * */
    Route::post('store/document', [MemberDocumentController::class, 'store']);
});
Route::group(['prefix' => 'saving'], function () {
    Route::get('products', [SavingProductController::class, 'saving_product']);
    Route::get('products/getProducts', [SavingProductController::class, 'getSavingProducts']);
    Route::post('store/products', [SavingProductController::class, 'store_saving_product']);
    Route::post('update/product', [SavingProductController::class, 'update_saving_product']);
    Route::get('product/{id}', [SavingProductController::class, 'view']);

    /*
     * Share Accounts
     * */
    Route::get('share/view/{id}', [SavingAccountController::class, 'viewShare']);
    /*
     * Savings
     * */
    Route::get('savings', [SavingController::class, 'index']);
    Route::get('export', [SavingController::class, 'exportTemplate']);
    Route::post('store', [SavingController::class, 'store']);
    Route::get('receipt/{id}', [SavingController::class, 'receipt']);
    Route::get('view/{id}', [SavingController::class, 'view']);
    Route::get('balance/{id}', [SavingController::class, 'balance']);
    //UploadBulk Savings
    Route::post('/upload', [SavingController::class, 'upload']);
    //ExportSavings
    Route::post('/export', [SavingController::class, 'exportSavings']);
    /*
     * SavingAccounts
     * */
    Route::get('accounts', [SavingAccountController::class, 'index']);
    Route::get('account/view/{id}', [SavingAccountController::class, 'view']);
    Route::post('accounts', [SavingAccountController::class, 'store']);
    Route::post('accounts/update', [SavingAccountController::class, 'update']);
    Route::get('getAccountNo', [SavingAccountController::class, 'getAccountNo']);
});
Route::group(['prefix' => 'loan'], function () {
    /*Loan Applications*/
    Route::get('/loan_application', [LoanApplicationController::class, 'index']);
    Route::post('/apply', [LoanApplicationController::class, 'store']);
    Route::get('/view/{id}', [LoanApplicationController::class, 'view']);
    Route::post('/approve/{id}', [LoanApplicationController::class, 'approve']);
    /*Loan Products*/
    Route::get('products', [LoanProductController::class, 'index']);
    Route::get('product/{id}', [LoanProductController::class, 'view']);
    Route::post('product/store', [LoanProductController::class, 'store']);
    Route::get('calculator/{id}', [LoanProductController::class, 'LoanCalculator']);
    /*Loan Product get Duration*/
    Route::get('duration/{id}', [LoanProductController::class, 'getDuration']);
    /*Loan Transactions*/
    Route::post('/repayment', [LoanTransactionController::class, 'store']);
    Route::post('/export/statements/{id}', [LoanTransactionController::class, 'exportLoanStatement']);
    /*Topup*/
    Route::post('topup', [LoanTransactionController::class, 'topup']);
    /*Offset*/
    Route::post('offset', [LoanTransactionController::class, 'offset']);
    /*Recover*/
    Route::post('/recover', [LoanTransactionController::class, 'recover']);
    /*LoanBalance*/
    Route::get('balance/{id}', [LoanTransactionController::class, 'getLoanBalance']);

    //Loan Repayment Template
    Route::get('template',[LoanTransactionController::class, 'template']);
});
/**/
Route::group(['prefix' => 'matrix'], function () {
    Route::get('/', [MatrixController::class, 'index']);
    Route::post('/store', [MatrixController::class, 'store']);
    Route::post('/update', [MatrixController::class, 'update']);
    /**/
});
/**/
Route::group(['prefix' => 'disbursements'], function () {
    Route::get('/', [DisbursmentOptionController::class, 'index']);
    Route::get('/store', [DisbursmentOptionController::class, 'store']);
});
/*
Charge Management
*/
Route::group(['prefix' => 'charge'], function () {
    Route::get('/', [ChargeController::class, 'index']);
    Route::post('/store', [ChargeController::class, 'store']);
    //Saving Charge
    Route::post('/saving', [ChargeController::class, 'storeSavingCharge']);
    //Loan Charges
    Route::post('/loan',[ChargeController::class, 'storeLoanCharge']);
});
/*
 * Accounting Module
 *
 * */
Route::group(['prefix' => 'account'], function () {
    /*Category Account*/
    Route::post('/category', [AccountController::class, 'category']);
    Route::get('code/{id}', [AccountController::class, 'code']);
    Route::get('category/code/{id}', [AccountController::class, 'getCategoryCodes']);
    /**/
    Route::get('chart', [AccountController::class, 'index']);
    Route::post('chart/store', [AccountController::class, 'store']);
    Route::post('chart/update', [AccountController::class, 'update']);
    Route::get('chart/{id}', [AccountController::class, 'view']);
});
//Journals
Route::group(['prefix' => 'journals'], function () {
    Route::get('/', [JournalController::class, 'index']);
    Route::post('/store', [JournalController::class, 'store']);
});
/**/
Route::group(['prefix' => 'particulars'], function () {
    Route::get('/', [ParticularController::class, 'index']);
    Route::post('/store', [ParticularController::class, 'store']);
});
//Expenses
Route::group(['prefix' => 'expenses'], function () {
    Route::get('/', [ExpenseController::class, 'index']);
    Route::get('/accounts',[ExpenseController::class,'getAccount']);
});
Route::group(['prefix' => 'income'], function () {
    Route::get('/', [IncomeController::class, 'index']);
});
Route::group(['prefix' => 'petty'], function () {
    Route::get('/cash', [PettyCashController::class, 'index']);
    Route::get('/transaction', [PettyCashController::class, 'transaction']);
    Route::get('/petty_cash/remove/{id}', [PettyCashController::class, 'removeTransactionItem']);
    Route::post('petty_cash/commitTransaction', [PettyCashController::class, 'commitTransaction']);
    Route::post('petty_cash/addMoney', [PettyCashController::class, 'addMoney']);
});
/*
 * budget
 * */
Route::group(['prefix' => 'budget'], function () {
    Route::get('/projections', [ProposalEntryController::class, 'index']);
    Route::post('/projections/store', [ProposalEntryController::class, 'store']);
    //Category
    Route::post('category/store',[ProposalEntryController::class, 'storeCategory']);
});
/*
 * Bank Accounts
 * */
Route::group(['prefix' => 'bank'], function () {
    Route::get('/accounts', [BankAccountController::class, 'index']);
    Route::post('/account/store', [BankAccountController::class, 'store']);
    Route::post('/account/upload', [BankAccountController::class, 'uploadStatement']);
    Route::get('deposit', [BankAccountController::class, 'deposit']);
    Route::get('reconcile/{id}', [BankAccountController::class, 'showReconcile']);
    Route::get('bankReconciliation/reconcilestatement/{bid}/{id}/{month}', [BankAccountController::class, 'showReconcile1']);
    Route::get('bankReconciliation/transact', [BankAccountController::class, 'transact']);
    Route::post('bankReconciliation/payment', [BankAccountController::class, 'payment']);
    Route::get('/template',[BankAccountController::class,'exportTemplate']);
});
/*
 *
 * Asset Management Module
 *
 * */
Route::group(['prefix' => 'asset'], function () {
    Route::get('/', [AssetController::class, 'index']);
    Route::post('/store', [AssetController::class, 'store']);
    Route::get('/movements', [AssetController::class, 'assetMovement']);
    Route::post('/movement/asset', [AssetController::class, 'moveAsset']);
    /*
     * Check Asset Details
     * */
    Route::get('/check/details/{id}', [AssetController::class, 'checkDetails']);
    /*Asset Category*/
    Route::get('/categories', [AssetCategoryController::class, 'index']);
    Route::post('/category/store', [AssetCategoryController::class, 'store']);
});
/*
 * Suppliers
 * */
Route::group(['prefix' => 'suppliers'], function () {
    Route::post('/store', [SupplierController::class, 'store']);
    Route::post('/storeSupplier', [SupplierController::class, 'storeSupplier']);
    Route::get('{id}',[SupplierController::class, 'getSuppierData']);
});
/*Shares*/
Route::group(['prefix' => 'share'], function () {
    Route::post('store', [ShareTransactionController::class, 'store']);
});
/*
Jobs
*/
Route::get('update/account/jobs', [AccountTransactionController::class, 'loanSavingAccount']);
/*
Reports
*/
Route::group(['prefix'=>'reports'],function(){
    //Members
    Route::get('members',[MemberReportController::class,'index']);
    //Finance
    Route::get('finance',[FinanceReportController::class,'index']);
    Route::post('finance/download',[FinanceReportController::class,'export']);
    //Loans
    Route::get('loans',[LoanReportController::class,'index']);
    Route::post('loans/download',[LoanReportController::class,'download']);
    //Savings
    Route::get('savings',[SavingReportController::class,'index']);
});

/*
Settings
*/
Route::group(['prefix'=>'settings'],function(){
    Route::get('/',[SettingsController::class,'index']);
});