<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Currency;
use App\Models\LoanPosting;
use App\Models\LoanProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoanProductController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $products = LoanProduct::where('organization_id',Auth::user()->organization_id)->get();
        $accounts = Account::where('organization_id',Auth::user()->organization_id)->orderBy('id')->get();
        $currencies = Currency::where('organization_id',Auth::user()->organization_id)->orderBy('id')->get();
        return view('loans.loan-products',compact('accounts','currencies','products'));
    }
    public function store(Request $request)
    {
        $data = $request->all();
        $loan_product = new LoanProduct();
        $loan_product->organization_id = Auth::user()->organization_id;
        $loan_product->short_name = $request->short_name;
        $loan_product->formula = $request->formula;
        $loan_product->interest_rate = $request->interest_rate;
        $loan_product->amortization = $request->amortization;
        $loan_product->period = $request->period;
        $loan_product->currency_id = $request->currency_id;
        $loan_product->auto_loan_limit = $request->auto_loan_limit;
        $loan_product->application_form = "$request->application_form";
        $loan_product->name = $request->name;
        $loan_product->save();
        $id = $loan_product->id;
        $this->disbursal($data,$id);
        $this->principal_repayment($data,$id);
        $this->interest_repayment($data,$id);
        $this->loan_write_off($data,$id);
        $this->fee_payment($data,$id);
        $this->overpayment_refund($data,$id);
        $this->penalty_payment($data,$id);
        if ($loan_product)
        {
            toast('Successfully created loan product','success');
        }
        return redirect()->back();
    }
    public function disbursal($data,$id)
    {

        $posting = new LoanPosting();
        $posting->organization_id = Auth::user()->organization_id;
        $posting->loan_product_id = $id;
        $posting->transaction = 'disbursal';
        $posting->credit_account_id = $data['cash_account'];
        $posting->debit_account_id = $data['portfolio_account'];
        $posting->save();
    }
    public function principal_repayment($data,$id)
    {
        $posting = new LoanPosting();
        $posting->organization_id = Auth::user()->organization_id;
        $posting->loan_product_id = $id;
        $posting->transaction = 'principal_repayment';
        $posting->credit_account_id = $data['portfolio_account'];
        $posting->debit_account_id = $data['cash_account'];
        $posting->save();
    }
    public function interest_repayment($data,$id)
    {
        $posting = new LoanPosting();
        $posting->organization_id = Auth::user()->organization_id;
        $posting->loan_product_id = $id;
        $posting->transaction = 'interest_repayment';
        $posting->credit_account_id = $data['loan_interest'];
        $posting->debit_account_id = $data['cash_account'];
        $posting->save();
    }
    public function loan_write_off($data,$id)
    {
        $posting = new LoanPosting();
        $posting->organization_id = Auth::user()->organization_id;
        $posting->loan_product_id = $id;
        $posting->transaction = 'loan_write_off';
        $posting->credit_account_id = $data['portfolio_account'];
        $posting->debit_account_id = $data['loan_write_off'];
        $posting->save();
    }
    public function fee_payment($data,$id)
    {
        $posting = new LoanPosting();
        $posting->organization_id = Auth::user()->organization_id;
        $posting->loan_product_id = $id;
        $posting->transaction = 'fee_payment';
        $posting->credit_account_id = $data['loan_fees'];
        $posting->debit_account_id = $data['cash_account'];
        $posting->save();
    }
    public function penalty_payment($data,$id)
    {
        $posting = new LoanPosting();
        $posting->organization_id = Auth::user()->organization_id;
        $posting->loan_product_id = $id;
        $posting->transaction = 'penalty_payment';
        $posting->credit_account_id = $data['loan_penalty'];
        $posting->debit_account_id = $data['cash_account'];
        $posting->save();
    }
    public function overpayment_refund($data,$id)
    {
        $posting = new LoanPosting();
        $posting->organization_id = Auth::user()->organization_id;
        $posting->loan_product_id = $id;
        $posting->transaction = 'overpayment_refund';
        $posting->credit_account_id = $data['cash_account'];
        $posting->debit_account_id = $data['loan_overpayment'];
        $posting->save();
    }
    public function getDuration($id)
    {
        $product =  LoanProduct::where('id',$id)->first();
        return $product->period;
    }
}
