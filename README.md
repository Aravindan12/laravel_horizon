<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel Horizon

Laravel is queue monitorig dashboard to get this in your project we need to do few steps listed below:
- create a job and dispatch it in your controller.
- composer require predis/predis for redis connection.
- QUEUE_CONNECTION=redis make queue connection in redis to get realtime update
- 'client' => env('REDIS_CLIENT', 'predis'), make predis as a client in redis key inside the database.php
- composer require laravel/horizon and the install horizonn package and publish it.
- 'local' => [
      'supervisor-1' => [
          'connection' => 'redis',
          'queue' => ['email'],
          'balance' => 'auto',
          'processes' => 6,
          'tries' => 3,
    ],
    ],
    make these changes in horizon.php.
- use ->onQueue('email') while dispatching a job.
- use php artisan horizon instead of queue:work.
- Horizon::auth(function ($request) {
            // Always show admin if local development
            if (env('APP_ENV') == 'local') {
                return true;
            }
        });
   These code inside your AppServiceProvider.
 - http://your_ip/horizon while provide the horizon dashboard.
You will able to see the queue report in that dashboard.

