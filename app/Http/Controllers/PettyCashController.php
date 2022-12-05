<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\AccountTransaction;
use App\Models\Journal;
use App\Models\Particular;
use App\Models\PettyCashItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

class PettyCashController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        Session::forget('newTransaction');
        Session::forget('trItems');
        $accounts = Account::where('organization_id',Auth::user()->organization_id)->get();
        $assets = Account::where('organization_id',Auth::user()->organization_id)->where('category', 'ASSET')->where('name', 'not like', '%' . 'Loan' . '%')->get();
        $liabilities = Account::where('organization_id',Auth::user()->organization_id)->where('category', 'LIABILITY')->get();
        $petty = Account::where('organization_id',Auth::user()->organization_id)->where('name', 'LIKE', '%petty%')->get();
        $petty_account = Account::where('organization_id',Auth::user()->organization_id)->where('name', 'LIKE', '%' . 'petty cash' . '%')->where('active', 1)->first();
        if ($petty_account != null) {
            $acID = $petty_account->id;
            $query = new AccountTransaction;
            $ac_transactions = $query->where(function ($query) use ($acID) {
                $query->where('debit_account_id', $acID)
                    ->orWhere('credit_account_id', $acID);
            })->orderBy('transaction_date', 'DESC')->get();
            return view('petty-cash.petty_cash',compact('accounts', 'assets', 'liabilities', 'petty', 'petty_account', 'ac_transactions'));
        }
        else{
            return view('petty-cash.petty_cash',compact('accounts', 'assets', 'liabilities', 'petty', 'petty_account'));
        }
    }
    public function transaction(Request $request)
    {
        $account = Account::where('name', 'like', '%' . 'Petty Cash' . '%')->first();

        if ($request->get('particular_id') != NULL) {
            Session::push('trItems', array(
                'item_name' => Particular::find($request->get('particular_id'))->name,
                'description' => $request->get('description'),
                'quantity' => $request->get('qty'),
                'date' => $request->get('date'),
                'unit_price' => $request->get('amount'),
                'particulars_id' => $request->get('particular_id'),
                'receipt' => $request->get('receipt'),
                'credit_ac' => $account->id,
                'totalA' => $request->get('qty') * $request->get('unit_price')
            ));
        }

        $trItems = Session::get('trItems');
        $particulars = Particular::whereNotNull('debit_account_id')->whereNotNull('credit_account_id')->get();
        return view('petty-cash.transaction',compact('particulars','trItems'));
    }
    public function removeTransactionItem($count)
    {
//        $newTr = Session::get('newTransaction');
        $items = Session::get('trItems');
        unset($items[$count]);
        $newItems = array_values($items);
        Session::put('trItems', $newItems);
        $trItems = Session::get('trItems');
        $particulars = Particular::whereNotNull('debit_account_id')->whereNotNull('credit_account_id')->get();
        toast('Removed from Receipt Item','warning');
        return view('petty-cash.transaction',compact('particulars','trItems'));
    }
    public function commitTransaction()
    {

        $newTr = Session::get('newTransaction');
        $trItems = Session::get('trItems');
//        dd($trItems);

        $particulars = Particular::whereNotNull('debit_account_id')->whereNotNull('credit_account_id')->get();

        foreach ($particulars as $key => $particular) {
//            dd($particular->debit->category);
            if ($particular->name == "Expense (Loan Insurance)" || $particular->debit->category != 'EXPENSE') {
                unset($particulars[$key]);
            }
        }
        //dd($trItems);
        if ($trItems == NULL) {
            //$notice = 'Please select some entries';
            toast('Please select some entries','info');
            return View::make('petty-cash.transaction', compact('newTr', 'trItems', 'particulars'));
        }

        $total = 0;
        foreach ($trItems as $trItem) {
            $total += ($trItem['quantity'] * $trItem['unit_price']);
        }
        //dd($total);

//        $petty_account = Account::where('name', 'like', '%' . 'Petty Cash' . '%')->first();
//        if ($total > Account::getAccountBalanceAtDate($petty_account, date('Y-m-d'))) {
//            toast('Not enough funds in petty cash account','warning');
//            return View::make('petty-cash.transaction', compact('newTr', 'trItems', 'particulars'));
//        }

        $particular = Particular::where('name', 'like', '%' . 'Petty Cash' . '%')->first();

        if (empty($particular)) {
            $particular = new Particular;
            $particular->organization_id = Auth::user()->organization_id;
            $particular->name = "Petty Cash";
            $particular->save();
        }
        foreach ($trItems as $trItem) {
            $data = array(
                'date' => $trItem['date'],
                'debit_account' => Particular::find($trItem['particulars_id'])->debit_account_id,
                'credit_account' => $trItem['credit_ac'],
                'description' => $trItem['description'],
                'narration' => 0,
                'particulars_id' => $trItem['particulars_id'],
                'batch_transaction_no' => $trItem['receipt'],
                'amount' => $trItem['quantity'] * $trItem['unit_price'],
                'initiated_by' => Auth::user()->firstname
            );
//            dd($data);

            $acTransaction = new AccountTransaction;
            $journal = new Journal;

            $trId = $acTransaction->createTransaction($data);
            //$trId = $tr->id;
            $trans_no = $journal->journal_entry($data);
            // $tr->journal_trans_no = $trans_no;
            // $tr->update();

            $pettyCashItem = new PettyCashItem();

            $pettyCashItem->account_transaction_id = $trId;
            $pettyCashItem->organization_id = Auth::user()->organization_id;
            $pettyCashItem->item_name = $trItem['item_name'];
            $pettyCashItem->description = $trItem['description'];
            $pettyCashItem->quantity = $trItem['quantity'];
            $pettyCashItem->unit_price = $trItem['unit_price'];

            $pettyCashItem->save();
        }

        Session::forget('newTransaction');
        Session::forget('trItems');
        toast('Transaction Added','success');
        return redirect()->back();
        //return Redirect::action('PettyCashController@index');
    }
    public function addMoney(Request $request)
    {
//        dd($request->all());
        $ac_name = Account::where('id', $request->get('ac_from'))->first();
//        dd($ac_name);
        $amount = $request->get('amount');
//        dd($amount);
//        dd(Account::getAccountBalanceAtDate($ac_name, date('Y-m-d')));
        if (Account::getAccountBalanceAtDate($ac_name, date('Y-m-d')) < (int)$request->get('amount')) {
            toast('Insufficient funds in From Account selected!','warning');
            return \redirect()->back();
        }

        $particular = Particular::where('name', 'like', '%' . 'Petty Cash' . '%')->first();
        $data = array(
            'date' => date("Y-m-d"),
            'debit_account' => $request->get('ac_to'),
            'credit_account' => $request->get('ac_from'),
            'description' => "Transferred cash from $ac_name->name account to Petty Cash Account",
            'narration' => 220,
            'particulars_id' => $particular->id,
            'batch_transaction_no' => $request->get('reference'),
            'amount' => $request->get('amount'),
            'initiated_by' => Auth::user()->firstname
        );
//        dd($data);

        //DB::table('accounts')->where('id', $request->get('ac_from'))->decrement('balance', $request->get('amount'));
        //DB::table('accounts')->where('id', $request->get('ac_to'))->increment('balance', $request->get('amount'));

        $acTransaction = new AccountTransaction;
        $journal = new Journal;

        $tr = $acTransaction->createTransaction($data);
        $trans_no = $journal->journal_entry($data);

        // $trans = AccountTransaction::find($tr);
        //
        // $trans->journal_trans_no = $trans_no;
        //
        // $trans->update();

        //return Redirect::action('PettyCashController@index')->with('success', "KES. $amount Successfully Transferred from $ac_name->name to Petty Cash!");
        toast('KES'. $amount. 'Successfully Transferred from'. $ac_name->name. 'to Petty Cash!','success');
        return  \redirect()->back();
    }
}
