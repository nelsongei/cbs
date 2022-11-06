<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ParticularController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $accounts = Account::where('organization_id',Auth::user()->organization_id)->get();
        return view('particulars.index',compact('accounts'));
    }
}
