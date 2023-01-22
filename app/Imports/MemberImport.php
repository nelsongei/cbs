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