<?php

use Illuminate\Support\Facades\Route;
use Rras3k\Sebconsole\Models\Role;

Route::group(
    [
        'namespace' => 'Rras3k\Sebconsole\Http\Controllers',
        'middleware' => ['web', 'auth', 'role:' . Role::ADMIN]
    ],
    function () {

        // Route::middleware(['auth', 'role:1'])->group(
        //     function () {
        $prefix = '/console';

        // Pages Pasgit
        Route::get($prefix . '/pages-pasgit', [Rras3k\Sebconsole\Http\Controllers\PagePasgitController::class, 'index'])->name('page-pasgit.index');
        Route::get($prefix . '/pages-pasgit/page/{nompage}', [Rras3k\Sebconsole\Http\Controllers\PagePasgitController::class, 'getPage']);


        // Console
        Route::get($prefix, [Rras3k\Sebconsole\Http\Controllers\ConsoleController::class, 'show'])->name('console.show');


    }
);

Route::group(
    [
        'namespace' => 'Rras3k\Sebconsole\Http\Controllers',
        'middleware' => ['web', 'auth', 'role:' . Role::ROOT]
    ],
    function () {
        Route::get('rras3k/genere-mvc', [\Rras3k\Sebconsole\Http\Controllers\genereMvcController::class, 'show'])->name('genereMvc.show');
        Route::get('rras3k/genere-check', [\Rras3k\Sebconsole\Http\Controllers\genereMvcController::class, 'check'])->name('genereMvc.check');
        Route::post('rras3k/genere-run', [\Rras3k\Sebconsole\Http\Controllers\genereMvcController::class, 'run'])->name('genereMvc.run');
    }
);
