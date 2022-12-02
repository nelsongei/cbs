<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Journal;
use App\Models\Member;
use App\Models\Particular;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IncomeController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $from=date('Y-m')."-01";
        $to=date('Y-m-t');
        $incomeAccounts = Account::select('id')->where('category', 'INCOME')->get()->toArray();
        $incomes = Journal::whereIn('account_id', $incomeAccounts)
            ->whereNotNull('particular_id')->whereBetween('date',array($from,$to))->get();
        $incomeSums = array();

        foreach ($incomes as $income){
            if(isset($income->particular->name)){

                $particular = $income->particular->name;
//                dd($particular);
                if(key_exists($particular, $incomeSums)) {
                    $incomeSums[$particular]['amount'] += $income->amount;
                }else{
                    $incomeSums[$particular]['amount'] = $income->amount;
                    $incomeSums[$particular]['income'] = $income;
                }
            }}
        //dd($incomeSums);
        $particulars = Particular::whereIn('credit_account_id',$incomeAccounts)->get();
        $members = Member::where('organization_id',Auth::user()->organization_id)->get();
        return view('income.index',compact('particulars','members','incomeSums'));
    }
}
