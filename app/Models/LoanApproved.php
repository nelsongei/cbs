<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanApproved extends Model
{
    use HasFactory;
    public function loan()
    {
        return $this->belongsTo(LoanApplication::class,'loan_application_id');
    }
}
