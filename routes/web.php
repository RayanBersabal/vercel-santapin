<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\AboutController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\OrderController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
| These routes are for public access, like your welcome page.
*/

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Authenticated User Routes (non-admin)
|--------------------------------------------------------------------------
| These routes are for regular users after they log in.
*/

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        // This is the default dashboard for non-admin users
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


/*
|--------------------------------------------------------------------------
| Admin Routes (protected)
|--------------------------------------------------------------------------
| This route group is protected by the 'auth' and 'is.admin' middleware.
| Only logged-in administrators can access these pages.
*/

Route::middleware(['auth', 'is.admin'])->prefix('admin')->name('admin.')->group(function () {
    // Admin Dashboard Route
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // Admin Menu CRUD routes using a resource controller
    Route::resource('menu', MenuController::class);
    // Admin Order Management routes
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
    // Admin About Page Settings routes
    Route::get('/about', [AboutController::class, 'index'])->name('about.index');
    Route::patch('/about', [AboutController::class, 'update'])->name('about.update');
    // Other admin routes
    Route::get('/users', [UserController::class, 'index'])->name('users.index'); // Correct location
    // Add other admin routes here (e.g., feedback, orders)
    Route::get('/feedback', function () {
        return view('admin.feedback');
    })->name('feedback');

});
Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::resource('menu', MenuController::class);

require __DIR__ . '/auth.php';
