<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Group;
use App\Models\Member;
use App\Models\MemberContact;
use App\Models\MemberEmployment;
use App\Models\MemberGuarantor;
use App\Models\MemberKin;
use App\Models\ShareAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class MemberController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $groups = Group::orderBy('id')->get();
        $branches = Branch::orderBy('id')->get();
        $members = Member::where('organization_id',Auth::user()->organization_id)->where('is_active',1)->orderBy('id')->get();
        $inactive = Member::where('organization_id',Auth::user()->organization_id)->where('is_active',0)->orderBy('id')->get();
        return view('members.index', compact('groups', 'branches','members','inactive'));
    }

    public function store(Request $request)
    {
        //dd($request->all());
        $validate = Validator::make($request->all(), [
            'firstname' => 'required',
            'lastname' => 'required',
            'title'=>'required',
            'membership_no'=>'required',
            'id_no'=>'required',
            'marital_status'=>'required',
            'group_id'=>'required',
            'branch_id'=>'required',
            'email'=>'required|email|unique:members',
            'phone'=>'required|unique:members',
            'address'=>'required',
            'postal'=>'required',
            'kin_name'=>'required',
            'kin_email'=>'required',
            'kin_relationship'=>'required',
            'is_employed'=>'required',
            'employer_name'=>'required',
            'employment_type'=>'required',
            'designation'=>'required',
            'employment_date'=>'required',
            'employer_address'=>'required',
            'dob'=>'required',
            'kin_id'=>'required',
            'goodwill'=>'required',

        ]);
        if ($validate->passes())
        {
            $member  = new Member();
            $member->firstname = $request->firstname;
            $member->organization_id = Auth::user()->organization_id;
            $member->middlename = $request->middlename;
            $member->lastname = $request->lastname;
            $member->title = $request->title;
            $member->id_no = $request->id_no;
            $member->gender = $request->gender;
            $member->email = $request->email;
            $member->phone = $request->phone;
            $member->membership_no = $request->membership_no;
            $member->nationality = $request->nationality;
            $member->marital_status = $request->marital_status;
            $member->dob = $request->dob;
            $member->password = Hash::make('secret');
            $member->branch_id = $request->branch_id;
            $member->group_id = $request->group_id;
            $member->save();
            /*
             * Contact
             * */
            $this->contact($request,$member->id);
            /*
             * Kin Data
             * */
            $this->kin($request,$member->id);
            /*
             * Employer Data
             * */
            $this->employer($request,$member->id);
            /*
             * Member Shares
             * */
            $this->share($member->id);
        }
        else{
            return response()->json(['failed'=>$validate->errors()->all()]);
        }
        return response()->json(['success'=>'Success']);
    }
    public function contact(Request $request,$id)
    {
        $contact = new MemberContact();
        $contact->member_id = $id;
        $contact->organization_id = Auth::user()->organization_id;
        $contact->email = $request->email;
        $contact->phone = $request->phone;
        $contact->address = $request->address;
        $contact->postal = $request->postal;
        $contact->save();
    }
    public function employer(Request $request,$id)
    {
        $employer  = new MemberEmployment();
        $employer->member_id = $id;
        $employer->organization_id = Auth::user()->organization_id;
        $employer->is_employed = $request->is_employed ? true:false;
        $employer->employer_name = $request->employer_name;
        $employer->employer_address = $request->employer_address;
        $employer->employment_type = $request->employment_type;
        $employer->designation = $request->designation;
        $employer->employment_date = $request->employment_date;
        $employer->save();
    }
    public function kin(Request $request,$id)
    {
        $kin = new MemberKin();
        $kin->member_id = $id;
        $kin->organization_id = Auth::user()->organization_id;
        $kin->kin_name = $request->kin_name;
        $kin->kin_email = $request->kin_email;
        $kin->kin_phone = $request->kin_phone;
        $kin->kin_relationship = $request->kin_relationship;
        $kin->kin_id = $request->kin_id;
        $kin->goodwill = $request->goodwill;
        $kin->save();
        return redirect()->back();
    }
    public function share($id)
    {
        $member = Member::find($id);
        $share = new ShareAccount();
        $share->member_id = $id;
        $share->opening_date = date('Y-m-d');
        $share->account_number = 'SH-' . $member->membership_no;
        $share->organization_id = Auth::user()->organization_id;
        $share->save();
    }
    public function view($id)
    {
        $guarantors = Member::where('organization_id',Auth::user()->organization_id)->where('id','!=',$id)->get();
        $groups = Group::orderBy('id')->get();
        $branches = Branch::orderBy('id')->get();
        $member = Member::where('id', $id)->findOrFail($id);
        return view('members.view', compact('member','groups','branches','guarantors'));
    }

    public function update()
    {

    }
    public function updateKin(Request $request,$id)
    {
        $update = MemberKin::where('id',$id)->findOrFail($id);
        $update->kin_name = $request->kin_name;
        $update->kin_email = $request->kin_email;
        $update->kin_phone = $request->kin_phone;
        $update->kin_relationship = $request->kin_relationship;
        $update->kin_id = $request->kin_id;
        $update->goodwill = $request->goodwill;
        $update->push();
        if ($update)
        {
            toast('Updated Successfully','info');
        }
        return redirect()->back();
    }
    public function deleteKin($id)
    {
        $delete = MemberKin::where('id',$id)->delete();
        if ($delete)
        {
            toast('Deleted Kin','info');
        }
        return redirect()->back();
    }
    public function getGuarantor($id)
    {
        return MemberGuarantor::where('member_id',$id)->with('member')->get();
    }
    public function uploadProfile(Request  $request)
    {
        $validate = Validator::make($request->all(),[
            'file'=>'required|mimes:jpg,jpeg,png,bmp,tiff|max:2048'
        ]);
        if ($validate->fails())
        {
            toast($validate->errors()->all(),'warning');
        }
        else{
            if ($request->hasFile('file'))
            {
                $file = $request->file('file')->store('member','public');
                $profile = Member::findOrFail($request->id);
                $profile->photo = $file;
                $profile->push();
                toast('Profile Saved','success');
            }
        }
        return redirect()->back();
    }
    public function updatePassword(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'old_password'=>'required',
            'new_password'=>'required',
            'confirm_password'=>'required|same:new_password',
        ]);
        if ($validate->fails())
        {
            toast($validate->errors()->all(),'warning');
        }
        else{
            $current = Member::find($request->id)->password;
            if (Hash::check($request->old_password,$current) &&$current!==null)
                {
                    $member = Member::find($request->id);
                    $member->password = Hash::make($request->new_password);
                    $member->push();
                    toast('Successfully updated password','success');
                }
            else{
                toast('Old Password doesnt match','info');
            }
        }
        return redirect()->back();
    }
}
