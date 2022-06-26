<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderShipped;
use App\Models\Order;
use App\Jobs\SendOrderEmail;
use Log;
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
}
