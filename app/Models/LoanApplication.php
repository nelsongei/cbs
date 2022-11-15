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
}
