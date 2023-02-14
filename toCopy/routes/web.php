<?php

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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(
    ['middleware' => 'auth'],
    function () {
        Route::redirect('/home', '/console');
        Route::get('console', [App\Http\Controllers\ConsoleController::class, 'show'])->name('console.show');
    }
);

//------------------------------- ROOT
Route::middleware(['auth', 'role:' . Role::ROOT])->group(function () {
});

//------------------------------- ADMIN
Route::middleware(['auth', 'role:' . Role::ADMIN])->group(function () {
});


//------------------------------- AFFILIE = member1
// Route::middleware(['auth', 'role:' . Role::MEMBRE_1])->group(function () {
//     // dump('affilie');
// });
