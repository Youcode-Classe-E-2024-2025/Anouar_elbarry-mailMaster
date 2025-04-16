<?php

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\MailController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::prefix('auth')->group(function(){
    Route::post('/register',[UserController::class,'register']);
    Route::post('/login',[UserController::class,'login']);
});
Route::prefix('newsletter')->group(function () {
    Route::post('/subscribe', [NewsletterController::class, 'subscribe']);
    Route::post('/unsubscribe', [NewsletterController::class, 'unsubscribe']);
    Route::post('/campaign', [NewsletterController::class, 'sendCampaign']);
});
Route::prefix('campaigns')->group(function () {
    Route::post('/', [CampaignController::class, 'create']);
    Route::post('/{id}/send', [CampaignController::class, 'send']);
    Route::get('/', [CampaignController::class, 'index']);
});
Route::prefix('mail')->group(function () {
    Route::post('/test', [MailController::class, 'sendTest']);
    Route::get('/track/{mailId}', [MailController::class, 'trackOpen']);
});