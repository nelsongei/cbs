<?php

namespace App\Http\Controllers;

use App\Models\SavingProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SavingProductController extends Controller
{
    //
    public function saving_product()
    {
        $savings = SavingProduct::orderBY('id')->get();
        return view('saving.saving-product',compact('savings'));
    }
    public function store_saving_product(Request  $request)
    {
        $validate = Validator::make($request->all(),[
            'name'=>'required',
            'shortname'=>'required',
            'currency'=>'required',
            'opening_balance'=>'required',
            'type'=>'required',
            'interest_rate'=>'required',
            'min_amount'=>'required',
            'is_special'=>'required',
        ]);
        if ($validate->passes())
        {
            $product = new SavingProduct();
            $product->name = $request->name;
            $product->shortname=$request->shortname;
            $product->organization_id = Auth::user()->organization_id;
            $product->currency=$request->currency;
            $product->opening_balance=$request->opening_balance;
            $product->type=$request->type;
            $product->interest_rate=$request->interest_rate;
            $product->min_amount=$request->min_amount;
            $product->is_special = $request->is_special ? true: false;
            $product->save();
            toast('Success Added Saving Product','success');
            return  redirect()->back();
            //return response()->json(['success'=>'Success Added Saving Product']);
        }
        else{
            toast($validate->errors()->all(),'warning');
            return redirect()->back();
        }
    }
    public function update_saving_product(Request $request)
    {
        //dd($request->id);
        $product = SavingProduct::where('id',$request->id)->findOrFail($request->id);
        $product->name = $request->name;
        $product->shortname=$request->shortname;
        $product->organization_id = Auth::user()->organization_id;
        $product->currency=$request->currency;
        $product->opening_balance=$request->opening_balance;
        $product->type=$request->type;
        $product->interest_rate=$request->interest_rate;
        $product->min_amount=$request->min_amount;
        $product->is_special = $request->is_special ? true: false;
        $product->save();
        toast('Successfully Updated Product','info');
        return redirect()->back();
    }
}
