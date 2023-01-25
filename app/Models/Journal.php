<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Journal extends Model
{
    use HasFactory;
    public function account()
    {
        return $this->belongsTo(Account::class);
    }
    public function journal_entry($data)
    {
        $trans_no = $this->getTransactionNumber();
        //dd($trans_no);
        // function for crediting
        $this->creditAccount($data, $trans_no);
        // function for crediting
        $this->debitAccount($data, $trans_no);
        // Insert narration
        $confirm = DB::table('narrations')->where('trans_no', '=', $trans_no)->count();
    //    dd($confirm);
//        $narration = new Narration();
//        $narration->trans_no = $trans_no;
//        $narration->member_id = 1;
//        $narration->organization_id = Auth::user()->organization_id;
//        $narration->save();
        if ($confirm <= 0) {
            DB::table('narrations')->insert(array(
                'trans_no' => $trans_no,
                'member_id' => $data['narration'],
                'organization_id'=>Auth::user()->organization_id,
                'created_at'=>now(),
                'updated_at'=>now(),
            ));
        }
    }

    public static function getTransactionNumber()
    {
        $date = date('Y-m-d H:m:s');
        $trans_no = strtotime($date);
        return $trans_no;
    }
    public function creditAccount($data, $trans_no)
    {
        
        $journal = new Journal;
        $account = Account::findOrFail($data['credit_account']);
        $journal->account_id = $data['credit_account'];
        $journal->account()->associate($account);
        $journal->organization_id = Auth::user()->organization_id;
        $journal->date = date('Y-m-d',strtotime($data['date']));
        $journal->trans_no = $trans_no;
        $journal->transaction_type_id = $data['transaction_type_id'];
        $journal->initiated_by = $data['initiated_by'];
        $journal->amount = $data['amount'];
        $journal->type = 'credit';
        $journal->particular_id = $data['particulars_id'];
        $journal->description = $data['description'];
        $journal->bank_details = 'Test';
        $journal->save();
    }
    public function debitAccount($data, $trans_no)
    {
        $journal = new Journal;
        $account = Account::findOrFail($data['debit_account']);
        //$journal->account()->associate($account);
        $journal->account_id = $data['debit_account'];
        $journal->organization_id = Auth::user()->organization_id;
        $journal->date = date('Y-m-d',strtotime($data['date']));
        $journal->trans_no = $trans_no;
        $journal->transaction_type_id = $data['transaction_type_id'];
        $journal->initiated_by = $data['initiated_by'];
        $journal->amount = $data['amount'];
        $journal->type = 'debit';
        $journal->particular_id = $data['particulars_id'];
        $journal->description = $data['description'];
        $journal->bank_details = 'Test';
        $journal->save();
    }
    public function particular()
    {
        return $this->belongsTo(Particular::class);
    }
}
