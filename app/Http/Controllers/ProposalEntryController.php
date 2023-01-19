<?php

namespace App\Http\Controllers;

use App\Models\ProposalCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProposalEntryController extends Controller
{
    //
    public function index(Request $request)
    {
        $set_year = $request->year;
        if ($set_year == null || empty($set_year))
        {
            $set_year = date("Y");
        }
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
        $categories = ProposalCategory::where('organization_id',Auth::user()->organization_id)->get();
        return view('projections.index',compact('years','year','projections','projections1','set_year','categories'));
    }
    public function storeCategory(Request $request)
    {
        $category = new ProposalCategory();
        $category->organization_id = Auth::user()->organization_id;
        $category->name = $request->name;
        $category->type = $request->type;
        $category->save();
        toast('Successfully Added Category','success');
        return redirect()->back();
    }
    public function store(Request $request){
        $projections = array(
            'Interest' => DB::table('proposal_categories')->where('type', '=', 'INTEREST')->get(),
            'Income' => DB::table('proposal_categories')->where('type', '=', 'OTHER INCOME')->get(),
            'Expenditure' => DB::table('proposal_categories')->where('type', '=', 'EXPENDITURE')->get()
        );
        

        // foreach ($projections as $title => $projection) {
        //     foreach ($projection as $category) {
        //         foreach (range(1, 4) as $value) {
        //             $rules[$title . '.' . $category->name . '.' . $value] = 'required|integer';
        //         }
        //     }
        // }
      //  dd($request->year);
        // dd($projections);

        // $validator = Validator::make($date = Input::all(), $rules);
        // if ($validator->fails()) {
        //     return Redirect::back()->withErrors($validator)->withInput();
        // }

        foreach ($projections as $title => $projection) {
            foreach ($projection as $category) {
                DB::table('proposal_entries')->insert(array(
                    'proposal_category_id' => $category->id,
                    'year' => $request->year,
                    'organization_id'=>Auth::user()->organization_id,
                    'first_quarter' => request($title)[$category->name][1],
                    'second_quarter' => request($title)[$category->name][2],
                    'third_quarter' => request($title)[$category->name][3],
                    'fourth_quarter' => request($title)[$category->name][4],
                ));
            }
        }
        toast('Success','success');
        return redirect()->back();
    }
}
