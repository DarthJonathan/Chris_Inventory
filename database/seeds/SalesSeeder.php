<?php

use Illuminate\Database\Seeder;

class SalesSeeder extends Seeder
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
            DB::table('sales')->insert([
                'price'         => $faker->randomNumber(3),
                'discount'      => $faker->randomNumber(1),
                'sales_date'    => $faker->dateTimeThisMonth(),
                'product_id'    => $faker->numberBetween(0, 100),
                'invoice_no'    => $faker->numerify("INV-####-##-####"),
                'quantity'      => $faker->randomNumber(1)
            ]);
        }
    }
}
