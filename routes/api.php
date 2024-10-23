<?php

use App\Http\Controllers\JobController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::name('jobs.')->prefix('jobs')->group(function () {
    Route::get('/', [JobController::class, 'index'])->name('index');
    Route::post('/', [JobController::class, 'store'])->name('store');
    Route::get('/{id}', [JobController::class, 'show'])->name('show');
    Route::delete('/{id}', [JobController::class, 'destroy'])->name('delete');
});
//Route::get('/jobs', function (Request $request) {
//    return $request->user();
//});

//    ->middleware('auth:sanctum');
