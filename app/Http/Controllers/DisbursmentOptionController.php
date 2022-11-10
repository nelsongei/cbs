<?php

namespace App\Http\Controllers;

use App\Models\DisbursmentOption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DisbursmentOptionController extends Controller
{
    //
    public function index()
    {
        $disbursments = DisbursmentOption::where('organization_id',Auth::user()->organization_id)->get();
        return view('disbursement.index',compact('disbursments'));
    }
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'name'=>'required',
            'min'=>'required',
            'max'=>'required',
            'description'=>'required'
        ]);
        if ($validate->fails())
        {
            toast('All Fields are required','warning');
        }
        else{
            $disbursment = new DisbursmentOption();
            $disbursment->name = $request->name;
            $disbursment->min = $request->min;
            $disbursment->max = $request->max;
            $disbursment->organization_id = Auth::user()->organization_id;
            $disbursment->description = $request->description;
            $disbursment->save();
            toast('Successfully Added');
        }
        return redirect()->back();
    }
}
