<?php

namespace App\Http\Controllers;

use App\Models\LoanApplication;
use App\Models\LoanGuarantor;
use App\Models\LoanRepayment;
use App\Models\LoanTopup;
use App\Models\LoanTransaction;
use App\Models\Organization;
use App\Models\Particular;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use function PHPUnit\Framework\isEmpty;

class LoanTransactionController extends Controller
{
    //
    public function store(Request $request)
    {
        $data = $request->all();
        $validiate = Validator::make($request->all(), [
            'date' => 'required',
        ]);
        if ($validiate->fails()) {
            toast('All Fields are required', 'info');
        } else {
            $loan = LoanApplication::find($request->loan_application_id);
            //dd($loan->amount_applied);
            $guarantors = LoanGuarantor::where('organization_id', Auth::user()->organization_id)->where('loan_application_id', $request->loan_application_id)->get();
            foreach ($guarantors as $guarantor) {
                $member = $guarantor->member_id;
                $amount = $guarantor->amount;
                $fraction = $amount / $loan->amount_applied;
                $reducedamount = $fraction * $request->amount;
                $reduced = $amount - $reducedamount;

                LoanGuarantor::where('member_id', $member)->where('loan_application_id', $request->loan_application_id)->update(['amount' => $reduced]);
            }
            LoanRepayment::repayLoan($data);
            $loan = LoanApplication::findOrFail($request->loan_application_id);
            $loanbalance = LoanTransaction::getLoanBalance($loan);
            $loanbalance = $this->asMoney($loanbalance);
            toast('Loan Repaid Successfully', 'success');
            return redirect()->back();
        }
    }

    public function asMoney($value)
    {
        return number_format($value, 2);
    }

    /**/
    public function exportLoanStatement($id)
    {
        $account = LoanApplication::find($id);
        $transactions = $account->transactions()->orderBy('date')->get();
        foreach ($transactions as $transaction) {
            if (strtolower($transaction->description)=="loan repayment" ||strtolower($transaction->description)=="loan clearance")
            {
                $transaction->hasRepayment = true;
                $loanRepayments = LoanRepayment::where('loan_transaction_id',$transaction->id)->get();;
                if (!$loanRepayments->isEmpty())
                {
                    $transaction->repayments = $loanRepayments;
                }
                else{
                    $transaction->repayments = LoanRepayment::where('loan_application_id',$id)->whereBetween('created_at', array(
                        date('Y-m-d H:i:s', strtotime('-5 seconds', strtotime($transaction->created_at))),
                        date('Y-m-d H:i:s', strtotime('+5 seconds', strtotime($transaction->created_at)))
                    ))->get();;
                }
            }
            else{
                $transaction->hasRepayment = false;
            }
        }
        $organization = Organization::find(Auth::user()->organization_id);
        $pdf = Pdf::loadView('pdf.loanstatement',compact('transactions','account','organization'))->setPaper('A4');
        return $pdf->stream('loanstatement.pdf');
    }
    public function topup(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'top_amount'=>'required',
            'top_date'=>'required',
            'bank_ref'=>'required'
        ]);
        if ($validate->fails())
        {
            toast($validate->errors()->all(),'info');
        }
        else{
            $loan = LoanApplication::find($request->id);
            $loan->top_up_amount = $request->top_amount;
            $loan->push();
            LoanTransaction::topuploan($loan,$request->top_amount,$request->top_date,$request->bank_ref);
            $this->topups($loan,$request);
            toast('Successfully Top up Up Loan','success');
        }
        return redirect()->back();
    }
    public function topups($loan,$request)
    {
        $topup = new LoanTopup();
        $topup->loan_application_id  =$loan->id;
        $topup->organization_id = Auth::user()->organization_id;
        $topup->amount_topup = $request->top_amount;
        $topup->date_topup = $request->top_date;
        $topup->save();
    }
    public function offset(Request $request)
    {
//        dd($request->all());
        $validator = Validator::make($request->all(),[
            'repayment_date'=>'required',
            'bank_ref'=>'required',
            'top_amount'=>'required'
        ]);
        if ($validator->fails()){
            toast($validator->errors()->all(),'warning');
        }
        else{
            $loan = LoanApplication::find($request->id);
            $loanBalance = LoanTransaction::getLoanBalance($loan);
            LoanRepayment::offsetLoan($request,$loanBalance);
        }
        return redirect()->back();
    }

}
