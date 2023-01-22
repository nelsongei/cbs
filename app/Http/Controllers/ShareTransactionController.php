<?php

namespace App\Http\Controllers;

use App\Models\ShareTransaction;
use Illuminate\Http\Request;

class ShareTransactionController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function store(Request $request)
    {
        $transaction = new ShareTransaction();
        $transaction->share_account_id = $request->share_account_id;
        $transaction->type= $request->type;
        $transaction->date = $request->date;
        $transaction->amount = $request->amount;
        $transaction->bank_sadetails = $request->bank_sadetails;
        $transaction->description = $request->description;
        $transaction->save();
        if ($transaction)
        {
            toast('Successfully Purchase a share','success');
        }
        return redirect()->back();
    }
}
