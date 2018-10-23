<?php

use Illuminate\Database\Seeder;

class ProductsSeeder extends Seeder
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
            DB::table('products')->insert([
                'product_name'  => $faker->word,
                'description'   => $faker->paragraph
            ]);
        }
    }
}
