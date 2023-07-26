<?php

use App\Http\Controllers\SerieController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\VideoSerieController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/videos/{video:id}',[VideoController::class,'get']);
Route::get('/videos',[VideoController::class,'index']);
Route::get('/series',[SerieController::class,'index']);
Route::get('/series/{serie}/videos',[VideoSerieController::class,'index']);
