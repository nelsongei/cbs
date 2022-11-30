<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class LoanApplication extends Model
{
    use HasFactory;
    public static function guaranteedAmount($loanaccount)
    { #changeo
        $g_amount = LoanGuarantor::where('loan_application_id', '=', $loanaccount->id)->sum('amount');
        return (float)$g_amount;
    }
    public static function loanAccountNumber($loanaccount)
    {
        $member = Member::find($loanaccount->member_id);

        $count = count([$member->loanaccounts]);
        $count = $count + 1;
        $loanno = LoanProduct::findOrFail($loanaccount->loan_product_id)->short_name . "-" . Member::findOrFail($loanaccount->member_id)->membership_no . "-" . $count;
        return $loanno;

    }
    public function member()
    {
        return $this->belongsTo(Member::class);
    }
    public function loanType()
    {
        return $this->belongsTo(LoanProduct::class,'loan_product_id');
    }
    public function approved()
    {
        return $this->hasOne(LoanApproved::class,'loan_application_id');
    }
    public static function getPrincipalBal($loanaccount, $date = null)
    {
        $date_disbursed = $loanaccount->date_disbursed;
        $amount_disbursed = $loanaccount->amount_disbursed;
        if (!isset($date_disbursed)) {
            $date_disbursed = 0000 - 00 - 00;
        }
        if (!isset($amount_disbursed)) {
            $amount_disbursed = 00;
        }
        $arrears = LoanTransaction::where('loan_application_id', $loanaccount->id)
            ->where('type', 'debit')
            ->where('date', '>', $date_disbursed)
            ->sum('amount');
        $principal_amount = $loanaccount->amount_disbursed + $loanaccount->top_up_amount;// + $arrears;
        $principal_paid = LoanRepayment::getPrincipalPaid($loanaccount, $date);
        $principal_bal = (float)$principal_amount - (float)$principal_paid;
        return $principal_bal;
    }
    public static function getInterestAmount($loanaccount)
    {
        $period = $loanaccount->period;
        $period2 = LoanTransaction::getInstallment($loanaccount, 'period');
        $period2 = round($period2);
        $rate = Loantransaction::getrate($loanaccount);
        $loan_balance = (float)$loanaccount->amount_disbursed + (float)$loanaccount->top_up_amount;
        $total_interest = 0;
        $loanproduct = LoanProduct::findorfail($loanaccount->loan_product_id);
        $formula = $loanproduct->formula;
        if ($formula == "SL") {
            $total_interest = $loan_balance * $rate * $period;
        } else {
            for ($i = 1; $i <= $period; $i++) {
                $installment = Loantransaction::getInstallment($loanaccount);
                $loan_balance -= $installment;
            }
            $total_interest = $loan_balance * -1;
        }
        return $total_interest;
    }
    public static function getLoanBalNoInterest($loanaccount, $date = null)
    {
        $date_disbursed = $loanaccount->date_disbursed;
        $amount_disbursed = $loanaccount->amount_disbursed;
        if (!isset($date_disbursed)) {
            $date_disbursed = 0000 - 00 - 00;
        }
        if (!isset($amount_disbursed)) {
            $amount_disbursed = 00;
        }
        $principal_amount = $loanaccount->amount_disbursed + $loanaccount->top_up_amount;// + $arrears;
        $amount_paid = LoanRepayment::getAmountPaid($loanaccount, $date);
        $loan_bal = $principal_amount - $amount_paid;
        return $loan_bal;
    }
}
