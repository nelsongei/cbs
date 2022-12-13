<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BankAccountController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $bank_accounts = BankAccount::where('organization_id',Auth::user()->organization_id)->orderBy('id')->get();
        return view('banking.accounts',compact('bank_accounts'));
    }
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'bank_name'=>'required',
            'account_name'=>'required',
            'account_number'=>'required'
        ]);
        if ($validate->fails())
        {
            toast($validate->errors()->all(),'warning');
        }
        else{
            $account = new BankAccount();
            $account->organization_id = Auth::user()->organization_id;
            $account->bank_name = $request->bank_name;
            $account->account_name = $request->account_name;
            $account->account_number = $request->account_number;
            $account->save();
            toast('SUccessfully added bank account','success');
        }
        return redirect()->back();
    }
}
