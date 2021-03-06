<?php

use App\Http\Controllers\AssignatureController;
use App\Http\Controllers\PageController;
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

Route::get('/', [PageController::class, 'index'])->name('welcome');

Route::middleware([
  'auth:sanctum',
  config('jetstream.auth_session'),
  'verified',
])->group(function () {
  Route::get('/dashboard', [PageController::class, 'dashboard'])->name('dashboard');

  Route::middleware('isAdmin')->group(function () {
    Route::resource('assignatures', AssignatureController::class)->except(['index', 'show', 'edit', 'update']);
  });

  Route::middleware('canEdit')->group(function () {
    Route::resource('assignatures', AssignatureController::class)->only(['edit', 'update']);
  });

  Route::resource('assignatures', AssignatureController::class)->only(['index', 'show']);
});
