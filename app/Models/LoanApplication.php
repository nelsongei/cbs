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
    public static function getLoanAmount($loanaccount)
    {
        $interest_amount = LoanApplication::getInterestAmount($loanaccount);
        $principal = $loanaccount->approved->amount_approved;
        $topup = $loanaccount->top_up_amount;
        $overcharge = LoanApplication::getOverchargeAmount($loanaccount);
        $amount = $principal + $interest_amount + $topup;
        #$amount=$amount-$overcharge; if((float)$amount<1){$amount=0;}
        return $amount;
    }
    public static function getOverchargeAmount($loanaccount)
    {
        //$overcharge = DB::table('loan_applications')->where('member_id', '=', $loanaccount->member_id)->where('loan_product_id', '=', $loanaccount->loanproduct_id)->sum('amount_overpaid');
        $overcharge = LoanApplication::where('member_id',$loanaccount->member_id)->where('loan_product_id',$loanaccount->loan_product_id)->sum('amount_overpaid');
        if (empty($overcharge) || (float)$overcharge < 1) {
            $overcharge = 0;
        }
        return $overcharge;
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
    public function topups()
    {
        return $this->hasMany(LoanTopup::class);
    }
    public static function getPrincipalBal($loanaccount, $date = null)
    {
        $date_disbursed = $loanaccount->date_disbursed;
        $amount_disbursed = $loanaccount->approved->amount_approved;
        if (!isset($date_disbursed)) {
            $date_disbursed = 0000 - 00 - 00;
        }
        if (!isset($amount_disbursed)) {
            $amount_disbursed = 00;
        }
        if (isset($loanaccount->date_disbursed)) {
            $arrears = LoanTransaction::where('loan_application_id', $loanaccount->id)
                ->where('type', 'debit')
                ->where('date', '>', $date_disbursed)
                ->sum('amount');
        }
        //dd($arrears);
        #ToDo Check Relationship for TopUp Amount
        $principal_amount = $loanaccount->approved->amount_approved + $loanaccount->topups->sum('amount_topup');// + $arrears;

        $principal_paid = LoanRepayment::getPrincipalPaid($loanaccount, $date);
        $principal_bal = (float)$principal_amount - (float)$principal_paid;
        return $principal_bal;
    }
    public static function getInterestAmount($loanaccount)
    {
        $period = $loanaccount->period;
        $period2 = LoanTransaction::getInstallment($loanaccount, 'period');
        // dd($period2);
        
        $period2 = round($period2);
        $rate = LoanTransaction::getrate($loanaccount);
        $loan_balance = (float)$loanaccount->approved->amount_approved + (float)$loanaccount->topups->sum('amount_topup');
    //    dd($loan_balance);
        $total_interest = 0;
        $loanproduct = LoanProduct::findorfail($loanaccount->loan_product_id);
        // dd($loanproduct);
        $formula = $loanproduct->formula;
        $amortization = $loanproduct->amortization;
        if ($formula == "SL" && $amortization==='EP') {
            for($i=0;$i<$period;$i++)
            {
                
            }
            // $total_interest = $loan_balance * $rate * $period;
            // dd($total_interest);
            
        } else {
            for ($i = 1; $i <= $period; $i++) {
                $installment = LoanTransaction::getInstallment($loanaccount);
                $loan_balance -= $installment;
            }
            $total_interest = $loan_balance * -1;
        }
        // dd($total_interest);
        return $total_interest;
    }
    public static function getLoanBalNoInterest($loanaccount, $date = null)
    {
        $date_disbursed = $loanaccount->date_disbursed;
        $amount_disbursed = $loanaccount->approved->amount_approved;

        if (!isset($date_disbursed)) {
            $date_disbursed = 0000 - 00 - 00;
        }
        if (!isset($amount_disbursed)) {
            $amount_disbursed = 00;
        }
        $principal_amount = $loanaccount->approved->amount_approved + $loanaccount->topups->sum('amount_topup');// + $arrears;
        //dd($principal_amount);

        $amount_paid = LoanRepayment::getAmountPaid($loanaccount, $date);

        $loan_bal = $principal_amount - $amount_paid;


        return $loan_bal;
    }
    public function transactions()
    {
        return $this->hasMany(LoanTransaction::class,'loan_application_id');
    }
    public static function getTotalDue($loanaccount)
    {
        $balance = LoanTransaction::getLoanBalance($loanaccount);
        if ($balance > 1) {
            $principal = LoanTransaction::getPrincipalDue($loanaccount);
            $interest = LoanTransaction::getInterestDue($loanaccount);
            $total = $principal + $interest;
            return $total;
        } else {
            return 0;
        }
    }
    public function gurantors()
    {
        return $this->hasMany(LoanGuarantor::class,'loan_application_id');
    }
}
