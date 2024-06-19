<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\AuthController;


Route::post('register',[AuthController::class,'register']);
Route::post('login',[AuthController::class,'login']);

Route::apiResource('invoice',InvoiceController::class, ['except' => ['create', 'edit']])
   ->middleware('auth:sanctum'); 


Route::fallback(function(){
    return response()->json([
      'message' => 'Page Not Found.'], 404);
    });
  

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
