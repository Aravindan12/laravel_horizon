<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Swagger

It is an api documentaion used to check the api's in a separate page.To achive this we need to the follwoing steps

- composer require darkaonline/l5-swagger install package.
- php artisan vendor:publish --provider "L5Swagger\L5SwaggerServiceProvider" .
- L5_SWAGGER_CONST_HOST=http://project.test/api/ add it in your .env file.
- add the basic info annotation in controller class.
- php artisan l5-swagger:generate run this generate command.
- Add the annotation which has the request data and the responses with the at each function by mentioning its route.
- Annotations are differ for get and post api. check those with the documentation and run again the generate command
- http://project.test/api/documentation you will get the dashboard of api's which has the correct annotation.
