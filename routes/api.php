<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DemoTestController;
use App\Http\Controllers\Api\RecordTestController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('demo/test', [DemoTestController::class, 'create']);
Route::get('demo/activate/{ref}', [RecordTestController::class, 'activate']);
Route::get('demo/deactivate/{ref}', [RecordTestController::class, 'deactivate']);

