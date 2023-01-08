<?php

namespace App\Exports;

use App\Models\Branch;
use App\Models\Member;
use App\Models\SavingAccount;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;

class SavingExport implements WithHeadings, WithEvents,FromArray
{
    /**
     */
    protected $results;

    protected  $users;
    protected  $selects;
    protected  $row_count;
    protected  $column_count;
    public function __construct()
    {
        $status=['Bank','Cash'];
        $departments=['credit','debit'];
        $roles=Member::pluck('firstname')->toArray();
        $savingaccounts = SavingAccount::all()->where('organization_id',Auth::user()->organization_id)->pluck('account_number')->toArray();        
        $selects=[  //selects should have column_name and options
            ['columns_name'=>'D','options'=>$departments],
            ['columns_name'=>'G','options'=>$status],
            ['columns_name'=>'B','options'=>array_merge($savingaccounts)],
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
            ["Date", "Account Number", "Amount", "Type", "Description", "Bank REF", "Transaction Method"]
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getDelegate()->getColumnDimension('A')->setWidth(50);
                $event->sheet->getDelegate()->getColumnDimension('B')->setWidth(50);
                $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(50);
                $event->sheet->getDelegate()->getColumnDimension('D')->setWidth(50);
                $event->sheet->getDelegate()->getColumnDimension('E')->setWidth(50);
                $event->sheet->getDelegate()->getColumnDimension('F')->setWidth(50);
                $event->sheet->getDelegate()->getColumnDimension('G')->setWidth(50);
                $event->sheet->getDelegate()->getColumnDimension('H')->setWidth(50);
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
//                 $savingaccounts = SavingAccount::where('organization_id',Auth::user()->organization_id)->get();
//                 $row=2;
//                 for ($i=0;$i<count($savingaccounts);$i++)
//                 {
// //                    $value= collect([]);
//                     $member = Member::find($savingaccounts[$i]->member_id);
//                     $event->sheet->setCellValue("AA".$row,$member->firstname.':'.$savingaccounts[$i]->account_number);
//                     $value = ($member->firstname.':'.$savingaccounts[$i]->account_number);
//                     $row++;
//                 }
//                 $event->sheet->getDelegate()->getParent()->addNamedRange(
//                     new NamedRange(
//                         "accounts",$event->sheet->getDelegate(),'AA2:AA'.(count($savingaccounts)+1)
//                     )
//                 );
            },
        ];
    }
}
