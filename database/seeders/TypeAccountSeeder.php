<?php

namespace Database\Seeders;

use App\Models\TypeAccount;
use App\Models\Organization;
use Illuminate\Database\Seeder;

class TypeAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $accounts = [
            [
                'name'=>'Balance Sheet',
                'organization_id'=>Organization::pluck('id','id')->first(),
            ],
            [
                'name'=>'Revenue',
                'organization_id'=>Organization::pluck('id','id')->first(),
            ],
            [
                'name'=>'Expense',
                'organization_id'=>Organization::pluck('id','id')->first(),
            ]
        ];
        TypeAccount::insert($accounts);
    }
}
