<?php

use Illuminate\Database\Seeder;
use App\Entity\Currency;

class CurrencyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Currency::class, 1)->create();
    }
}
