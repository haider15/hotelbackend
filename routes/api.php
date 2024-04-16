<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\ReservationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::resource('products', ProductController::class);

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{id}', [ProductController::class, 'show']);
Route::get('/products/search/{name}', [ProductController::class, 'search']);

// Routes pour les activités
Route::get('/activities', [ActivityController::class, 'index']);
Route::get('/activities/{id}', [ActivityController::class, 'show']);
Route::get('/activities/search/{name}', [ActivityController::class, 'search']);
Route::delete('/products/{id}', [ProductController::class, 'destroy']);
Route::put('/products/{id}', [ProductController::class, 'update']);
Route::post('/products', [ProductController::class, 'store']);
Route::post('/activities', [ActivityController::class, 'store']);
 Route::put('/activities/{id}', [ActivityController::class, 'update']);
 Route::delete('/activities/{id}', [ActivityController::class, 'destroy']);
 
// Protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {
   
    
    Route::post('/logout', [AuthController::class, 'logout']);
 // Routes pour les activités
 

  // Routes pour les réservations
  Route::get('/reservations', [ReservationController::class, 'index']);
  Route::post('/reservations', [ReservationController::class, 'store']);
  Route::get('/reservations/{id}', [ReservationController::class, 'show']);
  Route::put('/reservations/{id}', [ReservationController::class, 'update']);
  Route::delete('/reservations/{id}', [ReservationController::class, 'destroy']);
});



Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
