<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderShipped;
use App\Models\Order;
use App\Jobs\SendOrderEmail;
use App\Jobs\UserEmail;
use Log;
use Illuminate\Bus\Batch;
use Illuminate\Support\Facades\Bus;

class MailController extends Controller
{
    public function index() {
        for ($i=0; $i<20; $i++) { 
            $order = Order::findOrFail( rand(1,50) ); 
            SendOrderEmail::dispatch($order)->onQueue('email');
        }
        return 'Dispatched orders';

        // Log::info('Dispatched order ' . $order->id);
        // return 'Dispatched order ' . $order->id;
    }
    /**
     * to run a particular job in multiple times at paralel
     * to use this we need to use batchable in our job
     * and also we need to migrate a batchable table
     * it store each batch records also we can retrive it using variou methods
    */
    public function jobBatching(){
        $order = Order::findOrFail( rand(1,50) ); 
        $batch = Bus::batch([
            new SendOrderEmail($order),
            new SendOrderEmail($order),
            new SendOrderEmail($order),
            new SendOrderEmail($order),
            new SendOrderEmail($order),
        ])->name('order email')->onQueue('email')->then(function (Batch $batch) {
            // All jobs completed successfully...
        })->catch(function (Batch $batch, Throwable $e) {
            // First batch job failure detected...
        })->finally(function (Batch $batch) {
            // The batch has finished executing...
        })->dispatch();

        //retrive methods
        // The UUID of the batch...
        $batch->id;
        
        // The name of the batch (if applicable)...
        $batch->name;
        
        // The number of jobs assigned to the batch...
        $batch->totalJobs;
        
        // The number of jobs that have not been processed by the queue...
        $batch->pendingJobs;
        
        // The number of jobs that have failed...
        $batch->failedJobs;
        
        // The number of jobs that have been processed thus far...
        $batch->processedJobs();
        
        // The completion percentage of the batch (0-100)...
        $batch->progress();
        
        // Indicates if the batch has finished executing...
        $batch->finished();
        
        // Cancel the execution of the batch...
        $batch->cancel();
        
        // Indicates if the batch has been cancelled...
        $batch->cancelled();
        return $batch->id;
    }
    /**
     * To run a job depending on previous job
     * if previous job fails to next job wont run
     * we have to use jobs have depended
     */
    public function jobChaining(){
        $order = Order::findOrFail( rand(1,50) );
        Bus::chain([
            new UserEmail,
            new SendOrderEmail($order),
        ])->onQueue('email')->dispatch();
        return 1;
    }
}
