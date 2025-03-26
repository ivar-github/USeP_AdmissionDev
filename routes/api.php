<?php

use Illuminate\Http\Request;
use App\Http\Controllers\ResultController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/admission/result/getColleges', [ResultController::class, 'getColleges']);
});


?>