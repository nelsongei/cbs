<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChargeLoanProduct extends Model
{
    use HasFactory;

    public function charge(){
        return $this->belongsTo(Charge::class);
    }
    public function product(){
        return $this->belongsTo(LoanProduct::class,'loan_product_id');
    }
}

