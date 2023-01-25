<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoanReportController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        return view('reports.loans');
    }
}
