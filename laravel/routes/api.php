<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\NotificationController;

Route::get('check',function(){
    dd('called');
});

Route::prefix('notification')->group(function(){
  Route::controller(NotificationController::class)->group(function(){
    Route::post('/','store');
    Route::put('/{id}','markNotificationAsProcessed');
    Route::get('/recent','recentNotification');
    Route::get('/summary','notificationSummary');

  });
});