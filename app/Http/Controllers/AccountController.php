<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $accounts = Account::where('organization_id',Auth::user()->organization_id)->get();
        return view('account.index',compact('accounts'));
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'code'=>'required',
            'category'=>'required',
            'name'=>'required'
        ]);
        if ($validator->passes())
        {
            $account = new Account();
            $account->organization_id = Auth::user()->organization_id;
            $account->code = $request->code;
            $account->category = $request->category;
            $account->name = $request->name;
            $account->active  = $request->active ? true: false;
            $account->save();
        }
        else{
            toast('All Fields are required','warning');
        }
        return redirect()->back();
    }
    public function view($id)
    {
        $account = Account::findOrFail($id);
        return view('account.view',compact('account'));
    }
    public function update()
    {}
}
