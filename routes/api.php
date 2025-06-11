<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FamilyTreeController;
use App\Http\Controllers\FamilyTreeImportController;
use App\Http\Controllers\FamilySearchController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});




Route::prefix('search')->group(function () {
    Route::get('/name', [FamilySearchController::class, 'searchByName']);
    Route::get('/father-child', [FamilySearchController::class, 'searchByFatherAndChild']);
    Route::get('/ancestry', [FamilySearchController::class, 'getAncestry']);
});

Route::post('/family-tree/import-excel', [FamilyTreeImportController::class, 'import']);
Route::get('/family-tree/{id}', [FamilyTreeController::class, 'getFamilyMember']);
