<?php

namespace App\Http\Controllers;

use App\Models\DisbursmentOption;
use App\Models\Loanaccount;
use App\Models\LoanApplication;
use App\Models\LoanGuarantor;
use App\Models\LoanProduct;
use App\Models\Loantransaction;
use App\Models\Matrix;
use App\Models\Member;
use App\Models\Saving;
use App\Models\SavingAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoanApplicationController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $loans = LoanApplication::where('organization_id',Auth::user()->organization_id)->get();
        $options = DisbursmentOption::where('organization_id', Auth::user()->id)->get();
        $matrices = Matrix::where('organization_id', Auth::user()->id)->get();
        $members = Member::where('organization_id', Auth::user()->organization_id)->get();
        $products = LoanProduct::where('organization_id', Auth::user()->organization_id)->get();
        return view('loans.loan-application', compact('products', 'members', 'matrices', 'options','loans'));
    }

    public function store(Request $request)
    {
//        dd($request->all());
        $applier = Member::findOrFail($request->member_id);
        $reg_date = $applier->created_at;
        $monthsDiff = $this->monthsDiff($reg_date, date('Y-m-d'));

        if (!empty($request->loan_product_id) && isset($request->loan_product_id)) {
            $loanProduct = LoanProduct::findOrFail($request->loan_product_id);
            //dd($loanProduct);
        } else {
            toast('Loan Product is required when applying for a loan');
        }

        if ($monthsDiff < $loanProduct->membership_duration) {
            toast('Member must have been a member for over' . $loanProduct->membership_duration . ' months! ', 'info');
        }
        if ($request->amount_applied > $request->maximum_amount) {
            toast('Member does not have enough savings on there account', 'info');
        } else if ($request->amount_applied < 100) {
            toast('The Applied amount is too low', 'info');
        }
        $opted = DisbursmentOption::where('id', $request->disbursement_option_id)->findOrFail($request->disbursement_option_id);
        switch ($opted) {
            case $opted->max < (int)$request->amount_applied;
            toast("The amount applied is more than the maximum amount that can be disbursed by the selected disbursement option!",'info');
            break;
            case $opted->max >(int)$request->amount_applied;
            for ($i=0;$i<count([$request->guarantor_id]);$i++)
            {
                $gurantor_id = $request->guarantor_id[$i];
                //dd($gurantor_id);
                if (!empty($gurantor_id) && isset($gurantor_id))
                {
                    $guarantor = Member::findOrFail($gurantor_id);
                    $savings_balance = $this->getFinalDepositBalance($gurantor_id);
                    $savings_balance = round($savings_balance,2);
                }
            }
            $loans = new LoanApplication();
            $loans->member_id = $request->member_id;
            $loans->application_date = $request->application_date;
            $loans->loan_product_id = $request->loan_product_id;
            $loans->organization_id = Auth::user()->organization_id;
            $loans->interest_rate = LoanProduct::where('id',$request->loan_product_id)->pluck('interest_rate')->first();
            $loans->period = $request->period;
            $loans->account_number = LoanApplication::loanAccountNumber($loans);
            $loans->amount_applied = $request->amount_applied;
            $loans->repayment_start_date = date('Y-m-d');
            $loans->repayment_duration = $request->period;
            $loans->loan_status = 'Processing';
            $loans->save();
            toast('Loan Is Being Processed you will be notified soon','success');
        }
        return redirect()->back();
    }
    public function getFinalDepositBalance($guarantor)
    {
        $savings =  SavingAccount::where('member_id',$guarantor)->where('saving_product_id',1)->count();
        if ($savings>0)
        {
            $amount  = $this->getDepositSavingsBalance($guarantor);
            $guaratenteeAMount = $this->amountGuarantee($guarantor);
            $loanBalance = $this->loanBalance($guarantor);
            $finalamount = (float)$amount - (float)$guaratenteeAMount;
            $finalamount = $finalamount - (float)$loanBalance;
            if ($finalamount < 1) {
                $finalamount = 0;
            }
        }
        else{
            $finalamount=0;
        }
        return $finalamount;
    }
    public function loanBalance($guarantor)
    {
        $loanAccounts = LoanApplication::where('member_id',$guarantor)->where('is_disbursed',true)->get();
        $loanBalances = 0;
        $withGuaranteeLoanBal = 0;
        foreach ($loanAccounts as $loanaccount) {
            $loanBalance = Loantransaction::getLoanBalance($loanaccount);
            $guaranteed = LoanApplication::guaranteedAmount($loanaccount);
            if ($loanBalance < 1) {
                $loanBalance = 0;
            }
            $withGuaranteeBal = (float)$loanBalance - (float)$guaranteed;
            if ($withGuaranteeBal < 1) {
                $withGuaranteeBal = 0;
            }
            $loanBalances += $loanBalance;
            $withGuaranteeLoanBal += $withGuaranteeBal;
        }
        $what = 'withGuaranteeBal';
        if ($what) {
            return $withGuaranteeLoanBal;
        } else {
            return $loanBalances;
        }
    }
    public function amountGuarantee($guarantor)
    {
        return LoanGuarantor::where('member_id',$guarantor)->sum('amount');
    }
    public function getDepositSavingsBalance($guarantor)
    {
        $savings =  SavingAccount::where('member_id',$guarantor)->where('saving_product_id',1)->count();
        if ($savings>0)
        {
            $savingAccount = SavingAccount::where('member_id',$guarantor)->where('saving_product_id',1)->first();
            $account_balance = $this->getAccountBalance($savingAccount);
        }
        else{
            $account_balance=0;
        }
        return $account_balance;
    }
    public function getAccountBalance($savingAccount)
    {
        $deposits = Saving::where('saving_account_id',$savingAccount->id)->where('type','credit')->sum('saving_amount');
        $withdrawal = Saving::where('saving_account_id',$savingAccount->id)->where('type','debit')->sum('saving_amount');
        $balance = $deposits-$withdrawal;
        if ($balance<1)
        {
            $balance=0;
        }
        return $balance;

    }
    public function monthsDiff($reg_date, $date)
    {
//        dd($reg_date);
        $fdate_split = array_pad(explode('-', $reg_date, 3), 3, null);
        //dd($fdate_split);
        $ldate_split = array_pad(explode('-', $date, 3), 3, null);
        $fdate_year = (int)$fdate_split[0];
        $fdate_month = (int)$fdate_split[1];
        $fdate_days = (int)$fdate_split[2];
        $ldate_year = (int)$ldate_split[0];
        $ldate_month = (int)$ldate_split[1];
        $ldate_days = (int)$ldate_split[2];
        if ($fdate_year == $ldate_year) {
            $months = $ldate_month - $fdate_month;
            //dd($months);
        } else {
            $previous_months = 12 - $fdate_month;
            $months = $previous_months + $ldate_month;
        }
        $days = $ldate_days - $fdate_days;
        if ($days < 0) {
            $months_diff = $months - 1;
        } else {
            $months_diff = $months;
        }
        return $months_diff;
    }
}
