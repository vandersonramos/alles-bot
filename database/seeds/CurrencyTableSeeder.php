<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CurrencyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('currencies')->insert([
            'name' => 'Brazilian Real',
            'code' => 'BRL'
        ]);

        DB::table('currencies')->insert([
            'name' => 'Turkmenistan Manat',
            'code' => 'TMT'
        ]);

        DB::table('currencies')->insert([
            'name' => 'US Dollar',
            'code' => 'USD'
        ]);

        DB::table('currencies')->insert([
            'name' => 'Bitcoin',
            'code' => 'BTC'
        ]);

        DB::table('currencies')->insert([
            'name' => 'Mexican Peso',
            'code' => 'MXN'
        ]);

        DB::table('currencies')->insert([
            'name' => 'Euro',
            'code' => 'EUR'
        ]);

        DB::table('currencies')->insert([
            'name' => 'British Pound',
            'code' => 'GBP'
        ]);

        DB::table('currencies')->insert([
            'name' => 'Albanian Lek',
            'code' => 'ALL'
        ]);

        DB::table('currencies')->insert([
            'name' => 'East Caribbean Dollar',
            'code' => 'XCD'
        ]);

        DB::table('currencies')->insert([
            'name' => 'Indian Rupee',
            'code' => 'INR'
        ]);

        DB::table('currencies')->insert([
            'name' => 'Chinese Yuan',
            'code' => 'CNY'
        ]);

        DB::table('currencies')->insert([
            'name' => 'Costa Rican Colon',
            'code' => 'CRC'
        ]);
    }
}
