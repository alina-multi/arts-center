<?php

namespace App\Console\Commands;

use App\Console\Traits\getNewUserId;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ConvertVotes extends Command
{
    use getNewUserId;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'convert:votes  {--clear}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Convert from old votes table to new';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if ($this->option('clear')) {
            DB::table('votes')->truncate();
        }

        print "Getting ready to convert votes\n";

        DB::table('works')
            ->orderBy('id', 'DESC')
            ->select('id', 'old_id')->chunk(
                200,
                function ($works) {
                    foreach ($works as $work) {
                        $oldVotes = DB::connection('old')->table('votes')
                            ->orderBy('date', 'DESC')
                            ->select('date', 'ip', 'user')
                            ->where('div', 1)
                            ->where('parent', $work->old_id)
                            ->get();
                        print "Converting for work $work->id \n";
                        foreach ($oldVotes as $oldVote) {
                            DB::table('votes')->insert(
                                [
                                    'votable_id' => $work->id,
                                    'votable_type' => 'work',
                                    'ip' => $oldVote->ip,
                                    'created_at' => $oldVote->date,
                                    'updated_at' => $oldVote->date,
                                    'user_id' => $this->getNewUserId($oldVote->user),
                                    'vote'=>1
                                ]
                            );
                        }
                    }
                }
            );
    }
}
