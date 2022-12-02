<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class LoanPosting extends Model
{
    use HasFactory;

    public static function getPostingAccount($loanproduct, $transaction){
        //dd($transaction);
        $posting = DB::table('loan_postings')->where('loan_product_id', '=', $loanproduct->id)->where('transaction', '=', $transaction)->get();
        //dd($posting);
        foreach ($posting as $posting) {

            $credit_account = $posting->credit_account_id;
            $debit_account = $posting->debit_account_id;
        }


        $accounts = array('debit'=>$debit_account, 'credit'=>$credit_account);

        return $accounts;


    }
}
