<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountCategory extends Model
{
    use HasFactory;
    public function type()
    {
        return $this->belongsTo(TypeAccount::class,'type_account_id');
    }
}
