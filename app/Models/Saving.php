<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Saving extends Model
{
    use HasFactory;
    public function member()
    {
        return $this->belongsTo(Member::class);
    }
    public function account()
    {
        return $this->belongsTo(SavingAccount::class,'saving_account_id');
    }
}
