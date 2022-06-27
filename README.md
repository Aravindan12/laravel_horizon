<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel Job batching

Laravel job batching is used to execute a set of job at parallel.

- We need to use Bus class and batch function for this inside this need to add an array an add the required jobs at required times.
- Inside the job need to use Batchable class to know that the job is execute as a batch.
- We need to migrate job-batchables table to store the each batch records in db.
- Using this we can retrive a particular using id, name and we can list failed job,processed job list through this.
- And also batch provides then fuction to add logic after the jobs completed and catch for need to do while job fails and finally for logic need to       execute after the batch completed.

## About Laravel Job chaining

Laravel job chaining chain jobs which has the depended of previous job.If the previous job fails rest of thejob won't run after that.Tis also similar to job batching we need to use chain function bus class.

