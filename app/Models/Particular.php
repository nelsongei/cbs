<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Particular extends Model
{
    use HasFactory;
    public function credit()
    {
        return $this->belongsTo(Account::class,'credit_account_id');
    }
    public function debit()
    {
        return $this->belongsTo(Account::class,'debit_account_id');
    }
}
