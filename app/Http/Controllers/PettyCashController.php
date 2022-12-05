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
}
