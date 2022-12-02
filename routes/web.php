<?php

use Illuminate\Support\Facades\Route;
use Rras3k\Sebconsole\Models\Role;

Route::group(
    [
        'namespace' => 'Rras3k\Sebconsole\Http\Controllers',
        'middleware' => ['web','auth', 'role:'.Role::ADMIN]
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

                // Users
                Route::get($prefix . '/user-listeBt', [Rras3k\Sebconsole\Http\Controllers\UserController::class, 'listeBt'])->name('user.listeBt');


                Route::resource($prefix . "/user", Rras3k\Sebconsole\Http\Controllers\UserController::class);

                // LogHeads
                Route::get($prefix . '/logHead-listeBt', [Rras3k\Sebconsole\Http\Controllers\LogHeadController::class, 'listeBt'])->name('logHead.listeBt');
                Route::get($prefix . '/logHead', [Rras3k\Sebconsole\Http\Controllers\LogHeadController::class, 'index'])->name('logHead.index');

                // LogDetails
                Route::get($prefix . '/logDetail-listeBt', [Rras3k\Sebconsole\Http\Controllers\LogDetailController::class, 'listeBt'])->name('logDetail.listeBt');
                Route::get($prefix . '/logDetail', [Rras3k\Sebconsole\Http\Controllers\LogDetailController::class, 'index'])->name('logDetail.index');

                // Génération
                Route::get($prefix . '/generation', [Rras3k\Sebconsole\Http\Controllers\GenerationController::class, 'index'])->name('generation.index');
        //     }
        // );
    }
);
