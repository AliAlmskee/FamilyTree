<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\FamilyTreeWebController;
use App\Http\Controllers\Web\FamilySearchWebController;
use App\Http\Controllers\Web\FamilyTreeImportWebController;
use App\Http\Controllers\Web\NewsController;
use App\Http\Controllers\Web\AdminController;
use App\Http\Controllers\Web\AuthWebController;

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

Route::get('/api/family-stats', [DashboardController::class, 'getFamilyStats'])->name('api.family-stats');

// Authentication Routes
Route::get('/login', [AuthWebController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthWebController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthWebController::class, 'logout'])->name('logout');

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

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
   
    // News Management
    Route::get('/news', [AdminController::class, 'newsIndex'])->name('news.index');
    Route::patch('/news/{id}/approve', [AdminController::class, 'approveNews'])->name('news.approve');
    Route::delete('/news/{id}/reject', [AdminController::class, 'rejectNews'])->name('news.reject');
    Route::delete('/news/{id}', [AdminController::class, 'deleteNews'])->name('news.delete');
    
    // Family Member Management
    Route::get('/members', [AdminController::class, 'membersIndex'])->name('members.index');
    Route::get('/members/create', [AdminController::class, 'memberCreate'])->name('members.create');
    Route::post('/members', [AdminController::class, 'memberStore'])->name('members.store');
    Route::get('/members/{id}/edit', [AdminController::class, 'memberEdit'])->name('members.edit');
    Route::put('/members/{id}', [AdminController::class, 'memberUpdate'])->name('members.update');
    Route::delete('/members/{id}', [AdminController::class, 'memberDelete'])->name('members.delete');
    
    // User Management
    Route::get('/users', [AdminController::class, 'usersIndex'])->name('users.index');
    Route::get('/users/create', [AdminController::class, 'userCreate'])->name('users.create');
    Route::post('/users', [AdminController::class, 'userStore'])->name('users.store');
    Route::get('/users/{id}/edit', [AdminController::class, 'userEdit'])->name('users.edit');
    Route::put('/users/{id}', [AdminController::class, 'userUpdate'])->name('users.update');
    Route::delete('/users/{id}', [AdminController::class, 'userDelete'])->name('users.delete');
});
