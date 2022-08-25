<?php

declare(strict_types=1);

use App\Http\Controllers\HostelController;
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

Route::get('/', fn () => view('welcome'));
Route::get('/hostels/{hostel}', [HostelController::class, 'show'])->name('hostels.show');
Route::get('/hosting', [HostelController::class, 'hosting'])->name('hostels.create')->middleware('auth');
Route::get('/manage', [HostelController::class, 'manage'])->name('hostels.manage')->middleware('auth');
Route::get('/edit/{hostel}', [HostelController::class, 'edit'])->name('hostels.edit')->middleware('auth');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function (): void {
    Route::get('/dashboard', fn () => view('dashboard'))->name('dashboard');
});
