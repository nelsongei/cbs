<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BankAccount extends Model
{
    use HasFactory;
    public static function getLastReconciliation($id)
    {
        return DB::table('bank_statements')
            ->where('bank_account_id', $id)
            ->where('is_reconciled', 1)
            ->select('stmt_month')
            ->orderBy('stmt_month', 'DESC')
            ->first();
    }
    public static function getStatement($id)
    {
        return DB::table('bank_statements')
            ->where('bank_account_id', $id)
            ->select('bal_bd as bal_bd', 'stmt_month as stmt_month',
                'created_at as stmt_date', 'is_reconciled')
            ->get();
    }
}
