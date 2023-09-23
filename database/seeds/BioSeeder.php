<?php

namespace Database\Seeders;

use App\Models\UserBio;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = \App\Models\User::all();
        foreach ($users as $user) {
            foreach (['en', 'uk'] as $lang) {
                UserBio::factory(['language' => $lang, 'user_id' => $user->id])->create();
            }
        }
    }
}
