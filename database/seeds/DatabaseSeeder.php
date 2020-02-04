<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         $this->call(DependencyTypeSeeder::class);
         $this->call(EmailSeeder::class);
         $this->call(GitTypeSeeder::class);
    }
}
