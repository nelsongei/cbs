<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StmtTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'organization_id',
        'bank_statement_id',
        'sr_no',
        'transaction_date',
        'value_date',
        'description',
        'ref_no',
        'cust_ref_no',
        'transaction_amnt',
        'type',
        'status',
        'running_balance'
    ];
}
