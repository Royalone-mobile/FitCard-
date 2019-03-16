<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendEmail extends Job implements ShouldQueue
{

    use InteractsWithQueue,
        SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $msg;

    public function __construct($message)
    {
        //
        $this->msg = $message;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $data = $this->msg;
        if ($data['message'] == "welcome") {
            \Mail::queue('mail.welcome', $data, function ($message) use ($data) {
                $message->from(getenv("MAIL_USERNAME"), 'SName');
                $message->to($data['email'], '')->subject('Welcome');
            });
            return;
        }
            \Mail::queue('mail.mail', $data, function ($message) use ($data) {
                $message->from(getenv("MAIL_USERNAME"), 'SName');
                $message->to($data['email'], '')->subject($data['title']);
                if (isset($data['attach'])) {
                    $message->attach(public_path().$data['attach']);
                }
            });
    }
}
