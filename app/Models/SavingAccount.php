<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SavingAccount extends Model
{
    use HasFactory;
    public function member()
    {
        return $this->belongsTo(Member::class);
    }
    public function product()
    {
        return  $this->belongsTo(SavingProduct::class,'saving_product_id');
    }
    public function sumAmount($account,$member)
    {
        return Saving::where('saving_account_id',$account)->where('member_id',$member)->sum('saving_amount');
    }
    public function savings()
    {
        return $this->hasMany(Saving::class,'saving_account_id');
    }
}
