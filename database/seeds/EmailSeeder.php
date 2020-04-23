<?php

use Faker\Factory;
use Illuminate\Database\Seeder;

class EmailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        foreach (range(0,10)as $item) {
            \App\Models\Emails\Email::create([
                'title' => $faker->email
            ]);
        }

    }
}
