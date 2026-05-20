<?php

use App\Http\Controllers\Api\AuthController as ApiAuthController;
use App\Http\Controllers\Api\CartController as ApiCartController;
use App\Http\Controllers\Api\CheckoutController as ApiCheckoutController;
use App\Http\Controllers\Api\OrderController as ApiOrderController;
use App\Http\Controllers\Api\ProductController as ApiProductController;
use Illuminate\Support\Facades\Route;

Route::prefix('api')->group(function () {
    Route::get('products', [ApiProductController::class, 'index']);
    Route::get('products/{product}', [ApiProductController::class, 'show']);

    Route::get('cart', [ApiCartController::class, 'index']);
    Route::post('cart/{product}/add', [ApiCartController::class, 'add']);
    Route::post('cart/{product}/update', [ApiCartController::class, 'update']);
    Route::post('cart/{product}/remove', [ApiCartController::class, 'remove']);

    Route::get('user', [ApiAuthController::class, 'user']);
    Route::post('login', [ApiAuthController::class, 'login']);
    Route::post('register', [ApiAuthController::class, 'register']);
    Route::post('logout', [ApiAuthController::class, 'logout']);

    Route::middleware('auth')->group(function () {
        Route::post('checkout', [ApiCheckoutController::class, 'process']);
        Route::get('orders', [ApiOrderController::class, 'index']);
        Route::get('orders/{order}', [ApiOrderController::class, 'show']);
    });
});

Route::view('/', 'app');
Route::view('/{any}', 'app')->where('any', '^(?!admin|api).*$');

// admin root redirects
Route::redirect('admin', '/admin/login');
Route::redirect('admin/', '/admin/login');

// admin routes
Route::prefix('admin')->group(function () {
    Route::get('/', function () {
        if (auth()->check() && auth()->user()->is_admin) {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('admin.login');
    });

    Route::get('login', [\App\Http\Controllers\Admin\AuthController::class, 'showLogin'])->name('admin.login');
    Route::post('login', [\App\Http\Controllers\Admin\AuthController::class, 'login'])->name('admin.login.submit');
    Route::post('logout', [\App\Http\Controllers\Admin\AuthController::class, 'logout'])->name('admin.logout');

    Route::middleware([\App\Http\Middleware\IsAdmin::class])->group(function () {
        Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class, [
            'as' => 'admin'
        ]);
        Route::post('categories/{category}/move-up', [\App\Http\Controllers\Admin\CategoryController::class, 'moveUp'])->name('admin.categories.moveUp');
        Route::post('categories/{category}/move-down', [\App\Http\Controllers\Admin\CategoryController::class, 'moveDown'])->name('admin.categories.moveDown');
        Route::get('dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');
        Route::resource('products', \App\Http\Controllers\Admin\ProductController::class, [
            'as' => 'admin'
        ]);
    });
});
