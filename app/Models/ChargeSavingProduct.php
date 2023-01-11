<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChargeSavingProduct extends Model
{
    use HasFactory;
    public function charge(){
        return $this->belongsTo(Charge::class);
    }
    public function product(){
        return $this->belongsTo(SavingProduct::class,'saving_product_id');
    }
}
