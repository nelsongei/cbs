<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Currency;
use App\Models\LoanPosting;
use App\Models\LoanProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoanProductController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $products = LoanProduct::where('organization_id', Auth::user()->organization_id)->get();
        $accounts = Account::where('organization_id', Auth::user()->organization_id)->orderBy('id')->get();
        $currencies = Currency::where('organization_id', Auth::user()->organization_id)->orderBy('id')->get();
        return view('loans.loan-products', compact('accounts', 'currencies', 'products'));
    }
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'short_name' => 'required',
            'formula' => 'required',
            'interest_rate' => 'required',
            'amortization' => 'required',
            'period' => 'required',
            'currency_id' => 'required',
            'auto_loan_limit' => 'required',
            'application_form' => 'required',
            'membership_duration' => 'required',
            'name' => 'required',
        ]);
        if ($validate->fails()) {
            toast($validate->errors()->all(), 'warning');
        } else {
            $data = $request->all();
            //dd($data);
            $loan_product = new LoanProduct();
            $loan_product->organization_id = Auth::user()->organization_id;
            $loan_product->short_name = $request->short_name;
            $loan_product->formula = $request->formula;
            $loan_product->interest_rate = $request->interest_rate;
            $loan_product->amortization = $request->amortization;
            $loan_product->period = $request->period;
            $loan_product->currency_id = $request->currency_id;
            $loan_product->auto_loan_limit = $request->auto_loan_limit;
            $loan_product->application_form = $request->application_form;
            $loan_product->membership_duration = $request->membership_duration;
            $loan_product->name = $request->name;
            $loan_product->save();
            $id = $loan_product->id;
            $this->disbursal($data, $id);
            $this->principal_repayment($data, $id);
            $this->interest_repayment($data, $id);
            $this->loan_write_off($data, $id);
            $this->fee_payment($data, $id);
            $this->overpayment_refund($data, $id);
            $this->penalty_payment($data, $id);
            if ($loan_product) {
                toast('Successfully created loan product', 'success');
            }
        }
        return redirect()->back();
    }
    public function disbursal($data, $id)
    {

        $posting = new LoanPosting();
        $posting->organization_id = Auth::user()->organization_id;
        $posting->loan_product_id = $id;
        $posting->transaction = 'disbursal';
        $posting->credit_account_id = $data['cash_account'];
        $posting->debit_account_id = $data['portfolio_account'];
        $posting->save();
    }
    public function principal_repayment($data, $id)
    {
        $posting = new LoanPosting();
        $posting->organization_id = Auth::user()->organization_id;
        $posting->loan_product_id = $id;
        $posting->transaction = 'principal_repayment';
        $posting->credit_account_id = $data['portfolio_account'];
        $posting->debit_account_id = $data['cash_account'];
        $posting->save();
    }
    public function interest_repayment($data, $id)
    {
        $posting = new LoanPosting();
        $posting->organization_id = Auth::user()->organization_id;
        $posting->loan_product_id = $id;
        $posting->transaction = 'interest_repayment';
        $posting->credit_account_id = $data['loan_interest'];
        $posting->debit_account_id = $data['cash_account'];
        $posting->save();
    }
    public function loan_write_off($data, $id)
    {
        $posting = new LoanPosting();
        $posting->organization_id = Auth::user()->organization_id;
        $posting->loan_product_id = $id;
        $posting->transaction = 'loan_write_off';
        $posting->credit_account_id = $data['portfolio_account'];
        $posting->debit_account_id = $data['loan_write_off'];
        $posting->save();
    }
    public function fee_payment($data, $id)
    {
        $posting = new LoanPosting();
        $posting->organization_id = Auth::user()->organization_id;
        $posting->loan_product_id = $id;
        $posting->transaction = 'fee_payment';
        $posting->credit_account_id = $data['loan_fees'];
        $posting->debit_account_id = $data['cash_account'];
        $posting->save();
    }
    public function penalty_payment($data, $id)
    {
        $posting = new LoanPosting();
        $posting->organization_id = Auth::user()->organization_id;
        $posting->loan_product_id = $id;
        $posting->transaction = 'penalty_payment';
        $posting->credit_account_id = $data['loan_penalty'];
        $posting->debit_account_id = $data['cash_account'];
        $posting->save();
    }
    public function overpayment_refund($data, $id)
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
        $product =  LoanProduct::where('id', $id)->first();
        return $product->period;
    }
    /*
    Loan Calculator
    Using The Loan Product to get the formula and amortization
    */
    public function LoanCalculator($id)
    {
        $product = LoanProduct::findOrFail($id);
        $rate = ($product->interest_rate) / 100;
        $rates = ($product->interest_rate);
        if ($product->formula == 'SL' && $product->amortization == 'EP') {
            $period = request()->period; //4 or any other period in months
            $amount = request()->principal; //4000
            $total = 0;
            $totalInterest = 0;
            for ($i = 0; $i < $period; $i++) {
                $principal = request()->principal / request()->period;
                $payment = request()->principal / request()->period;
                $interest = $amount * $rate;
                $principal += $interest;
                $amount -= $payment;
                $total += $principal;
                $totalInterest += $interest;
                // echo $i.' '. $payment.' '.$interest.' '.$principal.' '.$amount."<br/>\n";
            }
            $totalPrincipal = request()->principal / request()->period;
            return response()->json(['total' => $total, 'interest' => $totalInterest, 'rate' => $rates, 'totalPrincipal' => $totalPrincipal]);
        }
        if ($product->formula == 'RB' && $product->amortization == 'EI') {
            $period = request()->period; //4 or any other period in months
            $amount = request()->principal; //4000
            $total = 0;
            $totalInterest1 = 0;
            $reduceBalance = 0;
            for ($i = 0; $i < $period; $i++) {
                $rate = $product->interest_rate / 100;
                $top = (pow((1 + $rate / 12), $period) * ($rate / 12));
                $below = (pow((1 + ($rate / 12)), $period) - 1);
                $monthlyPayments = request()->principal * $top / $below;
                $interest = $amount * $rate * 2 / 24;
                $newMP = request()->principal * $top / $below;
                $rb =  $newMP -= $interest;
                $amount -= $rb;
                $total += $monthlyPayments;
                $totalInterest1 += $interest;
               //  echo 'Monthly Payment--'.$monthlyPayments.' RB --'.$rb.' Intrest---  '.$interest.' Balance --'.$amount.'<br/>';
            }
            return response()->json(['total'=>$total,'interest'=>$totalInterest1,'rate'=>$product->interest_rate,'totalPrincipal'=>$totalInterest1]);
        }
    }
    public function view($id)
    {
        $product = LoanProduct::findOrFail($id);
        return view('loans.view-loan-product', compact('product'));
    }
}
