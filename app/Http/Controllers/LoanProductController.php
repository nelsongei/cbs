<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoanProductController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        return view('loans.loan-products');
    }
}
