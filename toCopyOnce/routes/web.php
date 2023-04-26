<?php

use Illuminate\Support\Facades\Route;
use App\Models\Role;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();


Route::group(
    [
        'namespace' => 'Rras3k\Sebconsole\Http\Controllers',
        'middleware' => ['web', 'auth', 'role:' . Role::ADMIN]
    ],
    function () {
        // Pages Pasgit
        // Route::get('rras3k/pages-dev', [Rras3k\Sebconsole\Http\Controllers\PageDevController::class, 'index'])->name('page-dev.index');
        // Route::get('rras3k/pages-dev/page/{nompage}', [Rras3k\Sebconsole\Http\Controllers\PageDevController::class, 'getPage']);
    }
);

Route::group(
    [
        'namespace' => 'Rras3k\Sebconsole\Http\Controllers',
        'middleware' => ['web', 'auth', 'role:' . Role::ROOT]
    ],
    function () {
        // Route::get('rras3k/genere-mvc', [\Rras3k\Sebconsole\Http\Controllers\genereMvcController::class, 'show'])->name('genereMvc.show');
        // Route::get('rras3k/genere-check', [\Rras3k\Sebconsole\Http\Controllers\genereMvcController::class, 'check'])->name('genereMvc.check');
        // Route::post('rras3k/genere-run', [\Rras3k\Sebconsole\Http\Controllers\genereMvcController::class, 'run'])->name('genereMvc.run');
        // Route::get('rras3k/system', [\Rras3k\Sebconsole\Http\Controllers\SystemController::class, 'show'])->name('rras3k.system.show');
    }
);

