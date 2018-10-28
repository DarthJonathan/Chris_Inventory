<?php

use Illuminate\Database\Seeder;

class PurchasesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        $limit = 100;

        for($i = 0; $i < $limit; $i++) {
            DB::table('purchases')->insert([ //,
                'product_id'    => $faker->numberBetween(0, 100),
                'transaction_id'=> $faker->numberBetween(0, 100),
                'quantity'      => $faker->randomDigitNotNull,
                'price'         => $faker->randomNumber(3),
                'discount'      => $faker->randomNumber(1),
                'purchase_date' => $faker->dateTimeThisMonth()
            ]);
        }
    }
}
