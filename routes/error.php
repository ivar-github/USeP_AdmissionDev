<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

    //ERROR ROUTES
    Route::middleware(['auth', 'securityHeaders'])->group(function () {

        Route::prefix('error')->group(function () {

            Route::get('/403', function () {
                abort(403);
            });

            Route::get('/404', function () {
                abort(404);
            });

            Route::get('/405', function () {
                abort(405);
            });

            Route::get('/419', function () {
                throw new \Illuminate\Session\TokenMismatchException();
            });

            Route::get('/500', function () {
                abort(500);
            });

            Route::get('/503', function () {
                abort(503); // php artisan down  // php artisan up
            });
        });

    });


?>
