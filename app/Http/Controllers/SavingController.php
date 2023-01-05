<?php

namespace App\Http\Controllers;

use App\Exports\SavingExport;
use App\Models\Journal;
use App\Models\Member;
use App\Models\Particular;
use App\Models\Saving;
use App\Models\SavingAccount;
use Barryvdh\DomPDF\Facade\Pdf;
use DateInterval;
use DatePeriod;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;


class SavingController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $savings = Saving::where('organization_id', Auth::user()->organization_id)->paginate(10);
        $savingaccounts = SavingAccount::where('organization_id', Auth::user()->organization_id)->get();
        return view('saving.index', compact('savingaccounts', 'savings'));
    }
    public function exportTemplate()
    {
        return Excel::download(new SavingExport, 'savig.xlsx');
    }
    public function store(Request $request)
    {
        $member = SavingAccount::where('account_number', trim(explode(':', $request->account)[1]))->first();
        //
        $particular = (Particular::where('name', 'LIKE', '%' . 'member savings' . '%')->first());
        if ($particular == null) {
            toast('Add A Particular Item with name member savings', 'info');
        } else {
            foreach ($member->product->postings as $posting) {
                if ($request->payment_method == 'Cash' && $posting->transaction == 'deposit_cash') {
                    $debit_account = $posting->debit_account_id;
                    $credit_account = $posting->credit_account_id;
                    $data = array(
                        'credit_account' => $credit_account,
                        'debit_account' => $debit_account,
                        'date' => $request->date,
                        'amount' => $request->saving_amount,
                        'initiated_by' => 'system',
                        'description' => $request->description,
                        'bank_details' => $request->bank_sadetails ? '' : null,

                        'particulars_id' => $particular->id,
                        'narration' => $member->id
                    );


                    $journal = new Journal();


                    $journal->journal_entry($data);
                } elseif ($request->payment_method == 'Bank' && $posting->transaction == 'deposit') {
                    $debit_account = $posting->debit_account_id;
                    $credit_account = $posting->credit_account_id;
                    $data = array(
                        'credit_account' => $credit_account,
                        'debit_account' => $debit_account,
                        'date' => $request->date,
                        'amount' => $request->saving_amount,
                        'initiated_by' => 'system',
                        'description' => $request->description,
                        'bank_details' => $request->bank_sadetails ? '' : null,

                        'particulars_id' => $particular->id,
                        'narration' => $member->id
                    );


                    $journal = new Journal();


                    $journal->journal_entry($data);
                }
            }
            $saving = new Saving();
            $saving->member_id = $member->member_id;
            $saving->organization_id = Auth::user()->organization_id;
            $saving->saving_account_id = $member->id;
            $saving->saving_amount = $request->saving_amount;
            $saving->type = $request->type;
            $saving->date = $request->date;
            $saving->payment_method = $request->payment_method;
            $saving->bank_sadetails = $request->bank_sadetails ? '' : null;
            $saving->transacted_by = trim(explode(':', $request->account)[0]);
            $saving->management_fee = null;
            $saving->description = $request->description;
            $saving->save();
            if ($saving) {
                toast('Successfully Added Savings', 'success');
            }
        }

        return redirect()->back();
    }
    public function receipt($id)
    {
        $saving = Saving::where('id', $id)->findOrFail($id);
        return  Pdf::loadView('pdf.saving-receipt', compact('saving'))->setPaper('A6', 'portrait')->download();
    }
    public function view($id)
    {
        $saving = Saving::find($id);
        $oldDate = new DateTime($saving->date);
        $newDate = new DateTime();
        $months = $oldDate->diff($newDate);
        $month = $months->m;
        $newMonths =  array(date('M', strtotime($saving->date)));
        $start =  new DateTime($saving->date);
        $start->modify('first day of this month');
        $end  = new DateTime();
        $interval = DateInterval::createFromDateString('1 month');
        $period = new DatePeriod($start, $interval, $end);
        $principal = $saving->saving_amount;
        $rate = ($saving->account->product->interest_rate) / 100;
        return view('saving.view-saving', compact('saving', 'principal', 'period', 'rate', 'month'));
    }
    public function upload(Request $request)
    {
        // dd(Auth::user()->organization->name);
        // dd($request->all());
        if ($request->hasFile('file')) {
            $file = $request->file;
            $fileName = Str::random() . '.' . $file->getClientOriginalExtension();
            $destination = public_path(Auth::user()->organization->name . '/savings');
            $file->move($destination, $fileName);
            if($file){
                $excel = Excel::toArray([],public_path(Auth::user()->organization->name . '/savings/').$fileName);
                //dd();
                $i=1;
                foreach($excel as $e)
                {
                    $account = SavingAccount::where('account_number',($e[$i][1]))->first();
                    dd($account->member_id);
                    if($account !== null)
                    {
                        Saving::importSaving($account->member_id,);
                    }
                    //dd(trim(explode(',',)));
                    $i++;
                }
            }
        } else {
            dd('Failed');
        }
    }
}
