<?php

namespace Database\Seeders;

use App\Models\Currency;
use App\Models\TransactionType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;

class CurrencyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Currency::create([
            'name' => 'Kenyan Shilling',
            'shortname' => 'KES',
            'organization_id' => 1,
        ]);
        $transactions = [
            [
                'organization_id' => 1,
                'name' => 'Bill',
            ],
            [
                'organization_id' => 1,
                'name'=>'Cheque',
            ],
            [
                'organization_id' =>1,
                'name'=>'Purchase Order'
            ],
            [
                'organization_id' =>1,
                'name'=>'Transfer',
            ],
            [
                'organization_id'=>1,
                'name'=>'Supplier Credit'
            ]
        ];
        TransactionType::insert($transactions);
    }
}
