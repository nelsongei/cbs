<?php

namespace App\Http\Controllers;

use App\Jobs\UpdateLoanSavingAccount;
use Illuminate\Http\Request;

class AccountTransactionController extends Controller
{
    //
    public function loanSavingAccount()
    {
        $account = new UpdateLoanSavingAccount();
        $this->dispatch($account);
    }
}
