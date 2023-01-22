<?php

namespace Database\Seeders;

use App\Models\Currency;
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
            'name'=>'Kenyan Shilling',
            'shortname'=>'KES',
            'organization_id'=>1,
        ]);
    }
}
