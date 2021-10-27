<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Jobs\RecountUserRatings;

class RecountUsersRating extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'recount:rating';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Recount all users rating';


    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $userIds = DB::table('users')->select('id')->get();
        foreach ($userIds as $user) {
            RecountUsersRatings::dispatch($user->id);
        }
    }
}
