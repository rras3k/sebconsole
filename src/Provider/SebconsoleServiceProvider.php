<?php
//
namespace Rras3k\Sebconsole\Provider;

use Rras3k\Sebconsole\Lib\RoleUser;
use Rras3k\Sebconsole\Lib\MenuMaker;
use Rras3k\Sebconsole\Models\Role;
use Illuminate\Support\Facades\Auth;
use Rras3k\SebconsoleRoot\commands\Console;
use Rras3k\SebconsoleRoot\commands\Menu;
use Rras3k\SebconsoleRoot\commands\Choix;


use Illuminate\Support\ServiceProvider;


class SebconsoleServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('RoleUser', function ($app) {
            return new RoleUser();
        });
        $this->app->bind('Role', function ($app) {
            dd("ooo1");
            return new Role();
        });
        $this->app->bind('MenuMaker', function ($app) {
            return new MenuMaker();
        });

    }
    public function boot()
    {
        // Migration
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');

        // Routes
        $this->loadRoutesFrom(__DIR__ . '/../../routes/web.php');

        // Views
        $this->loadViewsFrom(__DIR__ . '/../../ressources/views', 'sebconsoleviews');

        // config
        $this->mergeConfigFrom(
            __DIR__ . '/../../config/sebconsole.php',
            'sebconsole'
        );
        $this->importPublishOnce();

        // Console
        if ($this->app->runningInConsole()) {
            // publish config file

            $this->commands([
                Menu::class, // registering the new command
            ]);
        }

    }


    private function importPublishOnce()
    // php artisan db:seed --class=RoleSeeder


    {
        // dd("oo");
        // Asset
        $this->publishes([
            __DIR__ . '/../../public/js' => public_path('js'),
        ]);

        // console.css
        $this->publishes([
            __DIR__ . '/../../ressources/sass/sebconsole.scss' => resource_path('/sass/sebconsole.scss'),
            __DIR__ . '/../../ressources/sass/_variables.scss' => resource_path('/sass/_variables.example.scss'),
        ], 'files_sass');

        $this->publishes([
            __DIR__ . '/../../config/sebconsole.php' => config_path('sebconsole.php'),
            // __DIR__ . '/views' => resource_path('views/rras3k/console'),
            // __DIR__ . '/database/migrations/' => database_path('migrations')
        ]);

        $this->publishes([
            __DIR__ . '/../../database/seeders/RoleSeeder.php' => database_path('seeders/RoleSeeder.php'),
        ]);
    }
}

// Views
// $this->loadViewsFrom(__DIR__ . '/views', 'console');

/*
<?php

namespace Rras3k\Console;


use Rras3k\Console\app\Lib\MenuMaker;
use Rras3k\Console\app\Models\RoleUser;

use Rras3k\Console\App\commands\Console;
use Rras3k\Console\App\commands\Menu;
use Rras3k\Console\App\commands\choix;



use Illuminate\Support\ServiceProvider;

class ConsoleServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('MenuMaker', function ($app) {
            return new MenuMaker();
        });
        $this->app->bind('RoleUser', function ($app) {
            return new RoleUser();
        });
    }
    public function boot()
    {

        // Routes
        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');

        // Views
        $this->loadViewsFrom(__DIR__ . '/views', 'console');

        // Migration
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');

        // config
        $this->mergeConfigFrom(
            __DIR__ . '/config/console.php',
            'console'
        );


        $this->importPublish();



        // Console
        if ($this->app->runningInConsole()) {
            // publish config file

            $this->commands([
                Console::class, // registering the new command
                Menu::class, // registering the new command
                Choix::class, // registering the new command
            ]);
        }
    }

    private function importPublish(){

        // Asset
        $this->publishes([
            __DIR__ . '/public/js' => public_path('js'),
        ]);

        // console.css
        $this->publishes([
            __DIR__ . '/sass/console.scss' => resource_path('/sass/console.scss'),
            __DIR__ . '/sass/_variables.scss' => resource_path('/sass/_variables.example.scss'),
        ], 'files_sass');

        $this->publishes([
            __DIR__ . '/config/console.php' => config_path('console.php'),
            // __DIR__ . '/views' => resource_path('views/rras3k/console'),
            // __DIR__ . '/database/migrations/' => database_path('migrations')
        ]);

        $this->publishes([
            __DIR__ . '/database/seeders/RoleSeeder.php' => database_path('seeders/RoleSeeder.php'),
        ]);
    }

}

*/