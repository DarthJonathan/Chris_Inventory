<?php

use Illuminate\Database\Seeder;

class TransactionsSeeder extends Seeder
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
            DB::table('transactions')->insert([
                'type'              => $faker->randomElement(['Purchase', 'sales']),
                'invoice_id'        => $faker->numerify('####-INV-##-##'),
                'tax_invoice_id'    => $faker->randomNumber(1)
            ]);
        }
    }
}
