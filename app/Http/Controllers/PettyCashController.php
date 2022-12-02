<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\AccountTransaction;
use App\Models\Particular;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PettyCashController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $accounts = Account::where('organization_id',Auth::user()->organization_id)->get();
        $assets = Account::where('organization_id',Auth::user()->organization_id)->where('category', 'ASSET')->where('name', 'not like', '%' . 'Loan' . '%')->get();
        $liabilities = Account::where('organization_id',Auth::user()->organization_id)->where('category', 'LIABILITY')->get();
        $petty = Account::where('organization_id',Auth::user()->organization_id)->where('name', 'LIKE', '%petty%')->get();
        $petty_account = Account::where('organization_id',Auth::user()->organization_id)->where('name', 'LIKE', '%' . 'petty cash' . '%')->where('active', 1)->first();
        if ($petty_account != null) {
            $acID = $petty_account->id;
            $query = new AccountTransaction;
            $ac_transactions = $query->where(function ($query) use ($acID) {
                $query->where('debit_account_id', $acID)
                    ->orWhere('credit_account_id', $acID);
            })->orderBy('transaction_date', 'DESC')->get();
        }
        return view('petty-cash.petty_cash',compact('accounts', 'assets', 'liabilities', 'petty', 'petty_account', 'ac_transactions'));
    }
    public function transaction()
    {
        $particulars = Particular::whereNotNull('debit_account_id')->whereNotNull('credit_account_id')->get();
        return view('petty-cash.transaction');
    }
}
