<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanProduct extends Model
{
    use HasFactory;
    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }
    public function loans()
    {
        return $this->hasMany(LoanApplication::class,'loan_product_id');
    }
}
