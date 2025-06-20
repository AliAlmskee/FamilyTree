<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\FamilyTreeWebController;
use App\Http\Controllers\Web\FamilySearchWebController;
use App\Http\Controllers\Web\FamilyTreeImportWebController;
use App\Http\Controllers\Web\NewsController;

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

// Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/', function () {
    return view('landing');
});

// News Section
Route::resource('news', NewsController::class);

// Family Tree Management
Route::prefix('family-tree')->group(function () {
    Route::get('/', [FamilyTreeWebController::class, 'index'])->name('family-tree.index');
    Route::get('/{id}', [FamilyTreeWebController::class, 'show'])->name('family-tree.show');
    Route::get('/{id}/ancestry', [FamilyTreeWebController::class, 'ancestry'])->name('family-tree.ancestry');
    Route::get('/{id}/descendants', [FamilyTreeWebController::class, 'descendants'])->name('family-tree.descendants');
});

// Search Routes
Route::prefix('search')->group(function () {
    Route::get('/', [FamilySearchWebController::class, 'index'])->name('search.index');
    Route::get('/name', [FamilySearchWebController::class, 'searchByName'])->name('search.by-name');
    Route::get('/father-child', [FamilySearchWebController::class, 'searchByFatherAndChild'])->name('search.by-father-child');
});
