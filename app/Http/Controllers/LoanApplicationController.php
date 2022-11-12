<?php

namespace App\Http\Controllers;

use App\Models\LoanProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoanApplicationController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $products = LoanProduct::where('organization_id',Auth::user()->organization_id)->get();
        return view('loans.loan-application',compact('products'));
    }
}
