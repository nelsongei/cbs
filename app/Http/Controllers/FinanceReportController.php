<?php

namespace App\Http\Controllers;

use App\Exports\JournalReportExport;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class FinanceReportController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        return view('reports.finance');
    }
    public function export(Request $request)
    {
        if($request->report=='journal_reports' && $request->format =='Excel')
        {
            return Excel::download(new JournalReportExport(),'journal_report.xlsx');
        }
    }
}
