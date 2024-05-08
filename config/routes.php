<?php

use App\Controllers\AdminController;
use App\Controllers\CategoryController;
use App\Kernel\Router\Route;
use App\Controllers\HomeController;
use App\Controllers\LoginController;
use App\Controllers\RegisterController;
use App\Controllers\VideoController;
use App\Middleware\GuestMiddleware;
use App\Middleware\AuthMiddleware;

return [
    Route::get('/', [HomeController::class, 'index']),

    Route::get('/videos', [VideoController::class, 'index']),

    Route::get('/register', [RegisterController::class, 'index'], [GuestMiddleware::class]),

    Route::post('/register', [RegisterController::class, 'register']),

    Route::get('/login', [LoginController::class, 'index'], [GuestMiddleware::class]),

    Route::post('/login', [LoginController::class, 'login']),

    Route::post('/logout', [LoginController::class, 'logout']),

    Route::get('/admin', [AdminController::class, 'index']),

    Route::get('/admin/categories/add', [CategoryController::class, 'create']),

    Route::post('/admin/categories/add', [CategoryController::class, 'store']),

    Route::post('/admin/categories/destroy', [CategoryController::class, 'destroy']),

    Route::get('/admin/videos/add', [VideoController::class, 'add'], [AuthMiddleware::class]),

    Route::post('/admin/videos/add', [VideoController::class, 'store']),

    Route::get('/test', function () {
        echo 'Test';
    }),
];