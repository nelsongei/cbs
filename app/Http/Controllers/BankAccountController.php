<?php

namespace App\Http\Controllers;

use App\Imports\BankStatementImport;
use App\Models\Account;
use App\Models\BankAccount;
use App\Models\BankStatement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $bkAccounts = Account::where('category','ASSET')->get();
        return view('banking.accounts', compact('bank_accounts','bkAccounts'));
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
        if ($validate->fails())
        {
            toast($validate->errors()->all(),'info');
        }
        else{
            if ($request->hasFile('bknStatementCSV'))
            {
                $csv_file = $request->file('bknStatementCSV');
                if ($csv_file->isValid())
                {
                    //dd(storage_path().'/app/public'.'/bankStatements/');
                    if (is_dir($destination = storage_path().'/app/public'.'/bankStatements/')) {
                        chmod($destination, 0777);
                    } else {
                        mkdir($destination, 0777, true);
                    }
                    $fileName = 'bnkStatement';
                    $fileName = $fileName.'_'.$request->stmt_month;
                    $ext = $csv_file->getClientOriginalExtension();
                    $file = $fileName.'.'.$ext;
                    if (file_exists($destination.$file))
                    {
                        dd('File Exists');
                    }
                    else{
                        $bank_statement = new BankStatement();
                        $bank_statement->organization_id = Auth::user()->organization_id;
                        $bank_statement->bank_account_id = $request->bnk_id;
                        $bank_statement->bal_bd  = $request->bal_bd;
                        $bank_statement->stmt_month = $request->stmt_month;
                        $bank_statement->file_path  = $file;
                        $bank_statement->save();
                        $this->importFileContents($request,$bank_statement->id);
                        toast('Successfully uploaded Bank Statements','success');
                    }
                }
                else{
                    toast('Upload a CSV/XLSX File','danger');
                }
            }
        }
        return redirect()->back();
    }
    public function importFileContents($request,$id)
    {
        Excel::import(new BankStatementImport($id),$request->file('bknStatementCSV'));
    }
}
