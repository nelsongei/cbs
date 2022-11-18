<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\MemberGuarantor;
use App\Models\Saving;
use App\Notifications\MemberGuarantorNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemberGuarantorController extends Controller
{
    //
    public function getGuarantor($id)
    {
        $ids = MemberGuarantor::where('member_id', $id)->pluck('guarantor_id');
        $guarantor = Member::whereNotIn('id', $ids)
            ->where('id', '!=', $id)
            ->get();
        return $guarantor;
    }

    public function store(Request $request)
    {
        $guarantor = new MemberGuarantor();
        $guarantor->organization_id = Auth::user()->organization_id;
        $guarantor->member_id = $request->member_id;
        $guarantor->guarantor_id = $request->guarantor_id;
        $guarantor->guarantee_percentage = $request->guarantee_percentage;
        $guarantor->guarantee_amount = $request->guarantee_amount;
        $guarantor->save();
        if ($guarantor) {
            $member = Member::find($request->guarantor_id);
            $details = [
                'data' => 'Requested to be a guarantor',
                'organization_id' => Auth::user()->organization_id,
            ];
//            $org =[
//                'organization_id' => Auth::user()->organization_id,
//            ];
            //$member->notify(new MemberGuarantorNotification($details));
            toast('Guarantor request send','success');
        }
        return redirect()->back();
    }

    public function getSavings($id)
    {
        return Saving::where('member_id', $id)->sum('saving_amount');
    }
}
