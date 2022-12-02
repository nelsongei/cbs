<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Journal;
use App\Models\Member;
use App\Models\Particular;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class JournalController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $members = Member::where('organization_id',Auth::user()->organization_id)->get();
        $particulars = Particular::where('organization_id',Auth::user()->organization_id)->get();
        $journals = Journal::where('organization_id',Auth::user()->organization_id)->get();
        return view('journals.index',compact('particulars','members','journals'));
    }
    public function store(Request  $request)
    {
        $particular = Particular::findOrFail($request->particular_id);
        $data = array(
            'date' => date('Y-m-d',strtotime($request->input('date'))),
            'debit_account' => $particular->debit_account_id,
            'credit_account' => $particular->credit_account_id,
            'description' => $request->input('description'),
            'amount' => $request->input('amount'),
            //'initiated_by' => $request->input('user'),
            'initiated_by' => Auth::user()->firstname,
            'particulars_id' => $request->input('particular_id'),
            'narration' => $request->input('narration'),
            'bank_reference'=>$request->input('bank_reference'),
        );
        $this->journal_entry($data);
        toast('Success','success','top-right');
        return redirect()->back();

    }
    public function journal_entry($data)
    {
        $trans_no = $this->getTransactionNumber();
        // function for crediting
        $this->creditAccount($data, $trans_no);
        // function for crediting
        $this->debitAccount($data, $trans_no);
        // Insert narration
        $confirm = DB::table('narrations')->where('trans_no', '=', $trans_no)->count();
        if ($confirm <= 0) {
            DB::table('narrations')->insert(array(
                'trans_no' => $trans_no,
                'member_id' => $data['narration'],
                'organization_id'=>Auth::user()->organization_id,
            ));
        }
    }
    public function getTransactionNumber()
    {
        $date = date('Y-m-d H:m:s');
        $trans_no = strtotime($date);
        return $trans_no;
    }
    public function creditAccount($data, $trans_no)
    {

        $journal = new Journal;
        $account = Account::findOrFail($data['credit_account']);
        $journal->account()->associate($account);

        $journal->date = $data['date'];
        $journal->trans_no = $trans_no;
        $journal->initiated_by = $data['initiated_by'];
        $journal->amount = $data['amount'];
        $journal->type = 'credit';
        $journal->particular_id = $data['particulars_id'];
        $journal->description = $data['description'];
        $journal->organization_id = Auth::user()->organization_id;
        $journal->bank_details = $data['bank_reference'];
        //$journal->initiated_by = Auth::user()->firstname;
        $journal->save();
    }


    public function debitAccount($data, $trans_no)
    {
        $journal = new Journal;
        $account = Account::findOrFail($data['debit_account']);
        $journal->account()->associate($account);

        $journal->date = $data['date'];
        $journal->trans_no = $trans_no;
        $journal->initiated_by = $data['initiated_by'];
        $journal->amount = $data['amount'];
        $journal->type = 'debit';
        $journal->particular_id = $data['particulars_id'];
        $journal->description = $data['description'];
        $journal->organization_id = Auth::user()->organization_id;
        $journal->bank_details = $data['bank_reference'];
      //  $journal->initiated_by = Auth::user()->firstname;
        $journal->save();
    }
}
