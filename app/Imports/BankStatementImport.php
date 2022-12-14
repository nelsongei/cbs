<?php

namespace App\Imports;

use App\Models\StmtTransaction;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;

class BankStatementImport implements ToModel
{
    protected $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * @param array $row
     */
    public function model(array $row)
    {
        //
        return new StmtTransaction([
            'organization_id' => Auth::user()->organization_id,
            'bank_statement_id' => $this->id,
            'sr_no' => $row[0],
            'transaction_date' => $row[1],
            'value_date' => $row[2],
            'description' => $row[5],
            'ref_no' => $row[3],
            'cust_ref_no' => $row[4],
            'transaction_amnt' => $row[6] == '-' ? $row[7] : $row[6],
            'type' => $row[6] == '-' ? 'credit' : 'debit',
            'status'=>'unreconciled',
            'running_balance'=>$row[8],
        ]);
    }
}
