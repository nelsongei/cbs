<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrganizationController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $organization = Organization::find(Auth::user()->organization_id);
        return view('organization.index', compact('organization'));
    }
    public function update(Request $request, $id)
    {
        $organization = Organization::find($id);
        $organization->name = $request->name;
        $organization->website = $request->website;
        $organization->email = $request->email;
        $organization->phone = $request->phone;
        $organization->push();

        if($organization)
        {
            toast('Updated Sussceefully','success');
        }
        return redirect()->back();
    }
}
