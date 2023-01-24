<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LoanTransaction extends Model
{
    use HasFactory;
    public static function getInstallment($loanaccount, $what = null)
    {
        //getaccountdetails
        $loanproduct = LoanProduct::findorfail($loanaccount->loan_product_id);
        $formula = $loanproduct->formula;
        $months = $loanaccount->period;
        $amount = $loanaccount->amount_disbursed + $loanaccount->top_up_amount;
        $interest = Loantransaction::getInterestDue($loanaccount);
        $amortization = $loanproduct->amortization;
        $total_amount = $amount + $interest;
        //endgetaccountdetails
        if ($amortization == "EI" && $formula == "SL") {
            $period = $months; #no. of installments
            $eachpay = (float)$total_amount / (float)$months;
        } else if ($amortization == "EP" && $formula == "SL") {
            $principal = Loantransaction::getPrincipalDue($loanaccount);
            // dd($principal);
            $period = $months; #no. of installments
            $eachpay = (float)$principal / (float)$interest;
        } else {
            $rate = Loantransaction::getrate($loanaccount);
            $r1 = $rate + 1;
            $r2 = pow($r1, -$months);
            $r3 = 1 - $r2;
            $r4 = $r3 / $rate;
            $period = $r4; #no. of installments
            $eachpay = $amount / $r4; #installment amount
        }
        if ($what == 'period') {
            return $period;
        } else {
            return $eachpay;
        }
    }
    public static function repayLoan($loanaccount, $amount, $date,$bank){
        $transaction = new LoanTransaction();
        $transaction->loan_application_id = $loanaccount->id;
        $transaction->date = $date;
        $transaction->organization_id = Auth::user()->organization_id;
        $transaction->description = 'loan repayment';
        $transaction->amount = $amount;
        $transaction->bank_ldetails = $bank;
        $transaction->type = 'credit';
        $transaction->save();
    }
    public static function getInterestDue($loanaccount)
    {
        $principal_bal = LoanApplication::getPrincipalBal($loanaccount);
        $rate = $loanaccount->interest_rate / 100;
        $period = $loanaccount->period/12;
        $interest_due = $principal_bal * $rate*$period/($period*12);
        return $interest_due;
    }
    public static function getLoanBalance($loanaccount){
        $principal_bal = LoanApplication::getPrincipalBal($loanaccount);
        if(!empty($principal_bal)){
            $period = $loanaccount->period/12;
            $rate = $loanaccount->interest_rate/100;
            $interest_due = $principal_bal * $rate*$period/($period*12);;
            $balance = $principal_bal + $interest_due;
            return $balance;
        }else{
            return 0;
        }
    }
    public static function getRemainingPeriod($loanaccount){

        $paid_periods = DB::table('loan_transactions')->where('loan_application_id', '=', $loanaccount->id)
            ->where('description', '=', 'loan repayment')
            ->where('date', '>', $loanaccount->date_disbursed)
            ->count();
        $remaining_period = $loanaccount->repayment_duration - $paid_periods;

        return $remaining_period;
    }
    public static function getPrincipalDue($loanaccount)
    {
        // $remaining_period = LoanTransaction::getRemainingPeriod($loanaccount);
        // $principal_paid = LoanRepayment::getPrincipalPaid($loanaccount);
        // $principal_balance = $loanaccount->amount_disbursed - $principal_paid;
        // if($principal_balance > 0 && $remaining_period > 0){
        //     $principal_due = $principal_balance/$remaining_period;
        // }else{
        //     $principal_due = LoanApplication::getPrincipalBal($loanaccount);
        // }
        $period = LoanTransaction::getRemainingPeriod($loanaccount);
        $principal_due = ($loanaccount->approved->amount_approved + $loanaccount->topups->sum('amount_topup')) / $period;
        return $principal_due;
    }
    public static function getrate($loanaccount)
    {
        //getaccountdetails
        $frequency = $loanaccount->frequency;
        $rate = $loanaccount->interest_rate;
        $rate_type = $loanaccount->rate_type;
        $balance = LoanApplication::getPrincipalBal($loanaccount);
        //endgetaccountdetails
        if ($frequency == 'annually' && $rate_type !== 'annually') {
            $rate = LoanTransaction::toannualRate($rate);
        } else if ($frequency == 'monthly' && $rate_type !== 'monthly') {
            $rate = LoanTransaction::tomonthlyRate($rate);
        } else {
            $rate = LoanTransaction::justRate($rate);
        }
        return (float)$rate;
    }
    public static function tomonthlyRate($rate)
    {
        $rate = $rate / 100;
        $rate = $rate / 12;
        return $rate;
    }
    public static function toannualRate($rate)
    {
        $rate = $rate / 100;
        $rate = $rate * 12;
        return $rate;
    }
    public static function justRate($rate)
    {
        $rate = $rate / 100;
        return $rate;
    }

    ///
    public static function getMemberAmountUnpaid($member_id)
    {

        $loanaccounts = LoanApplication::where('member_id', '=', $member_id)->get();
        $allUnpaid = 0;
        foreach ($loanaccounts as $loanaccount) {
            $unpaid = LoanTransaction::getAmountUnpaid($loanaccount);
            $allUnpaid += $unpaid;
        }
        return $allUnpaid;
    }

    public static function topupLoan($loanaccount, $amount,$date,$bank){
        $particular = (Particular::where('name', 'LIKE', '%' . $loanaccount->loanType->name.' Disbursal' . '%')->first());
        if($particular ==null){
            toast('Add Particcular with name '.$loanaccount->loanType->name.' Disbursal','info');
            return redirect()->back();
        }
        else{
            $transaction = new Loantransaction;
            $transaction->loanaccount()->associate($loanaccount);
            $transaction->date = $date;
            $transaction->description = 'loan top up';
            $transaction->amount = $amount;
            $transaction->bank_ldetails = $bank;
            $transaction->type = 'debit';
            $transaction->save();
            $account = Loanposting::getPostingAccount($loanaccount->loanproduct, 'disbursal');
            $data = array(
                'credit_account' =>$account['credit'] ,
                'debit_account' =>$account['debit'] ,
                'date' => $date,
                'amount' => $loanaccount->top_up_amount,
                'initiated_by' => 'system',
                'description' => 'loan top up',
                'bank_details'=>$bank,
                'particulars_id' => $particular->id,
                'narration' => $loanaccount->member->id
            );
            $journal = new Journal;
            $journal->journal_entry($data);
        }
    }
}
