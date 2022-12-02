<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LoanRepayment extends Model
{
    use HasFactory;
    public static function getPrincipalPaid($loanaccount, $date = null)
    {

        $paid = LoanRepayment::where('loan_application_id',$loanaccount->id)->where('date','>=',$loanaccount->date_disbursed)->sum('principal_paid');
        //dd($paid);
        //dd($date);
        if ($date != null) {
            $paid = DB::table('loan_repayments')->where('loan_application_id', '=', $loanaccount->id)->where('date', '>=', $loanaccount->date_disbursed)->where('date', '<=', $date)->sum('principal_paid');
        } else {
            //$paid = DB::table('loan_repayments')->where('loan_application_id', '=', $loanaccount->id)->where('date', '>=', $loanaccount->date_disbursed)->sum('principal_paid');
        }
        //dd($paid);
        return $paid;
    }
    public function loanaccount(){

        return $this->belongsTo(LoanApplication::class,'loan_application_id');
    }
    public static function getAmountPaid($loanaccount, $date = null)
    {

        if ($date != null) {
            $paid = DB::table('loan_transactions')->where('loan_application_id', '=', $loanaccount->id)->where('date', '>=', $loanaccount->date_disbursed)->where('date', '<=', $date)->where('description', '=', 'loan repayment')->sum('amount');
        } else {
            $paid = DB::table('loan_transactions')->where('loan_application_id', '=', $loanaccount->id)->where('date', '>=', $loanaccount->date_disbursed)->where('description', '=', 'loan repayment')->sum('amount');
        }
        return $paid;
    }
    public static function repayLoan($data){
        $loanaccount_id = $data['loan_application_id'];
        $loanaccount = LoanApplication::findorfail($loanaccount_id);
        //dd($data);
        $amount = $data['amount'];
        $date = $data['date'];
        $bank = $data['bank_reference'];

        $member = $loanaccount->member;


        $principal_due = LoanTransaction::getPrincipalDue($loanaccount);
        $interest_due = LoanTransaction::getInterestDue($loanaccount);
        $principal_bal =LoanApplication::getPrincipalBal($loanaccount);
        $total_due = $principal_due + $interest_due;

        $payamount = $amount;

        $chosen_date_date = date('Y-m-d', strtotime($date));
        $start_date = $loanaccount->repayment_start_date;
        $chosen_year = date('Y', strtotime($date));
        $start_year = date('Y', strtotime($start_date));
        $chosen_month = date('m', strtotime($date));
        $start_month = date('m', strtotime($start_date));
        $months = (($chosen_year - $start_year) * 12) + ($chosen_month - $start_month);
        $counter = LoanTransaction::where('loan_application_id', '=', $loanaccount->id)->count();
        //subtract current repayment month
        //dd($loanaccount->loanguard_status);
        if ($loanaccount->loanguard_status == 1) {
            $counter += 1;
        }
        $balance = LoanApplication::getPrincipalBal($loanaccount);
        //dd($balance);
        $rate = ($loanaccount->interest_rate) / 100;
        //dd($rate);
        $principal_due = LoanApplication::getLoanAmount($loanaccount) / $loanaccount->repayment_duration;

        $category = "Cash";
        if (($counter < 3) && ($chosen_date_date > $start_date) && ($months > 0)) {
            $start_date = $loanaccount->date_disbursed;
            $dates = Loanrepayment::end_months($start_date, $months);
            foreach ($dates as $enddate) {
                $interest_supposed_to_pay = $balance * $rate;
                Loanrepayment::payPrincipal($loanaccount, $enddate, 0,$bank);
                Loanrepayment::payInterest($loanaccount, $enddate, 0,$bank);
                $total_supposed = $principal_due + $interest_supposed_to_pay;
                $amount_paid_month = 0;
                /*Record Arrears*/
                $balance += $interest_supposed_to_pay;
            }
        } elseif ($counter > 3) {
            //dd('k');
            $trans = LoanTransaction::where('loan_application_id', '=', $loanaccount_id)->orderBy('date', 'DESC')->first();
            $last_date = $trans->date;
            $last_month = date('m', strtotime($last_date));
            $last_year = date('Y', strtotime($last_date));

            $months = (($chosen_year - $last_year) * 12) + ($chosen_month - $last_month);
            $months -= 1;
            if ($months > 0) {
                $dates = Loanrepayment::end_months($last_date, $months);
                foreach ($dates as $enddate) {
                    $interest_supposed_to_pay = $balance * $rate;
                    Loanrepayment::payPrincipal($loanaccount, $enddate, 0,$bank);

                    Loanrepayment::payInterest($loanaccount, $enddate, 0,$bank);
                    $total_supposed = $principal_due + $interest_supposed_to_pay;
                    $amount_paid_month = 0;
                    $balance += $interest_supposed_to_pay;
                }


            }
        }
        if((int)$payamount < $total_due){
            //pay interest first
            LoanRepayment::payInterest($loanaccount, $date, $interest_due,$bank);
            $payamount = $payamount - $interest_due;
            if($payamount > 0){
                LoanRepayment::payPrincipal($loanaccount, $date, $payamount,$bank);
            }
        }elseif($payamount >= $total_due){
            //pay interest first
            if((int)$payamount >= $interest_due && $interest_due > 0){
                LoanRepayment::payInterest($loanaccount, $date, $interest_due,$bank);
                $payamount=$payamount-$interest_due;
            }elseif((int)$payamount < $interest_due){
                //dd('lls');
                LoanRepayment::payInterest($loanaccount, $date, $payamount,$bank);
                $payamount=0;
            }


            if ($payamount < $principal_bal && $payamount > 0){
                LoanRepayment::payPrincipal($loanaccount, $date, $payamount,$bank);
                $payamount=$payamount-$principal_bal;
            }elseif ($payamount>=$principal_bal){
                $overcharge=$payamount-$principal_bal;
                $payamount=$principal_bal;
                LoanRepayment::payPrincipal($loanaccount, $date, $payamount,$bank);
                $data = array(
                    'credit_account' =>'99' ,
                    'debit_account' =>'6' ,
                    'date' => $date,
                    'amount' => $overcharge,
                    'initiated_by' => 'system',
                    'description' => 'loanovercharge',
                    'bank_details' => $bank,
                    'particulars_id' => '75',
                    'narration' => $loanaccount->member->id

                );
                $journal = new Journal;
                $journal->journal_entry($data);
            }
        }
        LoanTransaction::repayLoan($loanaccount, $amount, $date,$bank);
    }
    public static function payInterest($loanaccount, $date, $interest_due,$bank){
        //dd($loanaccount->member->id);
        $repayment = new LoanRepayment();
        $repayment->loanaccount()->associate($loanaccount);
        $repayment->date = date('Y-m-d',strtotime($date));
        $repayment->organization_id = Auth::user()->organization_id;
        $repayment->interest_paid = $interest_due;
        $repayment->save();
        $account = LoanPosting::getPostingAccount($loanaccount->loanType, 'interest_repayment');
        $data = array(
            'credit_account' =>$account['credit'] ,
            'debit_account' =>$account['debit'] ,
            'date' => $date,
            'amount' => $interest_due,
            'initiated_by' => 'system',
            'description' => 'interest repayment',
            'bank_details' => $bank,
            'organization_id'=>Auth::user()->organization_id,
            'particulars_id' => '1',
            'narration' => $loanaccount->member->id
        );
        $journal = new Journal;
        $journal->journal_entry($data);
    }
}
