<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ConvertDeltaToTextInComments extends Command
{
    protected $signature = 'convert:comments-delta';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        DB::table('comments')
            ->orderBy('id')
            ->select('id', 'body')->chunk(1000, function ($comments) {
                foreach ($comments as $comment) {
                    print "Converting comment: $comment->id \n";
                    $text = strip_tags((new \nadar\quill\Lexer($comment->body))->render());
                    DB::table('comments')->where('id', $comment->id)->update(['text' => $text]);
                }
            });
    }
}
