<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Account extends Model
{
    use HasFactory;
    public static function getAccountBalanceAtDate($account, $date)
    {
        $balance = 0;
        $credit =
            //Journal::where('organization_id',Auth::user()->organization_id)->where('account_id',$account->id)->where('type','credit')->where('date','<=',$date)->where('archived',false)->sum('amount');
            DB::table('journals')->where('account_id', '=', $account->id)->where('type', '=', 'credit')->where('date', '<=', $date)->where('archived', false)->sum('amount');
        $debit = DB::table('journals')->where('account_id', '=', $account->id)->where('type', '=', 'debit')->where('date', '<=', $date)->where('archived', false)->sum('amount');
//        dd($credit);
        if ($account->category == 'ASSET') {
            $balance = $debit - $credit;
        }
        if ($account->category == 'INCOME') {
            $balance = $credit - $debit;
        }
        if ($account->category == 'LIABILITY') {
            $balance = $credit - $debit;
        }
        if ($account->category == 'EQUITY') {
            $balance = $credit - $debit;
        }
        if ($account->category == 'EXPENSE') {
            $balance = $debit - $credit;
        }
        return $balance;
    }
    public function category()
    {
        return $this->belongsTo(AccountCategory::class,'account_category_id');
    }
}
