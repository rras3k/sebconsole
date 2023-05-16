<?php

use Illuminate\Support\Facades\Route;
use Rras3k\Sebconsole\Models\Role;

// use App\Models\Role;


Route::group(
    [
        'namespace' => 'Rras3k\Sebconsole\Http\Controllers',
        'middleware' => ['web', 'auth', 'role:' . Role::ADMIN]
    ],
    function () {
        // Pages dev
        Route::get('rras3k/pages-dev', [Rras3k\Sebconsole\Http\Controllers\PageDevController::class, 'index'])->name('page-dev.index');
        Route::get('rras3k/pages-dev/page/{nompage}', [Rras3k\Sebconsole\Http\Controllers\PageDevController::class, 'getPage']);
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

        // Route::get('rras3k/dashboard', [\Rras3k\Sebconsole\Http\Controllers\DashboardController::class, 'show'])->name('rras3k.dashboard.show');
        Route::get('rras3k/system', [\Rras3k\Sebconsole\Http\Controllers\SystemController::class, 'show'])->name('rras3k.system.show');
        Route::get('rras3k/del-menus', [\Rras3k\Sebconsole\Http\Controllers\SystemController::class, 'delMenus'])->name('rras3k.del-menus');
        Route::get('rras3k/log_type_genere', [\Rras3k\Sebconsole\Http\Controllers\SystemController::class, 'logTypeGenere'])->name('rras3k.log_type_genere');
        // Route::post('rras3k/gen-models', [\Rras3k\Sebconsole\Http\Controllers\DashboardController::class, 'genModels'])->name('rras3k.gen-models');


        // LogHead
        Route::get('rras3k/log_heads/listeBt', [\Rras3k\Sebconsole\Http\Controllers\LogHeadController::class, 'listeBt'])->name('rras3k.LogHead.listeBt');
        Route::get('rras3k/log_heads/{id}', [\Rras3k\Sebconsole\Http\Controllers\LogHeadController::class, 'show'])->name('rras3k.LogHead.show');
        Route::get('rras3k/log_heads', [\Rras3k\Sebconsole\Http\Controllers\LogHeadController::class, 'index'])->name('rras3k.LogHead.index');

        // LogDetail
        Route::get('rras3k/log_details', [\Rras3k\Sebconsole\Http\Controllers\LogDetailController::class, 'index'])->name('rras3k.LogDetail.index');
        Route::get('rras3k/log_details/listeBt', [\Rras3k\Sebconsole\Http\Controllers\LogDetailController::class, 'listeBt'])->name('rras3k.LogDetail.listeBt');
        Route::get('rras3k/log_details/{id}', [\Rras3k\Sebconsole\Http\Controllers\LogDetailController::class, 'show'])->name('rras3k.LogDetail.show');

    }
);


