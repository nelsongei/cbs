<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FinanceReportController extends Controller
{
    //
    public function index()
    {
        return view('reports.finance');
    }
    public function export(Request $request)
    {
        dd($request->date);
        $accounts = Account::where('organization_id',Auth::user()->organization_id)->get();
        dd($accounts);
    }
}
