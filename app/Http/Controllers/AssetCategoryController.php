<?php

namespace App\Http\Controllers;

use App\Models\AssetCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AssetCategoryController extends Controller
{
    //
    public function index()
    {
        $categories = AssetCategory::where('organization_id',Auth::user()->id)->orderBy('id')->get();
        return view('assets.category',compact('categories'));
    }
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'category'=>'required',
            'asset_type'=>'required',
        ]);
        if ($validate->fails())
        {
            toast('All Fields are required');
        }
        else{
            $category = new AssetCategory();
            $category->organization_id = Auth::user()->organization_id;
            $category->category = $request->category;
            $category->asset_type = $request->asset_type;
            $category->save();
            toast('Successfully Added Asset Category');
        }
        return redirect()->back();
    }
}
