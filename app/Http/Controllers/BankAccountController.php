<?php

namespace App\Http\Controllers;

use App\Exports\BankStatement as ExportsBankStatement;
use App\Imports\BankStatementImport;
use App\Models\Account;
use App\Models\AccountCategory;
use App\Models\AccountTransaction;
use App\Models\BankAccount;
use App\Models\BankStatement;
use App\Models\Journal;
use App\Models\Particular;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class BankAccountController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $bank_accounts = BankAccount::where('organization_id', Auth::user()->organization_id)->orderBy('id')->get();
        $acc= AccountCategory::where('name', 'like','%'.'ASSET'.'%')->pluck('id')->first();
        $bkAccounts = Account::where('account_category_id',$acc)->get();
        return view('banking.accounts', compact('bank_accounts', 'bkAccounts'));
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'bank_name' => 'required',
            'account_name' => 'required',
            'account_number' => 'required'
        ]);
        if ($validate->fails()) {
            toast($validate->errors()->all(), 'warning');
        } else {
            $account = new BankAccount();
            $account->organization_id = Auth::user()->organization_id;
            $account->bank_name = $request->bank_name;
            $account->account_name = $request->account_name;
            $account->account_number = $request->account_number;
            $account->save();
            toast('SUccessfully added bank account', 'success');
        }
        return redirect()->back();
    }

    public function uploadStatement(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'stmt_month' => 'required',
            'bal_bd' => 'required',
            'bknStatementCSV' => 'required',
        ]);
        if ($validate->fails()) {
            toast($validate->errors()->all(), 'info');
        } else {
            if ($request->hasFile('bknStatementCSV')) {
                $csv_file = $request->file('bknStatementCSV');
                if ($csv_file->isValid()) {
                    //dd(storage_path().'/app/public'.'/bankStatements/');
                    if (is_dir($destination = storage_path() . '/app/public' . '/bankStatements/')) {
                        chmod($destination, 0777);
                    } else {
                        mkdir($destination, 0777, true);
                    }
                    $fileName = 'bnkStatement';
                    $fileName = $fileName . '_' . $request->stmt_month;
                    $ext = $csv_file->getClientOriginalExtension();
                    $file = $fileName . '.' . $ext;
                    if (file_exists($destination . $file)) {
                        dd('File Exists');
                    } else {
                        $bank_statement = new BankStatement();
                        $bank_statement->organization_id = Auth::user()->organization_id;
                        $bank_statement->bank_account_id = $request->bnk_id;
                        $bank_statement->bal_bd = $request->bal_bd;
                        $bank_statement->stmt_month = $request->stmt_month;
                        $bank_statement->file_path = $file;
                        $bank_statement->save();
                        $this->importFileContents($request, $bank_statement->id);
                        toast('Successfully uploaded Bank Statements', 'success');
                    }
                } else {
                    toast('Upload a CSV/XLSX File', 'danger');
                }
            }
        }
        return redirect()->back();
    }

    public function importFileContents($request, $id)
    {
        Excel::import(new BankStatementImport($id), $request->file('bknStatementCSV'));
    }

    public function deposit()
    {
        $bankAccs = BankAccount::where('organization_id', Auth::user()->organization_id)->get();
        $transactions = AccountTransaction::where("is_bank", 1);
        return view('banking.bank_deposit', compact('bankAccs'));
    }

    public function showReconcile(Request $request, $id)
    {
        //dd($request->all());
        $ac_stmt_id = $request->book_account_id;
        $rec_month = $request->rec_month;
        $bstmtid = BankStatement::where('bank_account_id', $id)->where('stmt_month', $request->rec_month)->pluck('id')->first();
        $bnkAccount = DB::table('bank_accounts')
            ->join('bank_statements', 'bank_accounts.id', '=', 'bank_statements.bank_account_id')
            ->where('bank_statements.stmt_month', $request->rec_month)
            ->where('bank_accounts.id', $id)
            ->select('bank_accounts.*', 'bank_statements.bal_bd as bal_bd', 'bank_statements.stmt_month as stmt_month',
                'bank_statements.created_at as stmt_date')
            ->first();
        $bAcc = DB::table('bank_statements')
            ->where('bank_statements.bank_account_id', $id)
            ->get();
        $bAccStmt = DB::table('stmt_transactions')
            ->where('stmt_transactions.bank_statement_id', $bstmtid)
            ->get();

        $stmt_transactions = DB::table('stmt_transactions')
            ->where('stmt_transactions.bank_statement_id', $bstmtid)
            ->where('stmt_transactions.status', '<>', 'RECONCILED')
            ->select('*')
            ->get();

        $query = DB::table('journals');
        $ac_transaction = $query->where(function ($query) use ($ac_stmt_id) {
            $query->where('account_id', $ac_stmt_id);
            //->orWhere('account_credited', $ac_stmt_id);
        })->where(function ($query) use ($rec_month) {
            $query->where('is_reconciled', '<>', 1)
                ->whereMonth('date', '=', substr($rec_month, 0, 2))
                ->whereYear('date', '=', substr($rec_month, 3, 4));
        })
            ->select('*')
            ->get();
        $transacs = array();
        $ref_no = array();

        foreach ($ac_transaction as $act) {
            # code...
            if (!empty($act->bank_details)) {
                if (!key_exists($act->bank_details, $transacs)) {
                    $transacs[$act->bank_details] = array(

                        'id' => $act->id,
                        'type' => $act->type,
                        'date' => $act->date,
                        'account_id' => $act->account_id,
                        'description' => $act->description,
                        'bank_details' => $act->bank_details,
                        'amount' => $act->amount
                    );
                } else {

                    $transacs[$act->bank_details]['amount'] += $act->amount;
                }

            } else {
                if (!key_exists($act->trans_no, $ref_no)) {
                    $ref_no[$act->trans_no] = array(

                        'id' => $act->id,
                        'type' => $act->type,
                        'date' => $act->date,
                        'account_id' => $act->account_id,
                        'description' => $act->description,
                        'bank_details' => $act->bank_details,
                        'amount' => $act->amount
                    );
                } else {

                    $ref_no[$act->trans_no]['amount'] += $act->amount;
                }
            }
        }
        //first day of the month
        $startMonth = date('Y-m-d', strtotime('01-' . $rec_month));
        //Next month

        $endMonth = date('m-Y', strtotime('+31 days' . $startMonth));
        //First day of the next month
        $endMonthone = date('Y-m-d', strtotime('01-' . $endMonth));
        // Last day of bankstatement month
        $to = date('Y-m-d', strtotime('-1days' . $endMonthone));
        $accounts = Journal::whereBetween('date', array($startMonth, $to))->where('is_reconciled', '=', 1)->where('account_id', '=', $ac_stmt_id)->whereNotNull('bank_details')->get();

        $count = count($accounts);

        $bkTotal = 0;
        //$details=array();
        foreach ($accounts as $acnt) {

            if ($acnt->account_id == $ac_stmt_id && $acnt->type == 'debit') {
                $bkTotal += $acnt->amount;
            } else if ($acnt->account_id == $ac_stmt_id && $acnt->type == 'credit') {
                $bkTotal -= $acnt->amount;
            }
        }
        $bnk_stmt_id = $id;
        $bankBalBD = DB::table('bank_statements')
            ->where('id', $bnk_stmt_id)
            ->pluck('bal_bd')->first();


        // Check if book bal and bank balance matches
        if ($bankBalBD == $bkTotal) {
            if (DB::table('bank_statements')->where('id', $bnk_stmt_id)->count() > 0) {
                $bankStmt = BankStatement::where('id', $bnk_stmt_id)->first();
                if ($bankStmt->is_reconciled !== 1) {
                    $bankStmt->adj_bal_bd = $bkTotal;
                    $bankStmt->is_reconciled = 1;
                    $bankStmt->update();
                }
            }
        }

        $lastRec = DB::table('bank_statements')
            ->where('bank_account_id', $bnk_stmt_id)
            ->where('is_reconciled', 1)
            ->select('stmt_month')
            ->orderBy('stmt_month', 'DESC')
            ->first();
        return view('banking.reconcile',compact('bnkAccount', 'bAcc', 'transacs', 'ref_no', 'bAccStmt', 'stmt_transactions', 'ac_transaction', 'ac_stmt_id', 'rec_month', 'bnk_stmt_id', 'bkTotal', 'count', 'lastRec', 'bstmtid'));
    }
    #ToDo Recheck this code 👇
    public function reconcile($bid, $aid)
    {
        $accounts = DB::table('account_transactions')
            ->where('status', '=', 'RECONCILED')
            ->where('bank_statement_id', $bid)
            ->select('account_credited', 'account_debited', 'transaction_amount')
            ->get();
        $account = Account::find($aid);
        $statement = BankStatement::find($bid);
        $rec_month = $statement->stmt_month;
        $date = date('Y-m-d', strtotime('-1 day', strtotime('01-' . $rec_month)));
        $bkTotal = Account::getAccountBalanceAtDate($account, $date);

        foreach ($accounts as $acnt) {

            if ($acnt->account_debited == $account->id) {
                $bkTotal += $acnt->transaction_amount;
            } else if ($acnt->account_credited == $account->id) {
                $bkTotal -= $acnt->transaction_amount;
            }
        }

        $statement->is_reconciled = 1;
        $statement->adj_bal_bd = $bkTotal;
        $statement->update();

        return redirect('bankAccounts')->with('success', 'Statement reconciled successfully');
    }
    public function transact()
    {
        return view('banking.transact');
    }
    public function payment(Request  $request)
    {
        $data = $request->all();
        //credit cash account and debit bank account
        if($data['type'] == 'payment'){
            $credit_account = Account::where('name', 'like', '%'.'Cash Account'.'%')->pluck('id')->first();
            $debit_account = Account::where('name', 'like', '%'.'Bank Account'.'%')->pluck('id')->first();
            $particulars = Particular::where('name', 'like', '%'.'bank deposits'.'%')->first();
            $type='deposit';
            if (empty($credit_account))
            {
                $account = new Account();
                $account->organization_id = Auth::user()->organization_id;
                $account->category = "ASSET";
                $account->code = 1000;
                $account->active = true;
                $account->name = "Cash Account";
                $account->save();
                $account = new Account();
                $account->organization_id = Auth::user()->organization_id;
                $account->category = "EXPENSE";
                $account->code = 3000;
                $account->active = true;
                $account->name = "Bank Account";
                $account->save();
            }
            if(empty($particulars)){
                $particulars = new Particular;
                $particulars->organization_id = Auth::user()->organization_id;
                $particulars->name='Bank Deposits';
                $particulars->credit_account_id =$credit_account;
                $particulars->debit_account_id =$debit_account;
                $particulars->save();

            }

        }//else debit cash/expense account and credit bank account
        elseif ($data['type'] == 'disbursal') {
            $debit_account = Account::where('name', 'like', '%'.'Cash Account'.'%')->pluck('id')->first();
            $credit_account = Account::where('name', 'like', '%'.'Bank Account'.'%')->pluck('id')->first();
            $particulars = Particular::where('name', 'like', '%'.'bank withdrawals'.'%')->first();
            $type="withdraw";
            if (empty($credit_account))
            {
                $account = new Account();
                $account->organization_id = Auth::user()->organization_id;
                $account->category = "ASSET";
                $account->code = 1000;
                $account->active = true;
                $account->name = "Cash Account";
                $account->save();
                $account = new Account();
                $account->organization_id = Auth::user()->organization_id;
                $account->category = "EXPENSE";
                $account->code = 3000;
                $account->active = true;
                $account->name = "Bank Account";
                $account->save();
            }
            if(empty($particulars)){
                $particulars = new Particular;
                $particulars->organization_id = Auth::user()->organization_id;
                $particulars->name = 'Bank withdrawals';
                $particulars->credit_account_id = $credit_account;
                $particulars->debit_account_id = $debit_account;
                $particulars->save();
            }
        }

        //return $particulars;
        $data = array(
            'date' => $data['date'],
            'description' => $data['description'],
            'amount' => $data['amount'],
            'debit_account' => $debit_account,
            'credit_account' => $credit_account,
            'initiated_by' => Auth::user()->firstname.' '.Auth::user()->lastname,
            'particulars_id' => $particulars->id,
            'batch_transaction_no' => $data['bankrefno'],
            'bank_account' => $data['bankAcc'],
            'payment_form' => $data['payment_form'],
            'type' => $type,
            'narration' => 0
        );
        //$journal = new Journal;
        //$journal->journal_entry($data);
        $accounttransaction= new AccountTransaction;
        $accounttransaction->createTransaction($data);
        toast('Success','success');
        return redirect()->back();
    }
    public function exportTemplate()
    {
        return Excel::download(new ExportsBankStatement(),'bankstatement.xlsx');
    }
}
