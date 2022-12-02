<?php

namespace App\Http\Controllers;

use App\Models\LoanApplication;
use App\Models\LoanGuarantor;
use App\Models\LoanRepayment;
use App\Models\LoanTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoanTransactionController extends Controller
{
    //
    public function store(Request $request)
    {
//          dd($request->all());
        $data = $request->all();
        $validiate = Validator::make($request->all(), [
            'date' => 'required',
        ]);
        if ($validiate->fails()) {
            toast('All Fields are required', 'info');
        } else {
            $loan = LoanApplication::find($request->loan_application_id);
            //dd($loan->amount_applied);
            $guarantors = LoanGuarantor::where('organization_id',Auth::user()->organization_id)->where('loan_application_id',$request->loan_application_id)->get();
            foreach ($guarantors as $guarantor)
            {
                $member = $guarantor->member_id;
                $amount = $guarantor->amount;
                $fraction = $amount/$loan->amount_applied;
                $reducedamount = $fraction*$request->amount;
                $reduced = $amount-$reducedamount;

                LoanGuarantor::where('member_id',$member)->where('loan_application_id',$request->loan_application_id)->update(['amount'=>$reduced]);
            }
            LoanRepayment::repayLoan($data);
            $loan = LoanApplication::findOrFail($request->loan_application_id);
            $loanbalance = LoanTransaction::getLoanBalance($loan);
            $loanbalance = $this->asMoney($loanbalance);
//            if($loanbalance > 0){
//                $message = "Confirmed. Loan repayment of ksh ".$data['amount']." to loan account ".$loan->account_number." on ".$data['date'].". Your new loan balance is ksh" .$loanbalance."\nThank you! \n Regards, .".Auth::user()->organization->name;
//            }else{
//                $message = "Confirmed. Loan repayment of ksh ".$data['amount']." to loan account ".$loan->account_number." on ".$data['date'].". Your loan balance is now fully repaid. \nThank you. \n Regards," .Auth::user()->organization->name;
//            }
            toast('Loan Repaid Successfully','success');
            return redirect()->back();

        }
    }
    public function asMoney($value) {
        return number_format($value, 2);
    }
}
