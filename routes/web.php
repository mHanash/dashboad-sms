<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoutingController;
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
})->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/provinces', [RoutingController::class, 'provinces'])->name('province');
    Route::get('/villes', [RoutingController::class, 'cities'])->name('city');
    Route::get('/reseaux', [RoutingController::class, 'networks'])->name('network');
    Route::get('/telephones', [RoutingController::class, 'phones'])->name('phone');
    Route::get('/messages', [RoutingController::class, 'message'])->name('message');
    Route::get('/campagnes', [RoutingController::class, 'campaign'])->name('campaign');
    Route::get('/campagnes/listes/{campaign}', [RoutingController::class, 'campaign_list'])->name('campaign.list');
});

require __DIR__ . '/auth.php';
