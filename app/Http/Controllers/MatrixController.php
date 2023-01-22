<?php

namespace App\Http\Controllers;

use App\Models\Matrix;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class MatrixController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $matrices = Matrix::where('organization_id',Auth::user()->organization_id)->get();
        return view('matrix.index',compact('matrices'));
    }
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'name'=>'required',
            'maximum'=>'required',
            'description'=>'required'
        ]);
        if ($validate->fails())
        {
            toast('All Fields are required','warning');
        }
        else{
            $matrix = new Matrix();
            $matrix->name = $request->name;
            $matrix->maximum = $request->maximum;
            $matrix->organization_id = Auth::user()->organization_id;
            $matrix->description = $request->description;
            $matrix->save();
        }
        return redirect()->back();
    }
    public function update(Request $request)
    {
        $update = Matrix::findOrFail($request->id);
        $update->name = $request->name;
        $update->description = $request->description;
        $update->maximum = $request->maximum;
        $update->push();
        toast('Updated Matrix','info');
        return redirect()->back();
    }
}
