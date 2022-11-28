<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SupplierController extends Controller
{
    //
    public function store(Request $request)
    {
        //dd($request->all());
        $validate = Validator::make($request->all(),[
            'supplier_name'=>'required',
            'email'=>'required',
            'phone'=>'required',
            'address'=>'required',
            'supplier_group'=>'required'
        ]);
        if ($validate->fails())
        {
            toast('All Fields Are required','info');
        }
        else{
            $supplier = new Supplier();
            $supplier->supplier_name = $request->supplier_name;
            $supplier->organization_id = Auth::user()->organization_id;
            $supplier->email = $request->email;
            $supplier->phone = $request->phone;
            $supplier->address = $request->address;
            $supplier->supplier_group = $request->supplier_group;
            $supplier->save();
            toast('Successfully Added Supplier','success');
        }
        return redirect()->back();
    }
}
