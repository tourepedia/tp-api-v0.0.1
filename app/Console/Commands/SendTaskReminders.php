<?php

namespace App\Console\Commands;
use Illuminate\Support\Facades\Mail;
use Illuminate\Console\Command;
use App\Models\User;
use Carbon\Carbon;

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
        // get the users along with tasks
        $data = User::when($emailId, function ($query) use ($emailId) {
            return $query->where("email", $emailId);
        })->with(["tasks" => function ($tasks) {
            $current = new Carbon("UTC");
            $twoDaysNext = $current->copy()->addDays(2);
            $currentDatetTimeString = $current->toDateTimeString();
            $twoDaysNextDateTimeString = $twoDaysNext->toDateTimeString();
            return $tasks->withoutGlobalScopes()
                ->whereNotNull("due_date")
                // due date is within next two days
                ->where("due_date", "<=", $twoDaysNextDateTimeString)
                ->where("due_date", ">", $currentDatetTimeString);
        }])->get();
        foreach ($data as $user) {
            if ($user->tasks && count($user->tasks)) {
                echo "Sending mail to ". $user->email . " ... ";
                $user->tasks = $user->tasks->map(function ($task) {
                    $due_date = new Carbon($task->due_date, "UTC");
                    $due_date->setTimezone("Asia/Kolkata");
                    $task->due_date = $due_date;
                    return $task;
                });
                Mail::send(
                    "emails.tasks",
                    ["user" => $user],
                    function ($msg) use ($user) {
                        $msg->subject("Your tasks for next two days.");
                        $msg->to([$user->email]);
                    }
                );
                echo " : sent. \n";
            }
        }
    }
}
