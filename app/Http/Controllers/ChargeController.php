<?php

namespace App\Http\Controllers;

use App\Models\Charge;
use App\Models\ChargeSavingProduct;
use App\Models\SavingProduct;
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
        $savingProducts= SavingProduct::where('organization_id',Auth::user()->organization_id)->get();
        $savingCharges = ChargeSavingProduct::where('organization_id',Auth::user()->organization_id)->get();
        $charges = Charge::where('organization_id',Auth::user()->organization_id)->get();
        $selects = Charge::where('organization_id',Auth::user()->organization_id)->get();
        // dd($charges);
        return view('charge.index',compact('charges','savingProducts','savingCharges','selects'));
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
    public function storeSavingCharge(Request $request){
        $charge = new ChargeSavingProduct();
        $charge->charge_id = $request->charge_id;
        $charge->organization_id = Auth::user()->organization_id;
        $charge->saving_product_id = $request->saving_product_id;
        $charge->save();
        if($charge)
        {
            toast('Successfully Added Savings Charge','success');
        }
        return redirect()->back();
    }
}
