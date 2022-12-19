<?php

namespace App\Http\Controllers;

use App\Charts\SavingsChart;
use App\Models\Account;
use App\Models\Currency;
use App\Models\SavingPosting;
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
        $accounts = Account::where('organization_id',Auth::user()->organization_id)->OrderBy('id')->get();
        $currencies  = Currency::where('organization_id',Auth::user()->id)->get();
        $savings = SavingProduct::orderBY('id')->get();
        return view('saving.saving-product',compact('savings','currencies','accounts'));
    }
    public function store_saving_product(Request  $request)
    {
     //   dd($request->all());
        $validate = Validator::make($request->all(),[
            'name'=>'required',
            'shortname'=>'required',
            'currency_id'=>'required',
            'opening_balance'=>'required',
            'type'=>'required',
            'interest_rate'=>'required',
            'min_amount'=>'required',
            'is_special'=>'required',
            'cash_account_id'=>'required',
            'bank_account_id'=>'required',
            'saving_control_account_id'=>'required',
            'fee_income_account_id'=>'required',
        ]);
        if ($validate->fails())
        {
            toast($validate->errors()->all(),'warning');
        }
        else{
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
            $saving = new SavingPosting();
            $saving->create_post_rules($product,$request->fee_income_account_id,$request->saving_control_account_id,$request->cash_account_id,$request->bank_account_id);
            toast('Success Added Saving Product','success');
        }
        return  redirect()->back();
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
        $count = collect([]);
        //dd($product->accounts);
        for ($i = 0; $i < 12; $i++) {
            $months[] = date("Y-m-d", strtotime(date('Y-m-01') . " -$i months"));
            $month->push(date('M-Y',strtotime($months[$i])));
            $data->push( $product->accounts->whereBetween('date',[date('Y-m-01',strtotime($months[$i])),date('Y-m-t',strtotime($months[$i]))])->sum('saving_amount'));
        }
        //dd($month);
        $savingChart = new SavingsChart();
        $savingChart->labels = $month;
        $savingChart->dataset('Yearly Savings','line',$data)
        ->color("#6dd144")
        ->backgroundColor("#6dd144")->linetension(0.5);
        return view('saving.view-saving-product',compact('product','savingChart'));
    }
}
