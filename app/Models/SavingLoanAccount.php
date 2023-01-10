<?php

namespace App\Models;

use Illuminate\Bus\Queueable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SavingLoanAccount extends Model
{
    use HasFactory,Queueable;
    protected $fillable =[
        'organization_id',
        'member_id'
    ];
}
