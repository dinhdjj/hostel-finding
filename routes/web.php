<?php

declare(strict_types=1);

use App\Http\Controllers\HostelIndexController;
use App\Models\Hostel;
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

Route::get('', HostelIndexController::class)
    ->name('hostels.index')
;

// TODO: add a route for the hostel detail page
Route::get('hostels/{hostel}', fn (Hostel $hostel) => $hostel)
    ->name('hostels.show')
;

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function (): void {
    Route::get('/dashboard', fn () => view('dashboard'))->name('dashboard');
});
