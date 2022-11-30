<?php
use Illuminate\Support\Facades\Route;

Route::group(
    [
        'namespace' => 'Rras3k\Sebconsole\Http\Controllers',
        'middleware' => ['web', 'auth']
    ],
    function () {

        $prefix = '/console';

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
    }
);
