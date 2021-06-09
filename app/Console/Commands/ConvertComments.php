<?php

namespace App\Console\Commands;

use App\Console\Traits\getNewUserId;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ConvertComments extends Command
{
    use getNewUserId;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'convert:comments {--clear}';

    protected $quill;

    private $simple_replace=[
        'b' => 'b',
        'i' => 'i',
        'u' => 'u',
        'quote' => 'blockquote',
        'code' => 'code',
        'list' => 'ul',
    ];


    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->quill = new \Everyday\HtmlToQuill\HtmlConverter();
        if ($this->option('clear')) {
            DB::table('comments')->truncate();
        }
        DB::table('works')
            ->orderBy('id', 'DESC')
            ->select('id', 'old_id')->chunk(200, function ($works) {
                foreach ($works as $work) {
                    $oldComments = DB::connection('old')->table('comments')
                        ->orderBy('id', 'DESC')
                        ->select('id', 'date', 'text', 'user')
                        ->where('div', 1)
                        ->where('parent', $work->old_id)
                        ->where('deleted_by',0)
                        ->get();
                    $commentsCount = 0;
                    foreach ($oldComments as $oldComment) {
                        print "Converting comment: " . $oldComment->id . ": " . $oldComment->text . "\n";
                        print "------------------\n";
                        $convertedText = $this->convertSmilyToEmoji($oldComment->text);
                        $convertedDelta = $this->convertBbcodeToDelta($convertedText);
                        if ($convertedDelta) { // For some reason we have empty comments
                            DB::table('comments')->insert([
                                'commentable_id' => $work->id,
                                'commentable_type' => 'work',
                                'body' => json_encode($convertedDelta, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
                                'created_at' => $oldComment->date,
                                'user_id' => $this->getNewUserId($oldComment->user)
                            ]);
                            $commentsCount++;
                        }
                    }
                    DB::table('works')->where('id', $work->id)->update(['comments' => $commentsCount]);
                }
            });
    }

    public function convertSmilyToEmoji($text)
    {
        foreach ([
                     ':sad:' => '🙁',
                     ':smile:' => '🙂',
                     ':happy:' => '😊',
                     ':rolleyes:' => '🙄',
                     ':cool:' => '😎',
                     ':biggrin:' => '😆',
                     ':blink:' => '😲',
                     ':blush:' => '😚',
                     ':dry:' => '🤨',
                     ':laugh:' => '😂',
                     ':mad:' => '😡',
                     ':sleep:' => '😴',
                     ':tongue:' => '😝',
                     ':unsure:' => '🤔',
                     ':wacko:' => '🤪',
                     ':wink:' => '🥴',
                     ':beer:' => '🍺',
                     ':shake_hand:' => '🤝',
                     ':upset:' => '🤔',
                     ':umnik:' => '🧐',
                     ':see:' => '🤬',
                     ':flower:' => '💐',
                     ':crazy:' => '🤪',
                     ':poke2:' => '🤮',
                     ':pray:' => '🙏🏻',
                     ':wub:' => '🥰'
                 ] as $search => $replace) {
            $text = str_replace($search, $replace, $text);
        }
        return $text;
    }

    function convertBbcodeToDelta($text)
    {
        if (!$text or $text === ' ') {
            return;
        }
        $html = $this->parseBBCode($text);
        if (!$html or mb_strlen($html) < 2) {
            return;
        }
        return $this->quill->convert($html)->jsonSerialize();
    }

    // Original code from old site without smiles
    public function parseBBCode($text)
    {
        if (strpos($text,'[quote')) {
            print "Have [quote here \n";
        }
        //Удаляем ХТМЛ
        $text = strip_tags($text);

        //Простые теги
        foreach ($this->simple_replace as $k => $v) {
            $text = str_replace('[' . $k . ']', '<' . $v . '>', $text, $count_open);
            $text = str_replace('[/' . $k . ']', '</' . $v . '>', $text, $count_closed);
            if ($count_open > $count_closed) {
                //print "There are :".($count_open-$count_closed)." unclosed <$k> tags";
                $text = $text . str_repeat('</' . $v . '>', $count_open - $count_closed);
            } elseif ($count_open < $count_closed) {
                $text = str_repeat('<' . $v . '>', $count_closed - $count_open) . $text;
            }
        }
        //<li>
        $text = str_replace('[*]', '<li>', $text);
        //<img>
        $text = preg_replace('/\[img\](.*?)\[\/img\]/', '<img src="$1">', $text);
        //Новые строки
        $text = nl2br($text);
        //Ссылки

        $text = preg_replace_callback(
            '/\[url={0,1}(.*?)\](.*?)\[\/url\]/m',
            function ($matches) {
                return strlen($matches[1]) ? "<a href=\"$matches[1]\" rel=\"nofollow\" target=\"_blank\">$matches[2]</a>" : "<a href=\"$matches[2]\" rel=\"nofollow\" target=\"_blank\">$matches[2]</a>";
            },
            $text
        );

        return $text;
    }
}
