<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProposalEntryController extends Controller
{
    //
    public function index(Request $request)
    {
        $set_year = $request->get('year');
        if ($set_year == null || empty($set_year))
            $set_year = date("Y");
        $year = (int)date("Y");
        $years = range($year - 100, $year + 100);
        $projections = array(
            //proposal_entries
            //cbs.proposal_categories
            'Interest' => DB::table('proposal_entries')->select('proposal_entries.year', 'proposal_entries.first_quarter', 'proposal_entries.second_quarter', 'proposal_entries.third_quarter', 'proposal_entries.fourth_quarter', 'proposal_categories.type', 'proposal_categories.name')
                ->join('proposal_categories', 'proposal_entries.proposal_category_id', '=', 'proposal_categories.id')
                ->where('proposal_entries.year', '=', $set_year)
                ->where('proposal_categories.type', '=', 'INTEREST')
                ->get(),
            'Income' => DB::table('proposal_entries')->select('proposal_entries.year', 'proposal_entries.first_quarter', 'proposal_entries.second_quarter', 'proposal_entries.third_quarter', 'proposal_entries.fourth_quarter', 'proposal_categories.type', 'proposal_categories.name')
                ->join('proposal_categories', 'proposal_entries.proposal_category_id', '=', 'proposal_categories.id')
                ->where('proposal_entries.year', '=', $set_year)
                ->where('proposal_categories.type', '=', 'OTHER INCOME')
                ->get(),
            'Expenditure' => DB::table('proposal_entries')->select('proposal_entries.year', 'proposal_entries.first_quarter', 'proposal_entries.second_quarter', 'proposal_entries.third_quarter', 'proposal_entries.fourth_quarter', 'proposal_categories.type', 'proposal_categories.name')
                ->join('proposal_categories', 'proposal_entries.proposal_category_id', '=', 'proposal_categories.id')
                ->where('proposal_entries.year', '=', $set_year)
                ->where('proposal_categories.type', '=', 'EXPENDITURE')
                ->get()
        );
        $projections1 = array(
            'Interest' => DB::table('proposal_categories')->where('type', '=', 'INTEREST')->get(),
            'Income' => DB::table('proposal_categories')->where('type', '=', 'OTHER INCOME')->get(),
            'Expenditure' => DB::table('proposal_categories')->where('type', '=', 'EXPENDITURE')->get()
        );
        return view('projections.index',compact('years','year','projections','projections1','set_year'));
    }
}
