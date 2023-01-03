<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UsersController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $roles = Role::all();
        $users = User::where('organization_id',Auth::user()->organization_id)->orderBy('id')->get();
        return view('admin.index',compact('users','roles'));
    }
    public function store(Request $request)
    {
        $user = new User();
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->organization_id = Auth::user()->organization_id;
        $user->password = Hash::make($request->password);
        $user->save();

        //Assign Role
        $user->assignRole([$request->role]);
        if($user)
        {
            toast('Successfully Added User','success');
        }
        return redirect()->back();
    }
}
