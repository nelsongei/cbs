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
use Illuminate\Support\Facades\DB;
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
    public function recover(Request $request)
    {
        $loanbalance= ($request->loanaccount_balance);
        $loan = LoanApplication::findOrFail($request->loan_application_id);
        if ($loanbalance<=0)
        {
            toast('The loan is fully settled by the Borrower!','info');
        }
        else
        {
            if (count($loan->gurantors)<1)
            {
                toast('No Guarantors to Recover Loan From!','info');
            }
            else{
                foreach ($loan->gurantors as $gurantor)
                {
                    $fraction = round(($gurantor->amount/$request->amount),2);
                    $amount_to_recover = round(($fraction*$request->loanaccount_balance),2);
                    $recover_from_savings = 0.8 * (round(2 / 3 * $amount_to_recover, 0));
                    $savings = DB::table('savings')
                        ->join('saving_accounts', 'savings.saving_account_id', '=', 'saving_accounts.id')
                        ->where('saving_accounts.member_id', '=', $gurantor->member_id)
                        ->where('savings.type', '=', 'credit')
                        ->select(DB::raw('max(saving_amount) as largesave'), 'savings.id as saveid')
                        ->get();
                    foreach ($savings as $save) {
                        $sid = $save->saveid;
                        $slarge = $save->largesave;
                        DB::table('savings')->where('id', '=', $sid)
                            ->update(['saving_amount' => round($slarge - $recover_from_savings, 0)]);
                    }
                    $recover_from_shares = 0.8 * (round(1 / 3 * $amount_to_recover, 0));
                    $shares = DB::table('share_transactions')
                        ->join('share_accounts', 'share_transactions.share_account_id', '=', 'share_accounts.id')
                        ->where('share_accounts.member_id', '=', $gurantor->member_id)
                        ->where('share_transactions.type', '=', 'credit')
                        ->select(DB::raw('max(amount) as largeshare'), 'share_transactions.id as shareid')
                        ->get();
                    foreach ($shares as $share) {
                        $shareid = $share->shareid;
                        $sharelarge = $share->largeshare;
                        DB::table('share_transactions')->where('id', '=', $shareid)
                            ->update(['amount' => round($sharelarge - $recover_from_shares, 0)]);
                    }
                    LoanRepayment::repayLoan($request->all());
                    toast('Loan Has been Recovered','success');
                }
            }
        }
        return redirect()->back();
    }

}
