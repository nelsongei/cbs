<?php

namespace App\Http\Controllers;

use App\Exports\SavingExport;
use App\Imports\SavingImport;
use App\Models\Journal;
use App\Models\Member;
use App\Models\Particular;
use App\Models\Saving;
use App\Models\SavingAccount;
use App\Models\SavingProduct;
use Barryvdh\DomPDF\Facade\Pdf;
use DateInterval;
use DatePeriod;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;


class SavingController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $products = SavingProduct::where('organization_id', Auth::user()->organization_id)->get();
        $savings = Saving::where('organization_id', Auth::user()->organization_id)->paginate(10);
        $savingaccounts = SavingAccount::where('organization_id', Auth::user()->organization_id)->get();
        return view('saving.index', compact('savingaccounts', 'savings', 'products'));
    }
    public function exportTemplate()
    {
        return Excel::download(new SavingExport, 'savig.xlsx');
    }
    public function store(Request $request)
    {
        $particular = (Particular::where('name', 'LIKE', '%' . 'member savings' . '%')->first());
        $member = SavingAccount::where('account_number', trim(explode(':', $request->account)[1]))->first();
        if ($particular == null) {
            toast('Add A Particular Item with name member savings', 'info');
        } else {
            //Bank Withdraw
            if ($request->type == 'debit' && $request->payment_method == 'Bank') {
                foreach ($member->product->postings as $posting) {
                    if ($posting->transaction == 'withdrawal') {
                        //dd(Auth::user()->firstname);
                        $debit_account = $posting->debit_account_id;
                        $credit_account = $posting->credit_account_id;
                        $data = array(
                            'credit_account' => $credit_account,
                            'debit_account' => $debit_account,
                            'date' => $request->date,
                            'amount' => $request->saving_amount,
                            'initiated_by' => Auth::user()->firstname,
                            'description' => $request->description,
                            'bank_details' => $request->bank_sadetails ? '' : null,

                            'particulars_id' => $particular->id,
                            'narration' => $member->id
                        );
                        $journal = new Journal();
                        $journal->journal_entry($data);
                       // $this->withdrawalCharges($member, $request->date, $request->saving_amount, $request);
                    }
                }
            }
            //Cash Withdrawals
            if ($request->type == 'debit' && $request->payment_method == 'Cash') {
                foreach ($member->product->postings as $posting) {
                    if ($posting->payment_method == 'withdrawal_cash') {
                        $debit_account = $posting->debit_account_id;
                        $credit_account = $posting->credit_account_id;
                        $data = array(
                            'credit_account' => $credit_account,
                            'debit_account' => $debit_account,
                            'date' => $request->date,
                            'amount' => $request->saving_amount,
                            'initiated_by' => Auth::user()->firstname,
                            'description' => $request->description,
                            'bank_details' => $request->bank_sadetails ? '' : null,

                            'particulars_id' => $particular->id,
                            'narration' => $member->id
                        );
                        $journal = new Journal();
                        $journal->journal_entry($data);
                        
                    }
                    $this->withdrawalCharges($member, $request->date, $request->saving_amount, $request);
                }
            }
            //Bank Deposit
            if ($request->type == 'credit' && $request->payment_method == 'Bank') {
                foreach ($member->product->postings as $posting) {
                    if ($posting->payment_method == 'deposit') {
                        $debit_account = $posting->debit_account_id;
                        $credit_account = $posting->credit_account_id;
                        $data = array(
                            'credit_account' => $credit_account,
                            'debit_account' => $debit_account,
                            'date' => $request->date,
                            'amount' => $request->saving_amount,
                            'initiated_by' => Auth::user()->firstname,
                            'description' => $request->description,
                            'bank_details' => $request->bank_sadetails ? '' : null,

                            'particulars_id' => $particular->id,
                            'narration' => $member->id
                        );
                        $journal = new Journal();
                        $journal->journal_entry($data);
                    }
                }
            }
            //Cash Deposit
            if ($request->type == 'credit' && $request->payment_method == 'Bank') {
                foreach ($member->product->postings as $posting) {
                    if ($posting->payment_method == 'deposit_cash') {
                        $debit_account = $posting->debit_account_id;
                        $credit_account = $posting->credit_account_id;
                        $data = array(
                            'credit_account' => $credit_account,
                            'debit_account' => $debit_account,
                            'date' => $request->date,
                            'amount' => $request->saving_amount,
                            'initiated_by' => Auth::user()->firstname,
                            'description' => $request->description,
                            'bank_details' => $request->bank_sadetails ? '' : null,

                            'particulars_id' => $particular->id,
                            'narration' => $member->id
                        );
                        $journal = new Journal();
                        $journal->journal_entry($data);
                    }
                }
            }
            $saving = new Saving();
            $saving->member_id = $member->member_id;
            $saving->organization_id = Auth::user()->organization_id;
            $saving->saving_account_id = $member->id;
            $saving->saving_amount = $request->saving_amount;
            $saving->type = $request->type;
            $saving->date = $request->date;
            $saving->payment_method = $request->payment_method;
            $saving->bank_sadetails = $request->bank_sadetails ? '' : null;
            $saving->transacted_by = trim(explode(':', $request->account)[0]);
            $saving->management_fee = null;
            $saving->description = $request->description;
            $saving->save();
            if ($saving) {
                toast('Successfully', 'success');
            }
        }
        //
        return redirect()->back();
    }
    public function withdrawalCharges($account, $date, $amount, $request)
    {
        // dd($request->all());
        foreach ($account->product->charges as $charge) {
            if ($charge->payment_method == 'withdrawal') {
                if ($charge->calculation_method == 'percent') {
                    $amount = ($charge->amount / 100) * $amount;
                }

                if ($charge->calculation_method == 'flat') {
                    $amount = $charge->amount;
                }
                $saving = new Saving();
                $saving->member_id = $account->member_id;
                $saving->organization_id = Auth::user()->organization_id;
                $saving->saving_account_id = $account->id;
                $saving->saving_amount = $amount;
                $saving->type = $request->type;
                $saving->date = $request->date;
                $saving->payment_method = $request->payment_method;
                $saving->bank_sadetails = $request->bank_sadetails ? '' : null;
                $saving->transacted_by = trim(explode(':', $request->account)[0]);
                $saving->management_fee = null;
                $saving->description = 'withdrawal charge';
                $saving->save();
                foreach ($account->product->postings as $posting) {
                    if ($posting->transaction == 'charge') {
                        // dd($posting);
                        $debit_account = $posting->debit_account;
                        $credit_account = $posting->credit_account;
                        $data = array(
                            'credit_account' => $credit_account,
                            'debit_account' => $debit_account,
                            'date' => $date,
                            'amount' => $amount,
                            'initiated_by' => 'system',
                            'description' => 'cash withdrawal'
                        );
                        $journal = new Journal;
                        $journal->journal_entry($data);
                    }
                }
            }
        }
        return redirect()->back();
    }
    public function receipt($id)
    {
        $saving = Saving::where('id', $id)->findOrFail($id);
        return  Pdf::loadView('pdf.saving-receipt', compact('saving'))->setPaper('A6', 'portrait')->download();
    }
    public function view($id)
    {
        $saving = Saving::find($id);
        $oldDate = new DateTime($saving->date);
        $newDate = new DateTime();
        $months = $oldDate->diff($newDate);
        $month = $months->m;
        $newMonths =  array(date('M', strtotime($saving->date)));
        $start =  new DateTime($saving->date);
        $start->modify('first day of this month');
        $end  = new DateTime();
        $interval = DateInterval::createFromDateString('1 month');
        $period = new DatePeriod($start, $interval, $end);
        $principal = $saving->saving_amount;
        $rate = ($saving->account->product->interest_rate) / 100;
        return view('saving.view-saving', compact('saving', 'principal', 'period', 'rate', 'month'));
    }
    public function upload(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file;
            if ($file) {
                $excel = (new SavingImport)->toArray($file);
                foreach ($excel[0] as $e) {
                    //dd($e[1]);
                    //dd();
                    if ($e[0] !== null && $e[1] !== null && $e[2] !== null) {
                        $account = SavingAccount::where('account_number', trim(explode(':', $e[1])[1]))->first();
                        // dd($account);
                        $date = date('Y-m-d', strtotime($e[0]));
                        $this->importSaving($account->member_id, $date, $account->id, $e[2], $e[3], $e[4], $e[5], $e[6], $account);
                    }
                }
            }
        } else {
            toast('Upload A XLSX File', 'warning');
        }
        return redirect()->back();
    }
    public function importSaving($member, $date, $savingId, $amount, $type, $description, $bank_ref, $method, $account)
    {
        $particular = (Particular::where('name', 'LIKE', '%' . 'member savings' . '%')->first());
        if ($particular == null) {
            toast('Add A Particular Item with name member savings', 'info');
        } else {
            foreach ($account->product->postings as $posting) {
                if ($method == 'Cash' && $posting->transaction == 'deposit_cash') {
                    $debit_account = $posting->debit_account_id;
                    $credit_account = $posting->credit_account_id;
                    $data = array(
                        'credit_account' => $credit_account,
                        'debit_account' => $debit_account,
                        'date' => $date,
                        'amount' => $amount,
                        'initiated_by' => 'system',
                        'description' => $description,
                        'bank_details' => $bank_ref ? '' : null,

                        'particulars_id' => $particular->id,
                        'narration' => $account->id
                    );
                    $journal = new Journal();
                    $journal->journal_entry($data);
                } elseif ($method == 'Bank' && $posting->transaction == 'deposit') {
                    $debit_account = $posting->debit_account_id;
                    $credit_account = $posting->credit_account_id;
                    $data = array(
                        'credit_account' => $credit_account,
                        'debit_account' => $debit_account,
                        'date' => $date,
                        'amount' => $amount,
                        'initiated_by' => 'system',
                        'description' => $description,
                        'bank_details' => $bank_ref ? '' : null,
                        'particulars_id' => $particular->id,
                        'narration' => $account->id
                    );
                    $journal = new Journal();
                    $journal->journal_entry($data);
                }
            }
            $saving = new Saving();
            $saving->member_id = $member;
            $saving->organization_id = Auth::user()->organization_id;
            $saving->saving_account_id = $savingId;
            $saving->saving_amount = $amount;
            $saving->type = $type;
            $saving->date = $date;
            $saving->payment_method = $method;
            $saving->bank_sadetails = $bank_ref ? $bank_ref : null;
            $saving->transacted_by = Auth::user()->firstname;
            $saving->management_fee = null;
            $saving->description = $description;
            $saving->save();
            if ($saving) {
                toast('Successfully Added Savings', 'success');
            }
        }
    }
    public function exportSavings(Request $request)
    {
        $account =  SavingAccount::where('id', $request->type)->get();
        // $account->
        // dd($request->all());
    }
    public function balance($id)
    {
        $ids = (trim(explode(':', $id)[1]));
        $account = SavingAccount::where('account_number', $ids)->get();
        $balance  =  Saving::where('member_id', $account[0]->member_id)->sum('saving_amount');
        $member = Member::find($account[0]->member_id);
        return response()->json(['member' => $member, 'balance' => $balance, 'account' => $account]);
    }
}
