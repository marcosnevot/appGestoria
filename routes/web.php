<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WebMessageController;
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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
*/

Route::get('/', [HomeController::class, 'index'])->name('home');


Route::post('/contactForm', [WebMessageController::class, 'store'])
    ->name('form.store')
    ->middleware(['throttle:10,1']);

Route::get('/politica-privacidad', function () {
    return view('politica-privacidad');
})->name('politica-privacidad');

Route::get('/aviso-legal', function () {
    return view('aviso-legal');
})->name('aviso-legal');

Route::get('/politica-cookies', function () {
    return view('politica-cookies');
})->name('politica-cookies');


require __DIR__ . '/auth.php';
