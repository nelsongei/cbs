<?php

namespace App\Jobs;

use App\Models\LoanApplication;
use App\Models\Member;
use App\Models\SavingAccount;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class UpdateLoanSavingAccount implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        $member_id = Member::pluck('id')->toArray();
        $org_id = Member::pluck('organization_id')->toArray();
        for($i=0;$i<count($member_id);$i++)
        {
            if(DB::table('saving_loan_accounts')->where('member_id',$member_id[$i])->first()){
                $memberNames = DB::table('members')->where('id',$member_id[$i])->pluck('firstname','lastname')->toArray();
                $names = Member::where('id',$member_id[$i])->get();
                foreach($names as $s)
                {
                    $saving = SavingAccount::where('organization_id',$org_id[$i])->where('member_id',$s->id)->pluck('account_number')->first();
                    if($saving)
                    {
                        DB::table('saving_loan_accounts')->where('member_id',$member_id[$i])->update(['saving_account'=>$s->firstname.' '.$s->middename.' '.$s->lastname.':'.$saving]);
                    }
                    $loans = LoanApplication::where('organization_id',$org_id[$i])->where('member_id',$s->id)->pluck('account_number')->first();
                    if($loans) {
                        DB::table('saving_loan_accounts')->where('member_id',$member_id[$i])->update(['loan_account'=>$s->firstname.' '.$s->middename.' '.$s->lastname.':'.$loans]);
                    }
                }
            }
            else{
                DB::table('saving_loan_accounts')->insert(['organization_id'=>$org_id[$i],'member_id'=>$member_id[$i]]);
            }
        }
    }
}
