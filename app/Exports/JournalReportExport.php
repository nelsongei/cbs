<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class JournalReportExport implements FromView,ShouldAutoSize
{
    /**
    */
    public function view(): View
    {
        //
        return view('pdf.journal');
    }
}
