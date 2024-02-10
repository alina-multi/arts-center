<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ConvertAll extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'convert:all {--clear}';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->call('convert:cat', ['--clear' => $this->option('clear')]);
        $this->call('convert:users', ['--clear' => $this->option('clear')]);
        $this->call('convert:avatars');
        $this->call('convert:works', ['--clear' => $this->option('clear')]);
        $this->call('convert:comments', ['--clear' => $this->option('clear')]);
        $this->call('convert:votes', ['--clear' => $this->option('clear')]);
    }
}
