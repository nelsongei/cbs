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
    public static function getMemberAmountUnpaid($member_id)
    {
        $loanaccounts = LoanApplication::where('member_id', '=', $member_id)->get();
        $allUnpaid = 0;
        foreach ($loanaccounts as $loanaccount) {
            $unpaid = Loantransaction::getAmountUnpaid($loanaccount);
            $allUnpaid += $unpaid;
        }
        return $allUnpaid;
    }
    public function getAmountUnpaid($loanaccount){
        return $loanaccount;
    }
}
