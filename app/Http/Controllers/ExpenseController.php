<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Journal;
use App\Models\Member;
use App\Models\Particular;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $expenseAccounts = Account::select('id')->where('organization_id',Auth::user()->organization_id)->where('category', 'EXPENSE')->get()->toArray();
        $expenses = Journal::where('organization_id',Auth::user()->organization_id)->whereIn('account_id', $expenseAccounts)->get();
        //$expenseAccounts = Account::select('id')->where('category', 'EXPENSE')->get()->toArray();
        $particulars = Particular::where('organization_id',Auth::user()->organization_id)->whereIn('debit_account_id',$expenseAccounts)->get();
        $members = Member::where('organization_id',Auth::user()->organization_id)->get();
        return view('expense.index',compact('particulars','members','expenses'));
    }

}
