<?php

namespace App\Console\Commands;
use Illuminate\Support\Facades\Mail;
use Illuminate\Console\Command;
use App\Models\User;
use App\Mail\MyMail;

class SendMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:send {user}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'For Sending mail to every User';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $user = User::find($this->argument('user'));
            if(!$user) {
                $this->error("User[".$this->argument('user')."] not found.");
                exit;
            }
            $email = $user->email;
            $body= [
                'name'=>$user->name,
                'url_a'=>'https://www.serveravatar.com/',
                'url_b'=>'https://gamexpot7.wordpress.com/'
            ];
        
            //\Mail::to($email)->send(new MyMail($body));

            $this->info("User[".$this->argument('user')."] mail send.");
        } catch(\Execption $e) {
            report($e);
            $this->error("User[".$this->argument('user')."] mail not send.");
        }
    }
}
