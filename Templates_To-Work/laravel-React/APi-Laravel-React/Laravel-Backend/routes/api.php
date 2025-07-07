<?php
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// CSRF cookie (for Sanctum)
Route::get('/sanctum/csrf-cookie', [\Laravel\Sanctum\Http\Controllers\CsrfCookieController::class, 'show']);

// Public API auth:
Route::post('/register', [RegisteredUserController::class, 'store']);
Route::post('/login',    [AuthenticatedSessionController::class, 'store']);

// Protected:
Route::middleware('auth:sanctum')->group(function () {
  Route::post('/logout', [AuthenticatedSessionController::class, 'destroy']);
  Route::get('/user', fn(Request $req) => $req->user());
});
