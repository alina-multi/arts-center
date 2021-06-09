<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Google\Cloud\Translate\V2\TranslateClient;

class TestGoogle extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:google';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $translate = new TranslateClient();
        $result = $translate->translate('Жанровая картина', [
            'target' => 'en',
        ]);
        print_r($result);
    }
}
