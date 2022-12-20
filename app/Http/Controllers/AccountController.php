<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\AccountCategory;
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
        $categories = AccountCategory::where('organization_id',Auth::user()->organization_id)->get();
        $accounts = Account::where('organization_id',Auth::user()->organization_id)->paginate(10);
        return view('account.index',compact('accounts','categories'));
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'code'=>'required',
            'category_id'=>'required',
            'name'=>'required'
        ]);
        if ($validator->passes())
        {
            $account = new Account();
            $account->organization_id = Auth::user()->organization_id;
            $account->code = $request->code;
            $account->account_category_id = $request->category_id;
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
    public function category(Request $request)
    {
        $category = new AccountCategory();
        $category->organization_id = Auth::user()->organization_id;
        $category->name = $request->name;
        $category->code = $request->code;
        $category->save();
    }
    public function code($id)
    {
        return AccountCategory::find($id);
    }
}
