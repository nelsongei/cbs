<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class LoanTransaction extends Model
{
    use HasFactory;
    public static function getLoanBalance($loanaccount)
    {
        $amountpaid = LoanTransaction::where('loan_application_id', '=', $loanaccount->id)->where('date', '>=', $loanaccount->date_disbursed)->where('type', '=', 'credit')->sum('amount');
        $amountgiven = (float)$loanaccount->amount_disbursed + (float)$loanaccount->top_up_amount;
        $total_interest = Loanaccount::getInterestAmount($loanaccount);
        $totaltobepaid = (float)$amountgiven + (float)$total_interest;
        $loanBal = (float)$totaltobepaid - (float)$amountpaid;
        if ($loanBal < 1) {
            $loanBal = 0;
        }
        $loanBal = round($loanBal, 2);
        return $loanBal;
    }
    public static function getPrincipalDue($loanaccount)
    {
        $loanproduct = LoanProduct::findorfail($loanaccount->loan_product_id);
        $formula = $loanproduct->formula;
        $months = (int)$loanaccount->period;
        $rate = LoanTransaction::getrate($loanaccount);
        $amortization = $loanproduct->amortization;
        $amount_given = (float)$loanaccount->amount_disbursed + (float)$loanaccount->top_up_amount;
        if ($amortization == "EP" && $formula == "SL") {
            $principal = $amount_given / $months;
        } else {
            $installment = LoanTransaction::getInstallment($loanaccount, '0');
            $interest = LoanTransaction::getInterestDue($loanaccount);
            //check if a loan is fully paid
            if ($interest > 0) {
                $principal = $installment - $interest;
            } else {
                $principal = 0;
            }
        }
        return $principal;
    }
    public static function getInterestDue($loanaccount)
    {
        //getaccountdetails
        $loanproduct = Loanproduct::findorfail($loanaccount->loan_product_id);
        $formula = $loanproduct->formula;
        $months = $loanaccount->period;
        $rate = LoanTransaction::getrate($loanaccount);
        $balance = LoanApplication::getLoanBalNoInterest($loanaccount); //$int_bal=Loanaccount::getInterestBal($loanaccount);
        //endgetaccountdetails
        //if($int_bal>0){$interest=$balance*$rate;}else{
        //	$interest=0;
        //}
        $interest = $balance * $rate;
        return $interest;
    }
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
    public function getAmountUnpaid($loanaccount){
        return $loanaccount;
    }
    public static function justRate($rate)
    {
        $rate = $rate / 100;
        return $rate;
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
            $rate = Loantransaction::toannualRate($rate);
        } else if ($frequency == 'monthly' && $rate_type !== 'monthly') {
            $rate = Loantransaction::tomonthlyRate($rate);
        } else {
            $rate = Loantransaction::justRate($rate);
        }
        return (float)$rate;
    }
    public static function getInstallment($loanaccount, $what = null)
    {
        //getaccountdetails
        $loanproduct = Loanproduct::findorfail($loanaccount->loan_product_id);
        $formula = $loanproduct->formula;
        $months = $loanaccount->period;
        $rate = LoanTransaction::getrate($loanaccount);
        $balance = LoanApplication::getLoanBalNoInterest($loanaccount);
        $amount = $loanaccount->amount_disbursed + $loanaccount->top_up_amount;
        $interest = $balance * $rate * (int)$months;
        $amortization = $loanproduct->amortization;
        $total_amount = $amount + $interest;
        //endgetaccountdetails
        if ($amortization == "EI" && $formula == "SL") {
            $period = $months; #no. of installments
            $eachpay = (float)$total_amount / (float)$months;
        } else if ($amortization == "EP" && $formula == "SL") {
            $principal = LoanTransaction::getPrincipalDue($loanaccount);
            $period = $months; #no. of installments
            $eachpay = (float)$principal / (float)$interest;
        } else {
            $rate = LoanTransaction::getrate($loanaccount);
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
}
