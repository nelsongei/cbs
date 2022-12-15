<?php

namespace App\Imports;

use App\Http\Controllers\MemberController;
use App\Models\Member;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class MemberImport implements ToModel,WithStartRow
{
    /**
    * @param array $row
    */
    public function model(array $row)
    {
        $id = (count(Member::all()))+1;
        return new Member([
           'firstname'=>$row[0],
            'lastname'=>$row[1],
            'email'=>$row[2],
            'phone'=>$row[3],
            'title'=>$row[4],
            'id_no'=>$row[5],
            'branch_id'=>1,
            'group_id'=>1,
            'membership_no'=>('Lixnet -- '.rand(1,10000)),
            'dob'=>$row[6],
            'nationality'=>$row[7],
            'gender'=>$row[8],
            'organization_id'=>Auth::user()->organization_id,
        ]);
    }

    public function startRow(): int
    {
        return 2;
    }
}
