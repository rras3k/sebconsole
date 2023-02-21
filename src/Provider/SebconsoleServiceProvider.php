<?php
//
namespace Rras3k\Sebconsole\Provider;

use Rras3k\Sebconsole\Lib\RoleUser;
use Rras3k\Sebconsole\Lib\MenuMaker;
use Rras3k\Sebconsole\Lib\RapportSimple;
use Rras3k\Sebconsole\Lib\ViewData;
use Rras3k\Sebconsole\Models\Role;
use Rras3k\Sebconsole\Models\LogDetail;
use Rras3k\SebconsoleRoot\commands\Menu;
use Rras3k\SebconsoleRoot\commands\GeneratorMvcCommands;
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
            return new Role();
        });
        $this->app->bind('Log', function ($app) {
            return new LogDetail();
        });
        $this->app->bind('MenuMaker', function ($app) {
            return new MenuMaker();
        });
        $this->app->bind('RapportSimple', function ($app) {
            return new RapportSimple();
        });
        $this->app->bind('ViewData', function ($app) {
            return new ViewData();
        });
    }
    public function boot()
    {

        $this->importPublishOnce();
        
        // Migration
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
        
        // config
        $this->mergeConfigFrom(
            __DIR__ . '/../../config/sebconsole.php',
            'sebconsole'
        );
        
        // Views
        $this->loadViewsFrom(__DIR__ . '/../../ressources/views', 'sebconsoleviews');
        
        
        // Routes
        $this->loadRoutesFrom(__DIR__ . '/../../routes/web.php');
        
        // Middleware
        // $kernel->pushMiddleware(EnsureUserHasRole::class);
        
        // $router = $this->app->make(Router::class);
        // $router->pushMiddlewareToGroup('web', EnsureUserHasRole::class);
        
        $this->app->booted(function () {
            $router = $this->app->make(Router::class);
            $router->aliasMiddleware('role', EnsureUserHasRole::class);
            $router->pushMiddleWareToGroup('role', EnsureUserHasRole::class);
        });
        
        $this->loadBladeDirectives();

        // Console
        if ($this->app->runningInConsole()) {
            // publish config file

            $this->commands([
                Menu::class, // registering the new command
                GeneratorMvcCommands::class, // registering the new command
            ]);
        }
        // composants view
        // $this->loadViewsFrom(__DIR__ . '/../../resources/views/components', 'forms.input');



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
    php artisan db:seed --class=FirstSeeder
    php artisan vendor:publish --tag=rras3k-once
    php artisan vendor:publish --force --tag=rras3k-maj 
    */
    {
        $this->publishes([
            __DIR__ . '/../../toCopyOnce/public' => public_path(),
            __DIR__ . '/../../toCopyOnce/app' => app_path(),
            __DIR__ . '/../../toCopyOnce/resources' => resource_path(),
            __DIR__ . '/../../toCopyOnce/routes' => base_path('routes'),
            __DIR__ . '/../../toCopyOnce/config' => config_path(),
            __DIR__ . '/../../toCopyOnce/database' => database_path(),
        ], 'rras3k-once');

        $this->publishes([
            __DIR__ . '/../../toMaj/public' => public_path(),
            __DIR__ . '/../../toMaj/resources' => resource_path(),
        ], 'rras3k-maj');
    }
}
