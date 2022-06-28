<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderShipped;
use App\Models\Order;
use App\Models\User;
use App\Jobs\SendOrderEmail;
use App\Jobs\UserEmail;
use Log;
use Illuminate\Bus\Batch;
use Illuminate\Support\Facades\Bus;
use Hash;
class MailController extends Controller
{

    /**
     * @OA\Get(
     *      path="/test",
     *      operationId="index",
     *      tags={"Projects"},
     *      summary="Get list of projects",
     *      description="Returns list of projects",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *     )
     */
    public function index() {
        for ($i=0; $i<20; $i++) { 
            $order = Order::findOrFail( rand(1,50) ); 
            SendOrderEmail::dispatch($order)->onQueue('email');
        }
        return 'Dispatched orders';
    }
    /**
     * to run a particular job in multiple times at paralel
     * to use this we need to use batchable in our job
     * and also we need to migrate a batchable table
     * it store each batch records also we can retrive it using variou methods
    */

    /**
         * @OA\Get(
         *      path="/test-batch",
         *      operationId="jobBatching",
         *      tags={"Projects"},
         *      summary="Execute job as batch",
         *      description="Execute job as batch",
         *      @OA\Response(
         *          response=200,
         *          description="Successful operation",
         *       ),
         *      @OA\Response(
         *          response=401,
         *          description="Unauthenticated",
         *      ),
         *      @OA\Response(
         *          response=403,
         *          description="Forbidden"
         *      )
         *     )
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
            /**
         * @OA\Get(
         *      path="/test-chain",
         *      operationId="jobChaining",
         *      tags={"Projects"},
         *      summary="Execute job as chain",
         *      description="Execute job as chain",
         *      @OA\Response(
         *          response=200,
         *          description="Successful operation",
         *       ),
         *      @OA\Response(
         *          response=401,
         *          description="Unauthenticated",
         *      ),
         *      @OA\Response(
         *          response=403,
         *          description="Forbidden"
         *      )
         *     )
         */
    public function jobChaining(){
        $order = Order::findOrFail( rand(1,50) );
        Bus::chain([
            new UserEmail,
            new SendOrderEmail($order),
        ])->onQueue('email')->dispatch();
        return 1;
    }
    /**
     * @OA\Post(
     * path="/api/add-user",
     *   tags={"addUser"},
     *   summary="addUser",
     *   operationId="addUser",
     *
     * @OA\RequestBody(
     *        @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 type="object",
     *                  @OA\Property(
     *                     property="name",
     *                     example="Aravind",
     *                      type="string"
     *
     *                  ),
     *                  @OA\Property(
     *                      property="email",
     *                      example="aravin@mailinator.com",
     *                      type="email"
     *                  ),
     *                  @OA\Property(
     *                      property="password",
     *                      example="12345678",
     *                      type="string"
     *                  ),
     *              )
     *          ),
     *      ),
     *   @OA\Response(
     *      response=201,
     *       description="Success",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   ),
     *   @OA\Response(
     *      response=401,
     *       description="Unauthenticated"
     *   ),
     *   @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   ),
     *   @OA\Response(
     *      response=404,
     *      description="not found"
     *   ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *)
     **/
    public function addUser(Request $request){
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();
        return "user added successfully";
    }
}
