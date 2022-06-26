<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use Illuminate\Bus\Batchable;

use Mail;
class UserEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels,Batchable;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $user = User::first();
            $data = array('name'=>$user->name);
            $recipient = $user->email;
            Mail::send('emails.orders.test', $data, function($message) use($recipient){
                $message->to($recipient, 'user email')->subject('Laravel Basic Testing Mail');
                $message->from('test@gmail.com','test');
             });

    }
}
