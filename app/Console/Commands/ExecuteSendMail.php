<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\MyMail;
use App\Models\User;

class ExecuteSendMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:sendmail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'sends mail by user id';

    /**
     * Execute the console command.
     */
    
    public function handle()
    { 
        $users = User::chunk(5,function($users)
        {
            foreach($users as $user)
            {
                \Artisan::queue('email:send', [
                    'user'=> $user->id
                ])->onqueue('default');
                $this->info('mail recived by '.$user->name);
            }
            $users = null;
        });
    }
}