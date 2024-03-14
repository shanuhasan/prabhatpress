<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;

Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
                ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
                ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
                ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
                ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
                ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
                ->name('password.store');
});

Route::middleware('auth')->group(function () {
    Route::get('verify-email', EmailVerificationPromptController::class)
                ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
                ->middleware(['signed', 'throttle:6,1'])
                ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
                ->middleware('throttle:6,1')
                ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
                ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
                ->name('logout');


    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/pending', [OrderController::class, 'pending'])->name('orders.pending');
    Route::get('/orders/complete', [OrderController::class, 'complete'])->name('orders.complete');
    Route::get('/orders/delivered', [OrderController::class, 'delivered'])->name('orders.delivered');
    Route::get('/orders/pending-amount-order', [OrderController::class, 'pendingAmountOrder'])->name('orders.pendingAmountOrder');
    Route::get('/order/create',[OrderController::class,'create'])->name('orders.create');
    Route::post('/order/store',[OrderController::class,'store'])->name('orders.store');
    Route::get('/order/{id}/edit',[OrderController::class,'edit'])->name('orders.edit');
    Route::post('/order/{id}',[OrderController::class,'update'])->name('orders.update');
    Route::delete('/order/{id}',[OrderController::class,'delete'])->name('orders.delete');
    Route::delete('/order/item/{id}',[OrderController::class,'deleteItem'])->name('orders.item.delete');
    Route::get('/print/{id}', [OrderController::class, 'print'])->name('orders.print');

    // users 
    Route::get('/user',[UserController::class,'index'])->name('user.index');
    Route::get('/user/create',[UserController::class,'create'])->name('user.create');
    Route::post('/user/store',[UserController::class,'store'])->name('user.store');
    Route::get('/user/{id}/edit',[UserController::class,'edit'])->name('user.edit');
    Route::post('/user/{id}',[UserController::class,'update'])->name('user.update');
    Route::get('/user/{id}',[UserController::class,'destroy'])->name('user.delete');


    // customers 
    Route::get('/customer',[CustomerController::class,'index'])->name('customer.index');
    Route::get('/customer/create',[CustomerController::class,'create'])->name('customer.create');
    Route::post('/customer/store',[CustomerController::class,'store'])->name('customer.store');
    Route::get('/customer/{id}/edit',[CustomerController::class,'edit'])->name('customer.edit');
    Route::post('/customer/{id}',[CustomerController::class,'update'])->name('customer.update');
    Route::get('/customer/{id}',[CustomerController::class,'destroy'])->name('customer.delete');

    //customer orders
    Route::get('/customer/orders/{id}',[CustomerController::class,'orders'])->name('customer.order');
    Route::get('/customer/order/{id}/create',[CustomerController::class,'orderCreate'])->name('customer.orders.create');
    Route::post('/customer/order/store',[CustomerController::class,'orderStore'])->name('customer.orders.store');
    Route::get('/customer/order/{customerId}/{orderId}/edit',[CustomerController::class,'orderEdit'])->name('customer.orders.edit');
    Route::post('/customer/order/{id}',[CustomerController::class,'orderUpdate'])->name('customer.orders.update');
    Route::delete('/delete-customer-order/{id}',[CustomerController::class,'orderDelete'])->name('customer.orders.delete');
    Route::delete('/delete-customer-order-item/{id}',[CustomerController::class,'orderItemDelete'])->name('customer.orders.item.delete');
    Route::post('/customer-order-payment',[CustomerController::class,'orderPayment'])->name('customer.orders.payment');

    // expenses 
    Route::get('/expenses',[ExpenseController::class,'index'])->name('expenses.index');
    Route::get('/expenses/create',[ExpenseController::class,'create'])->name('expenses.create');
    Route::post('/expenses/store',[ExpenseController::class,'store'])->name('expenses.store');
    Route::get('/expenses/{id}/edit',[ExpenseController::class,'edit'])->name('expenses.edit');
    Route::post('/expenses/{id}',[ExpenseController::class,'update'])->name('expenses.update');
    Route::delete('/expenses/{id}',[ExpenseController::class,'delete'])->name('expenses.delete');

    // report 
    Route::get('/report',[ReportController::class,'index'])->name('report.index');
    Route::get('/report/online-payment',[ReportController::class,'onlinePayment'])->name('report.onlinePayment');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'updateProfile'])->name('profile.update');

    Route::get('/change-password', [ProfileController::class, 'changePassword'])->name('profile.changePassword');
    Route::post('/change-password', [ProfileController::class, 'changePasswordProcess'])->name('profile.changePasswordProcess');
    // Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
