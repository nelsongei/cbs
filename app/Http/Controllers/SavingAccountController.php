<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\SavingAccount;
use App\Models\SavingProduct;
use App\Models\ShareAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SavingAccountController extends Controller
{
    //
    public function index()
    {
        $members = Member::where('organization_id',Auth::user()->organization_id)->get();
        $products = SavingProduct::where('organization_id',Auth::user()->organization_id)->get();
        $accounts  = SavingAccount::where('organization_id',Auth::user()->organization_id)->get();
        return view('saving.saving-account',compact('members','products','accounts'));
    }
    public function getAccountNo(Request $request)
    {
        $member = Member::findOrFail($request->member_id);
        $savingProduct = SavingProduct::findOrFail($request->saving_product_id);
        return $savingProduct->shortname.'000000'.$member->membership_no;
    }
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'member_id'=>'required',
            'saving_product_id'=>'required',
            'account_no'=>'required',
        ]);
        if ($validate->passes())
        {
            $account = new SavingAccount();
            $account->member_id = $request->member_id;
            $account->saving_product_id = $request->saving_product_id;
            $account->account_number = $request->account_no;
            $account->organization_id = Auth::user()->organization_id;
            $account->save();
            toast('Successfully Added Account','success');
        }
        else{
            toast('All Fields are required','warning','top-right');
        }
        return redirect()->back();
    }
    public function update(Request $request)
    {
        $account = SavingAccount::where('id',$request->id)->findOrFail($request->id);
        $account->account_number = $request->account_no;
        $account->push();
        toast('Update Successfully','info','top-right');
        return redirect()->back();
    }
    public function view($id)
    {
        $account = SavingAccount::where('id',$id)->findOrFail($id);

        return view('saving.saving-account-view',compact('account'));
    }
    public function viewShare($id)
    {
        $share = ShareAccount::where('id',$id)->where('organization_id',Auth::user()->organization_id)->findOrFail($id);
        return view('saving.view-share',compact('share'));
    }
}
