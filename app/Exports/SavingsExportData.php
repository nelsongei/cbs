<?php

namespace App\Exports;

use App\Models\Saving;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ToModel;

class SavingsExportData implements ToModel
{
    /**
    */
    public function model(array $row)
    {
        //
        return new Saving([]);
    }
}
