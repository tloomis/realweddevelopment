<?php

use App\Http\Controllers\Api\NotificationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Notification routes - using web auth since we're using session-based auth
Route::middleware('auth:web')->prefix('notifications')->group(function () {
    Route::get('/check', [NotificationController::class, 'check']);
    Route::get('/unread-count', [NotificationController::class, 'unreadCount']);
});
