<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TagController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\ActivityController;

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

Route::get('/', WelcomeController::class);

Route::get('/contacts', [ContactController::class, 'index'])->name('contacts.index');
Route::get('/contacts/create', [ContactController::class, 'create'])->name('contacts.create');
Route::get('/contacts/{id}', [ContactController::class, 'show'])->name('contacts.show');
Route::resource('/companies', CompanyController::class);
Route::resources([
    '/tags' => TagController::class,
    '/tasks' => TaskController::class
]);
Route::resource('/activities', ActivityController::class)->except([
    'index', 'show'
]);
