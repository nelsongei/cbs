<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;
    public function employer()
    {
        return $this->hasOne(MemberEmployment::class,'member_id');
    }
    public function contact()
    {
        return $this->hasOne(MemberContact::class,'member_id');
    }
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
    public function group()
    {
        return $this->belongsTo(Group::class);
    }
    public function savings()
    {
        return $this->hasMany(Saving::class,'member_id');
    }
    public function accounts()
    {
        return $this->hasMany(SavingAccount::class,'member_id');
    }
    public function kins()
    {
        return $this->hasMany(MemberKin::class);
    }
    public function shares()
    {
        return $this->hasMany(ShareAccount::class);
    }
}
