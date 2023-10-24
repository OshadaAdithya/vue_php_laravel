<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemsController;


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

Route::get('/getItems',[ItemsController::class, 'getItems']);

Route::post('/addItem', [ItemsController::class, 'addItem']);

Route::delete('/deleteItem/{id}', [ItemsController::class, 'deleteItem']);

Route::put('/updateItem/{id}', [ItemsController::class, 'updateItem']);


