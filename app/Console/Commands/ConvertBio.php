<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ConvertBio extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'convert:bio';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Grab bio for users';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        DB::connection('old')->table('user')
            ->select('id', 'text')
            ->orderBy('id', 'DESC')
            ->where('checked', 1)
            ->chunk(100, function ($oldUsers) {
                foreach ($oldUsers as $oldUser) {
                    DB::table('user_bios')->insert([
                        'user_id' => $oldUser->id,
                        'language' => 'uk',
                        'text' => strip_tags($oldUser->text),
                    ]);
                }
            });
    }
}
