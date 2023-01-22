<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class LoanPosting extends Model
{
    use HasFactory;

    public static function getPostingAccount($loanproduct, $transaction){
        try {
            $posting =
                //LoanPosting::where('loan_product_id',$id)->where('transaction',$transaction)->get();
            DB::table('loan_postings')->where('loan_product_id', $loanproduct->id)->where('transaction', '=', $transaction)->get();
            for ($i=0;$i<count($posting);$i++)
            {
                $credit_account = $posting[$i]->credit_account_id;
                $debit_account = $posting[$i]->debit_account_id;
            }
            $accounts = array('debit'=>$debit_account, 'credit'=>$credit_account);
            return $accounts;
        }catch (\Exception $e)
        {

        }
    }
}
