<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SavingProduct extends Model
{
    use HasFactory;

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function accounts()
    {
        return $this->hasManyThrough(Saving::class, SavingAccount::class);
    }
    public function savingAccounts()
    {
        return $this->hasMany(SavingAccount::class);
    }

    public function postings()
    {
        return $this->hasMany(SavingPosting::class,'saving_product_id');
    }
}
