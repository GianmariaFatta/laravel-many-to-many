<?php

use App\Http\Controllers\Guest\HomeController as GuestHomeController; 
use App\Http\Controllers\Admin\HomeController as  AdminHomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\admin\ProjectController;
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

// ROTTE OSPITI
Route::get('/',[GuestHomeController::class, 'index']);


// ROTTE PROTETTE
Route::middleware(['auth', 'verified'])->name('admin.')->prefix('admin')->group(function () {
    // ROTTE UTENTE LOGGATO
    Route::get('/', [AdminHomeController::class, 'index'])->name('home');

    // ROTTE POST
     Route::resource('projects', ProjectController::class);

});



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
