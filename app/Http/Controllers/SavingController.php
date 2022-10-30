<?php

namespace App\Http\Controllers;

use App\Exports\SavingExport;
use App\Models\Member;
use App\Models\Saving;
use App\Models\SavingAccount;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;


class SavingController extends Controller
{
    //
    public function index()
    {
        $savings = Saving::where('organization_id',Auth::user()->organization_id)->paginate(10);
        $savingaccounts = SavingAccount::where('organization_id',Auth::user()->organization_id)->get();
        return view('saving.index',compact('savingaccounts','savings'));
    }
    public function exportTemplate()
    {
        return Excel::download(new SavingExport,'savig.xlsx');
    }
    public function store(Request $request)
    {
        $member = SavingAccount::where('account_number',trim(explode(':',$request->account)[1]))->first();
        $saving = new Saving();
        $saving->member_id = $member->member_id;
        $saving->organization_id = Auth::user()->organization_id;
        $saving->saving_account_id = $member->id;
        $saving->saving_amount = $request->saving_amount;
        $saving->type = $request->type;
        $saving->date = $request->date;
        $saving->payment_method = $request->payment_method;
        $saving->bank_sadetails = $request->bank_sadetails ? '':null;
        $saving->transacted_by = trim(explode(':',$request->account)[0]);
        $saving->management_fee = null;
        $saving->description = $request->description;
        $saving->save();
        if ($saving)
        {
            toast('Successfully Added Savings','success');
        }
        return redirect()->back();
    }
    public function receipt($id)
    {
        $saving = Saving::where('id',$id)->findOrFail($id);
        return  Pdf::loadView('pdf.saving-receipt',compact('saving'))->setPaper('A6','portrait')->download();


    }
}
