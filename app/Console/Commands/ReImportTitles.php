<?php

namespace App\Console\Commands;

use App\Models\Work;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class ReImportTitles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:re-import-titles';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Work::whereDoesntHave('titles')
            ->whereNotNull('old_id')
            ->chunkById(1000, function (Collection $works) {
                $works->map(function (Work $work) {
                    $oldWork = DB::connection('old')->table('gallery')->where('id', $work->id)->first();
                    if ($oldWork->title) {
                        $work->titles()->create([
                            'language' => 'ru',
                            'title' => $oldWork->title,
                            'description' => $oldWork->desc
                        ]);
                        $this->line("Created title for work $work->id");
                    }
                });
            });
    }
}
