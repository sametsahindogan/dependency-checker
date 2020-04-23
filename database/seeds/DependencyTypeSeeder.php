<?php

use Illuminate\Database\Seeder;

class DependencyTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (['packagist', 'npm'] as $type) {
            \App\Models\Dependencies\DependencyType::create([
                'title' => $type
            ]);
        }
    }
}
