<?php

namespace App\Imports;

use App\Models\Member;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class MemberImport implements ToModel,WithStartRow
{
    use Importable;
    /**
     * @param array $row
     */
    public function model(array $row)
    {
        return new Member([]);
    }

    public function startRow(): int
    {
        return 2;
    }
}

        // $id = (count(Member::where('organization_id',Auth::user()->organization_id)->get())) + 1;
        // return new Member([
        //     'firstname' => $row[0],
        //     'lastname' => $row[1],
        //     'email' => $row[2],
        //     'phone' => $row[3],
        //     'title' => $row[4],
        //     'address' => $row[5],
        //     'id_no' => $row[6],
        //     'branch_id' => 1,
        //     'group_id' => 1,
        //     'membership_no' => ('Lixnet -- ' . $id),
        //     'dob' => $row[7],
        //     'nationality' => $row[8],
        //     'gender' => $row[9],
        //     'organization_id' => Auth::user()->organization_id,
        // ]);
        //$id++;