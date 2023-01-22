<?php

namespace App\Exports;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;

class LoanTemplate implements FromArray,WithHeadings,WithEvents
{
    
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $results;

    protected  $users;
    protected  $selects;
    protected  $row_count;
    protected  $column_count;
    public function __construct()
    {
        $savingaccounts = DB::table('saving_loan_accounts')->where('organization_id',Auth::user()->organization_id)->pluck('loan_account')->toArray();
        $selects=[  //selects should have column_name and options
            ['columns_name'=>'A','options'=>array_merge($savingaccounts)],
        ];
        $this->selects=$selects;
        $this->row_count=1000;//number of rows that will have the dropdown
        $this->column_count=1000;//number of columns to be auto sized
    }
    public function array(): array
    {
        //
        return [];
    }
    public function headings(): array
    {
        return [
            'Loan Account',
            'Date',
            'Principal Paid',
            'Interest Paid',
            'Bank Ref',
        ];
    }
    public function registerEvents(): array
    {
        return [
            AfterSheet::class=>function(AfterSheet $event) {
                $event->sheet->getDelegate()->getColumnDimension('A')->setWidth(30);
                $event->sheet->getDelegate()->getColumnDimension('B')->setWidth(20);
                $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(20);
                $event->sheet->getDelegate()->getColumnDimension('D')->setWidth(20);
                $event->sheet->getDelegate()->getColumnDimension('E')->setWidth(20);

                //
                $row_count = $this->row_count;
                $column_count = $this->column_count;
                foreach ($this->selects as $select){
                    $drop_column = $select['columns_name'];
                    $options = $select['options'];
                    // set dropdown list for first data row
                    $validation = $event->sheet->getCell("{$drop_column}2")->getDataValidation();
                    $validation->setType(DataValidation::TYPE_LIST );
                    $validation->setErrorStyle(DataValidation::STYLE_INFORMATION );
                    $validation->setAllowBlank(false);
                    $validation->setShowInputMessage(true);
                    $validation->setShowErrorMessage(true);
                    $validation->setShowDropDown(true);
                    $validation->setErrorTitle('Input error');
                    $validation->setError('Value is not in list.');
                    $validation->setPromptTitle('Pick from list');
                    $validation->setPrompt('Please pick a value from the drop-down list.');
                    $validation->setFormula1(sprintf('"%s"',implode(',',$options)));

                    // clone validation to remaining rows
                    for ($i = 3; $i <= $row_count; $i++) {
                        $event->sheet->getCell("{$drop_column}{$i}")->setDataValidation(clone $validation);
                    }
                }
            }
        ];
    }
}
