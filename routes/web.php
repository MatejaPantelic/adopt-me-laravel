<?php

use App\Http\Controllers\AnimalController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransferController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard', ['animals' => ["dog", "cat", "lizard"]]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('animal', AnimalController::class);
Route::get('/adopt/{animal}/{user_id}',[AnimalController::class,'adopt'])->name('animal.adopt');
Route::post('/filter',[AnimalController::class,'filter'])->name('animal.filter');
Route::get('/search',[AnimalController::class,'search'])->name('animal.search');
Route::resource('category',CategoryController::class);
Route::resource('transfer',TransferController::class);
Route::resource('user',UserController::class);
Route::post('/accept/{transfer_id}/{adopter_id}/{animal_id}',[TransferController::class,'accept'])->name('transfer.accept');
Route::post('/deny/{transfer_id}/{adopter_id}/{animal_id}',[TransferController::class,'deny'])->name('transfer.deny');
Route::delete('/destroy/{transfer_id}/{animal_id}',[TransferController::class,'destroy'])->name('transfer.destroy');

Route::post('/assignAdmin/{user_id}/',[UserController::class,'assignAdminRole'])->name('user.assignAdmin');
Route::post('/assignGuest/{user_id}/',[UserController::class,'assignGuestRole'])->name('user.assignGuest');

require __DIR__.'/auth.php';
