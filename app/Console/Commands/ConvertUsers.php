<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ConvertUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'convert:users {--clear}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Convert from old users table to new';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if ($this->option('clear')) {
            foreach (['users'] as $table) {
                DB::table($table)->truncate();
            }
        }
        $now = date('Y-m-d H:i:s');
        $idsAllreadyInDb = User::get()->pluck('old_id')->toArray();
        $GLOBALS['emailsAllreadyInDb'] = User::get()->pluck('email')->toArray();
        $GLOBALS['emailsAllreadyInDb'] = array_map('strtolower', $GLOBALS['emailsAllreadyInDb']);
        DB::connection('old')->table('user')
            ->select('id', 'username', 'password', 'name', 'lastname', 'email', 'reg_date')
            ->orderBy('id', 'DESC')
            ->whereNotIn('id', $idsAllreadyInDb)
            ->where('checked',1)
            ->chunk(100, function ($oldUsers) use ($now) {
                foreach ($oldUsers as $oldUser) {
                    $oldUser=(array) $oldUser;
                    $oldUser['email']  = strtolower($oldUser['email']);
                    if (!$oldUser['email'] || in_array($oldUser['email'], $GLOBALS['emailsAllreadyInDb'])) { //Some users don't have emails, others registered multiple times with same one
                        $oldUser['email'] = $oldUser['username'].'@arts.in.ua';
                    }
                    $validator = Validator::make(
                        $oldUser, [
                            'id' => ['required', 'numeric'],
                            'username' => ['required', 'not_regex:/\W/'],
                            'email' => ['required', 'email'],
                        ]
                    );
                    if ($validator->fails()) {
                        print_r($validator->errors());
                        continue;
                    }
                    print $oldUser['email'] . "\n";

                    User::unguard();
                    User::create([
                        'name' => trim($oldUser['lastname'] . ' ' . $oldUser['name']),
                        'email' => $oldUser['email'],
                        'email_verified_at' => $now,
                        'password' => $oldUser['password'],
                        'created_at' => $oldUser['reg_date'],
                        'username' => $oldUser['username'],
                        'old_id' => $oldUser['id']
                    ]);
                    User::reguard();

                    array_push($GLOBALS['emailsAllreadyInDb'],$oldUser['email']);
                }
            });
    }
}
