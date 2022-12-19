<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class SavingPosting extends Model
{
    use HasFactory;
    public function create_post_rules($product, $fee_income_acc, $saving_control_acc, $cash_account, $bank_account)
    {
        //create posting rule for bank deposit transaction
        if (!empty($bank_account)) {
            $posting = SavingPosting::where('transaction', 'deposit')->where('saving_product_id', '=', $product->id)->first();

            if (empty($posting)) {
                $posting = new SavingPosting;
            }


            $posting->transaction = 'deposit';
            $posting->organization_id = Auth::user()->organization_id;
            $posting->debit_account_id = $bank_account;
            $posting->credit_account_id = $saving_control_acc;
            $posting->savingproduct()->associate($product);
            $posting->save();


            //create posting rule for withdrawal transaction

            $posting = SavingPosting::where('transaction', 'withdrawal')->where('saving_product_id', '=', $product->id)->first();

            if (empty($posting)) {
                $posting = new SavingPosting;
            }


            $posting->transaction = 'withdrawal';
            $posting->organization_id = Auth::user()->organization_id;
            $posting->debit_account_id = $saving_control_acc;
            $posting->credit_account_id = $bank_account;
            $posting->savingproduct()->associate($product);
            $posting->save();


            //create posting rule for charge transaction
            $posting = SavingPosting::where('transaction', 'charge')->where('saving_product_id', '=', $product->id)->first();

            if (empty($posting)) {
                $posting = new SavingPosting;
            }


            $posting->transaction = 'charge';
            $posting->organization_id = Auth::user()->organization_id;
            $posting->debit_account_id = $bank_account;
            $posting->credit_account_id = $fee_income_acc;
            $posting->savingproduct()->associate($product);
            $posting->save();


        }

//create posting rule for cash deposit transaction
        if (!empty($cash_account)) {
            $posting = Savingposting::where('transaction', 'deposit_cash')->where('saving_product_id', '=', $product->id)->first();

            if (empty($posting)) {
                $posting = new Savingposting;
            }


            $posting->transaction = 'deposit_cash';
            $posting->organization_id = Auth::user()->organization_id;
            $posting->debit_account_id = $cash_account;
            $posting->credit_account_id = $saving_control_acc;
            $posting->savingproduct()->associate($product);
            $posting->save();


            //create posting rule for withdrawal transaction

            $posting = Savingposting::where('transaction', 'withdrawal_cash')->where('saving_product_id', '=', $product->id)->first();

            if (empty($posting)) {
                $posting = new Savingposting;
            }


            $posting->transaction = 'withdrawal_cash';
            $posting->organization_id = Auth::user()->organization_id;
            $posting->debit_account_id = $saving_control_acc;
            $posting->credit_account_id = $cash_account;
            $posting->savingproduct()->associate($product);
            $posting->save();


            //create posting rule for charge transaction
            $posting = Savingposting::where('transaction', 'charge_cash')->where('saving_product_id', '=', $product->id)->first();

            if (empty($posting)) {
                $posting = new Savingposting;
            }


            $posting->transaction = 'charge_cash';
            $posting->organization_id = Auth::user()->organization_id;
            $posting->debit_account_id = $cash_account;
            $posting->credit_account_id = $fee_income_acc;
            $posting->savingproduct()->associate($product);
            $posting->save();


        }
    }
    public function savingproduct()
    {

        return $this->belongsTo(SavingProduct::class,'saving_product_id');
    }
}
