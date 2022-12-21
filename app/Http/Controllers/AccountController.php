<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\AccountCategory;
use App\Models\Asset;
use App\Models\TypeAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        $types = TypeAccount::where('organization_id',Auth::user()->organization_id)->get();
        $categories = AccountCategory::where('organization_id',Auth::user()->organization_id)->get();
        $accounts = Account::where('organization_id',Auth::user()->organization_id)->orderBy('account_category_id')->paginate(15);
        return view('account.index',compact('accounts','categories','types'));
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
            toast('Created Successfully','success');
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
    public function update(Request $request)
    {
        $account = Account::findOrFail($request->id);
        $account->name = $request->name;
        $account->active = $request->active ? true:false;
        $account->push();
        toast('Updated Successfully','info');
        return redirect()->back();
    }
    public function category(Request $request)
    {
        $category = new AccountCategory();
        $category->organization_id = Auth::user()->organization_id;
        $category->name = $request->name;
        $category->code = $request->code;
        $category->type_account_id = $request->type_account_id;
        $category->sub_type_2 = $request->sub_type_2;
        $category->save();
    }
    public function code($id)
    {
        return AccountCategory::find($id);
    }
    public function getCategoryCodes($id)
    {
        $codes = Account::where('account_category_id',$id)->get();
        if(count($codes)<1)
        {
            $category = (AccountCategory::find($id));
            return $category->code.'00001';
        }
        else{
            $last = DB::table('accounts')->where('account_category_id',$id)->latest()->first();
            return (int)$last->code+000001;
        }
    }
}
