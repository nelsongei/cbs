<?php

namespace App\Http\Controllers;

use App\Models\AssetCategory;
use App\Models\Department;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssetController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $suppliers = Supplier::where('organization_id',Auth::user()->organization_id)->orderBy('id')->get();
        $categories = AssetCategory::where('organization_id',Auth::user()->organization_id)->orderBy('id')->get();
        $departments = Department::where('organization_id',Auth::user()->organization_id)->orderBy('id')->get();
        return view('assets.index',compact('suppliers','categories','departments'));
    }
}
