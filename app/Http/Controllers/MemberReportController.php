<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemberReportController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(){
        $members = Member::where('organization_id',Auth::user()->organization_id)->get();
        return view('reports.members',compact('members'));
    }
}
