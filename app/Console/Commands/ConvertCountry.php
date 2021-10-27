<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ConvertCountry extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'convert:country';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Grab countries for users';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        DB::connection('old')->table('user')
            ->select('id', 'country_alpha2')
            ->orderBy('id', 'DESC')
            ->where('checked', 1)
            ->chunk(100, function ($oldUsers) {
                DB::where('old_id', $oldUsers->id)->update(['country' => $oldUsers->country_alpha2]);
            });
    }
}
