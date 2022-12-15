<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MemberExportTemplate implements FromArray,WithHeadings,ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function array(): array
    {
        //
        return [];
    }

    public function headings(): array
    {
        return [
            "Firstname",
            "Lastname",
            "Email",
            "Phone",
            "Title",
            "ID No",
            "Date Of Birth",
            "Nationality",
            "Gender",
        ];
    }
}
