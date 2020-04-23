<?php

use Illuminate\Database\Seeder;

class GitTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (['github', 'bitbucket'] as $item) {
            \App\Models\Repositories\GitTypes::create([
                'title' => $item
            ]);
        }
    }
}
