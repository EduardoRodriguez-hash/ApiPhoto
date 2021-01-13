<?php

use App\Http\Controllers\FotoController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/buy/paypal/{user_id}/{personId}', [FotoController::class, 'Buy'])->name('PaypalView');
Route::post('/buy/paypal/pago', [PaymentController::class, 'PayWithPaypal'])->name('PaypalPago');
Route::get('/buy/correct', [PaymentController::class, 'BuyCorrect'])->name('buy.correct');
Route::get('/buy/error', [PaymentController::class, 'BuyError'])->name('buy.error');
Route::get('/buy/verfy/{user_id}/{foto_id}/{pago}', [PaymentController::class, 'BuyVerify'])->name('buy.verify');
