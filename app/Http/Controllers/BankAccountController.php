<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BankAccountController extends Controller
{
    //
    public function index()
    {
        return view('banking.accounts');
    }
}
