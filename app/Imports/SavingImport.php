<?php

namespace App\Imports;

use App\Models\Saving;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class SavingImport implements ToModel,WithStartRow
{
    use Importable;
    /**
    * @param Collection $collection
    */
    public function model(array $row)
    {
        return new Saving([]);
    }
    public function startRow(): int
    {
        return 2;
    }
}
