<?php

namespace App\Console\Commands;
use Illuminate\Support\Facades\Mail;
use Illuminate\Console\Command;
class SendTaskReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emails:tasks {email?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email for tasks';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $emailId = $this->argument('email');
        echo "Sending mail to ". $emailId. "...\n";
        Mail::raw('Raw string email',
            function($msg) use ($emailId) {
                $msg->to([$emailId]);
            }
        );
        echo "Mail sent.";
    }
}
