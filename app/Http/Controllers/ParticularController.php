<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Particular;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ParticularController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $particulars = Particular::where('organization_id',Auth::user()->organization_id)->get();
        $accounts = Account::where('organization_id',Auth::user()->organization_id)->get();
        return view('particulars.index',compact('accounts','particulars'));
    }
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'name'=>'required',
            'credit_account_id'=>'required',
            'debit_account_id'=>'required',
        ]);
        if ($validate->passes())
        {
            $particular = new Particular();
            $particular->organization_id = Auth::user()->organization_id;
            $particular->name = $request->name;
            $particular->credit_account_id = $request->credit_account_id;
            $particular->debit_account_id = $request->debit_account_id;
            $particular->save();
            toast('Successfully Added Particular','success');
        }
        else
        {
            toast('All Fields are required','warning');
        }
        return redirect()->back();
    }
}
