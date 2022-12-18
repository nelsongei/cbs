<?php

namespace App\Http\Controllers;

use App\Charts\SavingsChart;
use App\Models\Currency;
use App\Models\SavingProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SavingProductController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function saving_product()
    {
        $currencies  = Currency::where('organization_id',Auth::user()->id)->get();
        $savings = SavingProduct::orderBY('id')->get();
        return view('saving.saving-product',compact('savings','currencies'));
    }
    public function store_saving_product(Request  $request)
    {
        $validate = Validator::make($request->all(),[
            'name'=>'required',
            'shortname'=>'required',
            'currency_id'=>'required',
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
            $product->currency_id=$request->currency_id;
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
//        $product->currency_id=$request->currency_id;
        $product->opening_balance=$request->opening_balance;
        $product->type=$request->type;
        $product->interest_rate=$request->interest_rate;
        $product->min_amount=$request->min_amount;
        $product->is_special = $request->is_special ? true: false;
        $product->save();
        toast('Successfully Updated Product','info');
        return redirect()->back();
    }
    public function  view($id)
    {
        $data = collect([]);
        $month = collect([]);
        $product = SavingProduct::findOrFail($id);
        for ($i = 0; $i < 12; $i++) {
            $months[] = date("Y-m-d", strtotime(date('Y-m-01') . " -$i months"));
            $month->push(date('M',strtotime($months[$i])));
            $data->push( $product->accounts->whereBetween('created_at',[date('Y-m-01',strtotime($months[$i])),date('Y-m-t',strtotime($months[$i]))])->count());
        }
        $savingChart = new SavingsChart();
        $savingChart->labels = ($month);
        $savingChart->dataset('Yearly Savings','line',$data)
        ->color("#6dd144")
        ->backgroundColor("#6dd144")->linetension(0.5);
        return view('saving.view-saving-product',compact('product','savingChart'));
    }
}
