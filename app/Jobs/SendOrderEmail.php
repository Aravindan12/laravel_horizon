<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderShipped;
use App\Models\Order;
use Log;
class SendOrderEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $order;

	public function __construct(Order $order)
	{
		$this->order = $order;
	}

	public function handle()
	{
        // Allow only 2 emails every 1 second
        // Redis::throttle('any_key')->allow(2)->every(1)->then(function () {

            $recipient = 'hello@mailinator.com';
            Mail::to($recipient)->send(new OrderShipped($this->order));
            Log::info('Emailed order ' . $this->order->id);

        // }, function () {
        //     // Could not obtain lock; this job will be re-queued
        //     return $this->release(2);
        // });

	}
}
