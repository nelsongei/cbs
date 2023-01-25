<?php

namespace App\Http\Controllers;

use App\Models\LoanApplication;
use App\Models\LoanProduct;
use App\Models\Organization;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoanReportController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $products = LoanProduct::where('organization_id',Auth::user()->organization_id)->get();
        return view('reports.loans',compact('products'));
    }
    public function download(Request $request)
    {
        $organization = Organization::find(Auth::user()->organization_id);
        if($request->period=='asatdate' && $request->format =='PDF'&& ($request->report !='listing' || $request->report !='arrears'))
        {
            $period = $request->date;
            $loanProduct = LoanProduct::find($request->report);
            $loans = LoanApplication::where('organization_id',Auth::user()->organization_id)->where('loan_product_id',$request->report)->get();
            $pdf = Pdf::loadView('pdf.loanreports',compact('loans','organization','period','loanProduct'));
            return $pdf->stream('loans.pdf');
        }
    }
}
