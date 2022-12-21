<?php
//
namespace Rras3k\Sebconsole\Provider;

use Rras3k\Sebconsole\Lib\RoleUser;
use Rras3k\Sebconsole\Lib\MenuMaker;
use Rras3k\Sebconsole\Lib\Viewdata;
use Rras3k\Sebconsole\Models\Role;
use Rras3k\Sebconsole\Models\LogDetail;
use Rras3k\SebconsoleRoot\commands\Menu;
use Rras3k\Sebconsole\Http\Middleware\EnsureUserHasRole;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Blade;





use Illuminate\Support\ServiceProvider;


class SebconsoleServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('RoleUser', function ($app) {
            return new RoleUser();
        });
        $this->app->bind('Role', function ($app) {
            // dd("ooo1");
            return new Role();
        });
        $this->app->bind('Log', function ($app) {
            return new LogDetail();
        });
        $this->app->bind('MenuMaker', function ($app) {
            return new MenuMaker();
        });
        $this->app->bind('ViewData', function ($app) {
            return new ViewData();
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
        // Middleware
        // $kernel->pushMiddleware(EnsureUserHasRole::class);

        // $router = $this->app->make(Router::class);
        // $router->pushMiddlewareToGroup('web', EnsureUserHasRole::class);        

        $this->app->booted(function () {
            $router = $this->app->make(Router::class);
            $router->aliasMiddleware('role', EnsureUserHasRole::class);
            $router->pushMiddleWareToGroup('role', EnsureUserHasRole::class);
        });

        $this->importPublishOnce();

        // Console
        if ($this->app->runningInConsole()) {
            // publish config file

            $this->commands([
                Menu::class, // registering the new command
            ]);
        }
        // composants view
        // $this->loadViewsFrom(__DIR__ . '/../../resources/views/components', 'forms.input');

        $this->loadBladeDirectives();
         
        
    }

    private function loadBladeDirectives()
    {
        Blade::directive('isCreate', function () {
            return '<?php if (isset($data["isCreate"]) && $data["isCreate"]) { ?>';
        });
        Blade::directive('elseis', function () {
            return "<?php }else{ ?>";
        });
        Blade::directive('endisCreate', function () {
            return "<?php } ?>";
        });
        
    }
    
    private function importPublishOnce()
    /*
    php artisan db:seed --class=RoleSeeder
    php artisan vendor:publish
    php artisan vendor:publish --force --tag=rras3k-force
    php artisan vendor:publish --force --tag=rras3k-config
    
    */
    {
        // dd("oo");
        // Asset
        $this->publishes([
            __DIR__ . '/../../public/js' => public_path('js'),
            __DIR__ . '/../../ressources/sass/_rras3k/console.scss' => resource_path('/sass/_rras3k/console.scss'),
            __DIR__ . '/../../ressources/sass/_rras3k/def.scss' => resource_path('/sass/_rras3k/def.scss'),
            __DIR__ . '/../../ressources/sass/_rras3k/panel.scss' => resource_path('/sass/_rras3k/panel.scss'),
            __DIR__ . '/../../ressources/sass/_rras3k/sidebar.scss' => resource_path('/sass/_rras3k/sidebar.scss'),
            __DIR__ . '/../../ressources/views/pasgit' => resource_path('views/page-dev'),
            __DIR__ . '/../../database/seeders/RoleSeeder.php' => database_path('seeders/RoleSeeder.php'),
            __DIR__ . '/../../ressources/sass/_variables.scss' => resource_path('/sass/_variables.example.scss'),
        ], 'rras3k-force');



        $this->publishes([
            __DIR__ . '/../../config/sebconsole.php' => config_path('sebconsole.php'),
            __DIR__ . '/../../ressources/views/footer.blade.php' => resource_path('views/footer.blade.php'),
            __DIR__ . '/../../ressources/sass/ajout.scss' => resource_path('/sass/ajout.scss'),
        ], 'rras3k-config');

        // $this->publishes([
        //     // __DIR__ . '/../../database/migrations/' => database_path('migrations')
        // ], 'rras3k-install');

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
