<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class AccountTransaction extends Model
{
    use HasFactory;
    public function createTransaction($data){
        $acTr = new AccountTransaction;

        $acTr->transaction_date = date('Y-m-d',strtotime($data['date']));
        $acTr->organization_id = Auth::user()->organization_id;
        $acTr->description = $data['description'];
        $acTr->debit_account_id = $data['debit_account'];
        $acTr->credit_account_id = $data['credit_account'];
        $acTr->transaction_amount = $data['amount'];
        $acTr->is_bank= 1;
        $acTr->bank_account_id=0;
        $acTr->type='credit';
        $acTr->initiated_by=$data['initiated_by'];
        $acTr->form=null;
        $acTr->bank_transaction_id=0;
        $acTr->bank_statement_id=0;
        $acTr->status=null;
        $acTr->save();

        return $acTr->id;
    }
    public function pettycount(){
        $count = PettyCashItem::where('account_transaction_id', '=', $this->id)->count();
        return $count;
    }
}
