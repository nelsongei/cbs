<?php

namespace App\Http\Controllers;

use App\Models\MemberDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class MemberDocumentController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function store(Request  $request)
    {
        $validate = Validator::make($request->all(),[
            'file_name'=>'required',
            'file_path'=>'required|mimes:pdf|max:2000'
        ]);
        if ($validate->fails())
        {
            toast("All fields are required",'warning');
        }
        else{
            if ($request->hasFile('file_path'))
            {
                $file = $request->file('file_path')->store('documents','public');
                $docs = new MemberDocument();
                $docs->type = $request->type;
                $docs->organization_id = Auth::user()->organization_id;
                $docs->file_name = $request->file_name;
                $docs->file_path = $file;
                $docs->member_id = $request->member_id;
                $docs->save();
                if ($docs)
                {
                    toast('Successfully uploaded document','success');
                }
            }
        }
        return redirect()->back();
    }
}
