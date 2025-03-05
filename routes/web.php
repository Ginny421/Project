<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PawnController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\LineWebhookController;


Route::get('/', [HomeController::class, 'index']);

Route::get('/pawned-items/{id}', [PawnController::class, 'show']);

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');



Route::get('/', function () {
    if (Auth::check()) {
        $user = Auth::user();
        if (in_array($user->usertype, ['Staff', 'user'])) {
            return redirect('/dashboard');
        }
    }
    return view('welcome');
});

Route::middleware(['auth:sanctum', 
    config('jetstream.auth_session'),
    'verified'
    ])->group(function () {

        Route::get('/customers', [CustomerController::class, 'index'])->middleware('role:staff')->name('customers.index');
        Route::get('/customers/create', [CustomerController::class, 'create'])->middleware('role:staff')->name('customers.create');
        Route::post('/customers', [CustomerController::class, 'store'])->middleware('role:staff')->name('customers.store');
        Route::get('/customers/{customer}', [CustomerController::class, 'show'])->middleware('role:staff')->name('customers.show');
        Route::get('/customers/{customer}/edit', [CustomerController::class, 'edit'])->middleware('role:staff')->name('customers.edit');
        Route::put('/customers/{customer}', [CustomerController::class, 'update'])->middleware('role:staff')->name('customers.update');
        Route::delete('/customers/{customer}', [CustomerController::class, 'destroy'])->middleware('role:staff')->name('customers.destroy');
        
        Route::get('/pawns', [PawnController::class, 'index'])->middleware('role:staff')->name('pawns.index');
        Route::get('/pawns/create', [PawnController::class, 'create'])->middleware('role:staff')->name('pawns.create');
        Route::post('/pawns', [PawnController::class, 'store'])->middleware('role:staff')->name('pawns.store');
        Route::get('/pawns/{id}', [PawnController::class, 'show'])->middleware('role:staff')->name('pawns.show');
        Route::get('/pawns/{pawn}/receipt', [PawnController::class, 'receipt'])->middleware('role:staff')->name('pawns.receipt');
        Route::get('/pawned-item/{id}/receipt', [PawnController::class, 'receipt'])->middleware('role:staff');
        
        Route::post('/pawns/send-notification/{id}', [PawnController::class, 'sendNotification'])->middleware('role:staff')->name('pawns.sendNotification');
        
        Route::post('/line/webhook', [LineWebhookController::class, 'handleLineWebhook'])->middleware('role:staff');
        Route::post('/send-notification', [PawnController::class, 'sendNotification'])->middleware('role:staff')->name('sendNotification');
        
        
});

