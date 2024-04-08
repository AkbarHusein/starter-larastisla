<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
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

Route::get('login', function () {
    return view('auth.login');
});

Route::get('register', function () {
    return view('auth.register');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        $role = Auth::user()->role;

        if ($role == 'admin') {
            return redirect()->route('admin.dashboard.index');
        } else {
            return redirect()->route('user.dashboard.index');
        }
    })->name('dashboard');

});

Route::group(['middleware' => 'role:user', 'prefix' => 'user', 'as' => 'user.'], function () {
    Route::resource('dashboard', DashboardController::class)->middleware(['auth', 'verified']);

    Route::fallback(function () {
        return response()->view('404', [], 404);
    });
});

Route::group(['middleware' => 'role:admin', 'prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::resource('dashboard', DashboardController::class)->middleware(['auth', 'verified']);

    Route::fallback(function () {
        return response()->view('404', [], 404);
    });
});

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__ . '/auth.php';
