<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class LoanRepayment extends Model
{
    use HasFactory;
    public static function getPrincipalPaid($loanaccount, $date = null)
    {
        if ($date != null) {
            $paid = DB::table('loan_repayments')->where('loan_application_id', '=', $loanaccount->id)->where('date', '>=', $loanaccount->date_disbursed)->where('date', '<=', $date)->sum('principal_paid');
        } else {
            $paid = DB::table('loan_repayments')->where('loan_application_id', '=', $loanaccount->id)->where('date', '>=', $loanaccount->date_disbursed)->sum('principal_paid');
        }
        return $paid;
    }
    public static function getAmountPaid($loanaccount, $date = null)
    {

        if ($date != null) {
            $paid = DB::table('loan_transactions')->where('loan_application_id', '=', $loanaccount->id)->where('date', '>=', $loanaccount->date_disbursed)->where('date', '<=', $date)->where('description', '=', 'loan repayment')->sum('amount');
        } else {
            $paid = DB::table('loan_transactions')->where('loan_application_id', '=', $loanaccount->id)->where('date', '>=', $loanaccount->date_disbursed)->where('description', '=', 'loan repayment')->sum('amount');
        }
        return $paid;
    }
}
