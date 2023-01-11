<?php

namespace App\Http\Controllers;

use App\Models\Charge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ChargeController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $charges = Charge::where('organization_id',Auth::user()->organization_id)->get();
        return view('charge.index',compact('charges'));
    }
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'name'=>'required',
            'category'=>'required',
            'calculation_method'=>'required',
            'payment_method'=>'required',
            'percentage_of'=>'required',
            'amount'=>'required',
            'fee'=>'required',
        ]);
        if($validate->fails())
        {
            toast($validate->errors()->all(),'warning');
        }
        else{
            $charge = new Charge();
            $charge->name = $request->name;
            $charge->organization_id = Auth::user()->organization_id;
            $charge->category = $request->category;
            $charge->calculation_method = $request->calculation_method;
            $charge->payment_method = $request->payment_method;
            $charge->percentage_of = $request->percentage_of;
            $charge->amount = $request->amount;
            $charge->fee = $request->amount ? true: false;
            $charge->save();
            toast('Success','success');
        }
        return redirect()->back();
    }
}
