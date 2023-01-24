<?php

namespace App\Http\Controllers;

use App\Models\DisbursmentOption;

use App\Models\LoanApplication;
use App\Models\LoanApproved;
use App\Models\LoanGuarantor;
use App\Models\LoanProduct;
use App\Models\LoanRepayment;
use App\Models\LoanTransaction;
use App\Models\Matrix;
use App\Models\Member;
use App\Models\Saving;
use App\Models\SavingAccount;
use App\Models\SavingProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoanApplicationController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $savings = SavingProduct::where('organization_id', Auth::user()->organization_id)->get();
        $loans = LoanApplication::where('organization_id', Auth::user()->organization_id)->where('is_approved', false)->get();
        $options = DisbursmentOption::where('organization_id', Auth::user()->id)->get();
        $matrices = Matrix::where('organization_id', Auth::user()->id)->get();
        $members = Member::where('organization_id', Auth::user()->organization_id)->get();
        $products = LoanProduct::where('organization_id', Auth::user()->organization_id)->get();
        $approved = LoanApproved::where('organization_id', Auth::user()->organization_id)->get();
        return view('loans.loan-application', compact('products', 'members', 'matrices', 'options', 'loans', 'savings', 'approved'));
    }

    public function store(Request $request)
    {
        
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
            toast('Member must have been a member for over ' . $loanProduct->membership_duration . ' months! ', 'info');
            return redirect()->back();
        }
        // dd($request->amount_applied);
        if ($request->amount_applied > $request->maximum_amount) {
            toast('Member does not have enough savings on there account', 'info');
            return redirect()->back();
        } else if ($request->amount_applied < 100) {
            toast('The Applied amount is too low', 'info');
        }
        $opted = DisbursmentOption::where('id', $request->disbursement_option_id)->findOrFail($request->disbursement_option_id);
        switch ($opted) {
            //1000000<1000
            case $opted->max < (int)$request->amount_applied;
                toast("The amount applied is more than the maximum amount that can be disbursed by the selected disbursement option!", 'info');
                break;
            case $opted->max > (int)$request->amount_applied;
                for ($i = 0; $i < count([$request->guarantor_id]); $i++) {
                    $gurantor_id = $request->guarantor_id[$i];
                    if (!empty($gurantor_id) && isset($gurantor_id)) {
                        $member = Member::findOrFail($request->member_id);
                        $guarantor = Member::findOrFail($gurantor_id);
                        $savings_balance = $this->getFinalDepositBalance($gurantor_id, $request->saving_product_id);
                        $savings_balance = round($savings_balance, 2);
                        $amountUnpaid = LoanTransaction::getMemberAmountUnpaid($member);
                        $guaranteedamount = $request->guarantee_amount[$i];
                        if ((float)$guaranteedamount > (float)$savings_balance) {
                            toast("Member '.$member->membership_no.' is not eligible for that guarabtee amount", 'info');
                        }
                        if ((float)$amountUnpaid > 1000) {
                            toast("Member '.$member->membership_no.' cannot guarantee due to pending arrears!", 'info');
                        }
                    }
                }
                $bank =null;
                $refinance=  $this->refinance($member,$loanProduct,$bank);
                // dd($refinance);
                $loans = new LoanApplication();
                $loans->member_id = $request->member_id;
                $loans->application_date = $request->application_date;
                $loans->loan_product_id = $request->loan_product_id;
                $loans->organization_id = Auth::user()->organization_id;
                $loans->interest_rate = LoanProduct::where('id', $request->loan_product_id)->pluck('interest_rate')->first();
                $loans->period = $request->period;
                $loans->rate_type = "monthly";
                $loans->frequency = "monthly";
                $loans->account_number = LoanApplication::loanAccountNumber($loans);
                $loans->amount_applied = $request->amount_applied-$refinance;
                $loans->repayment_start_date = date('Y-m-d');
                $loans->repayment_duration = $request->period;
                $loans->loan_status = 'Processing';
                $loans->disbursement_option_id = $request->disbursement_option_id;
                $loans->save();
                for ($k = 0; $k < count($request->guarantor_id); $k++) {
                    $guarans = new LoanGuarantor();
                    $guarans->member_id = $request->guarantor_id[$k];
                    $guarans->loan_application_id = $loans->id;
                    $guarans->has_approved = false;
                    $guarans->amount = $request->guarantee_amount[$k];
                    $guarans->date = $request->application_date;
                    $guarans->organization_id = Auth::user()->organization_id;
                    $guarans->save();
                }
                toast('Loan Is Being Processed you will be notified soon', 'success');
        }
        return redirect()->back();
    }
    public function refinance($member,$loanproduct,$bank){
		$product=$loanproduct->id;
		$memid=$member->id;
		$loans=LoanApplication::where('member_id',$memid)
						  ->where('is_approved','=',1)
						  ->where('loan_product_id','=',$product)
						  ->get();
		$total_balance=0;
		$date=date('Y-m-d');
		if(count($loans)>0){
			foreach($loans as $loan){
				$balance=Loantransaction::getLoanBalance($loan);
				//Repay all loans
				$principal_due = $balance/2;
				$interest_due = $balance/2;
				LoanRepayment::payInterest($loan, $date, $interest_due,$bank);
				LoanRepayment::payPrincipal($loan, $date, $principal_due,$bank);
				LoanTransaction::repayLoan($loan, $balance, $date,$bank);
				//Close all loans
				LoanApplication::closeLoan($loan);
				//Get total loan balances
				$total_balance+=$balance;
			}
		}
		return $total_balance;
	}
    public function getFinalDepositBalance($guarantor, $savingProduct)
    {
        //        dd($savingProduct);
        $savings = SavingAccount::where('member_id', $guarantor)->where('saving_product_id', $savingProduct)->count();
        if ($savings > 0) {
            $amount = $this->getDepositSavingsBalance($guarantor, $savingProduct);
            $guaratenteeAMount = $this->amountGuarantee($guarantor);
            $loanBalance = $this->loanBalance($guarantor);
            $finalamount = (float)$amount - (float)$guaratenteeAMount;
            $finalamount = $finalamount - (float)$loanBalance;
            if ($finalamount < 1) {
                $finalamount = 0;
            }
        } else {
            $finalamount = 0;
        }
        return $finalamount;
    }

    public function loanBalance($guarantor)
    {
        $loanAccounts = LoanApplication::where('member_id', $guarantor)->where('is_disbursed', true)->get();
        $loanBalances = 0;
        $withGuaranteeLoanBal = 0;
        foreach ($loanAccounts as $loanaccount) {
            $loanBalance = LoanTransaction::getLoanBalance($loanaccount);
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
        return LoanGuarantor::where('member_id', $guarantor)->sum('amount');
    }

    public function getDepositSavingsBalance($guarantor, $savingProduct)
    {
        $savings = SavingAccount::where('member_id', $guarantor)->where('saving_product_id', $savingProduct)->count();
        if ($savings > 0) {
            $savingAccount = SavingAccount::where('member_id', $guarantor)->where('saving_product_id', $savingProduct)->first();
            $account_balance = $this->getAccountBalance($savingAccount);
        } else {
            $account_balance = 0;
        }
        return $account_balance;
    }

    public function getAccountBalance($savingAccount)
    {
        $deposits = Saving::where('saving_account_id', $savingAccount->id)->where('type', 'credit')->sum('saving_amount');
        $withdrawal = Saving::where('saving_account_id', $savingAccount->id)->where('type', 'debit')->sum('saving_amount');
        $balance = $deposits - $withdrawal;
        if ($balance < 1) {
            $balance = 0;
        }
        return $balance;
    }

    public function monthsDiff($reg_date, $date)
    {
        $fdate_split = array_pad(explode('-', $reg_date, 3), 3, null);
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

    public function view($id)
    {
        $loan = LoanApplication::where('id', $id)->findOrFail($id);
        $principal_paid = LoanRepayment::getPrincipalPaid($loan);
        $interest_paid = LoanRepayment::getInterestPaid($loan);
        $amount = $loan->approved->amount_approved + $loan->topups->sum('amount_topup');
        $period = $loan->period;
        $rate = ($loan->interest_rate) / 100;
        $totalInterest = 0;
        for ($i = 0; $i < $period; $i++) {
            $principal = ($loan->approved->amount_approved + $loan->topups->sum('amount_topup')) / $loan->period;
            $payment = ($loan->approved->amount_approved + $loan->topups->sum('amount_topup')) / $loan->period;
            $interest = $amount * $rate;
            $principal += $interest;
            $amount -= $payment;
            // $total += $principal;
            $totalInterest += $interest;
         //   var_dump($interest);
        }

        return view('loans.view-loan', compact('loan','totalInterest','principal_paid','interest_paid'));
    }

    public function approve(Request $request, $id)
    {
        $validate = Validator::make($request->all(), [
            'approved_date' => 'required'
        ]);
        if ($validate->fails()) {
            toast('Date Is required', 'warning');
        } else {
            //   dd($request->all());
            $approve = LoanApplication::find($id);
            $approve->interest_rate = $request->interest_rate;
            $approve->loan_status = "Approved";
            $approve->is_approved = true;
            $approve->is_disbursed = true;
            $approve->repayment_start_date = date('Y-m-d', strtotime('+1 month', strtotime($request->approved_date)));;
            $approve->account_number = LoanApplication::loanAccountNumber($approve);
            $approve->date_disbursed = date('Y-m-d', strtotime($request->approved_date));
            $approve->push();
            /*
             * Approved Loans
             * */
            $loans = new LoanApproved();
            $loans->organization_id = Auth::user()->organization_id;
            $loans->loan_application_id = $id;
            $loans->amount_approved = $request->amount_applied;
            $loans->date_approved = $request->approved_date;
            $loans->interest_rate = $request->interest_rate;
            $loans->save();
            toast('Loan Approved, repayment period starts in a month', 'success');
        }
        return redirect()->back();
    }
}
