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
    public static function getInterestDue($loanaccount)
    {
        $principal_bal = LoanApplication::getPrincipalBal($loanaccount);
        $rate = $loanaccount->interest_rate / 100;
        $interest_due = $principal_bal * $rate;
        return $interest_due;
    }
    public static function getPrincipalDue($loanaccount)
    {
        /*$remaining_period = Loantransaction::getRemainingPeriod($loanaccount);
        $principal_paid = Loanrepayment::getPrincipalPaid($loanaccount);
        $principal_balance = $loanaccount->amount_disbursed - $principal_paid;
        if($principal_balance > 0 && $remaining_period > 0){
            $principal_due = $principal_balance/$remaining_period;
        }else{
            $principal_due = Loanaccount::getPrincipalBal($loanaccount);
        }*/
        $period = $loanaccount->period;
        $principal_due = ($loanaccount->approved->amount_approved + $loanaccount->top_up_amount) / $period;
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
}
