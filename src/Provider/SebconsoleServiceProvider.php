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
            // dd("ooo1");
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

        $this->importPublishOnce();

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
    php artisan db:seed --class=FirstSeeder
    php artisan vendor:publish
    php artisan vendor:publish --force --tag=rras3k-force
    php artisan vendor:publish --force --tag=rras3k-config

    */
    {
        // dd("oo");
        // Asset
        $this->publishes([
            __DIR__ . '/../../public/js' => public_path('js'),
            __DIR__ . '/../../public/img' => public_path('img'),
            __DIR__ . '/../ModelsToCopy' => app_path('Models'),
            __DIR__ . '/../../ressources/sass/_rras3k/console.scss' => resource_path('/sass/_rras3k/console.scss'),
            __DIR__ . '/../../ressources/sass/_rras3k/def.scss' => resource_path('/sass/_rras3k/def.scss'),
            __DIR__ . '/../../ressources/sass/_rras3k/panel.scss' => resource_path('/sass/_rras3k/panel.scss'),
            __DIR__ . '/../../ressources/sass/_rras3k/mvc_saisie.scss' => resource_path('/sass/_rras3k/mvc_saisie.scss'),
            __DIR__ . '/../../ressources/sass/_rras3k/panel2.scss' => resource_path('/sass/_rras3k/panel2.scss'),
            __DIR__ . '/../../ressources/sass/_rras3k/sidebar.scss' => resource_path('/sass/_rras3k/sidebar.scss'),
            __DIR__ . '/../../ressources/views/pasgit' => resource_path('views/page-dev'),
            __DIR__ . '/../../database/seeders/FirstSeeder.php' => database_path('seeders/FirstSeeder.php'),
            __DIR__ . '/../../ressources/sass/_variables.scss' => resource_path('/sass/_variables.example.scss'),
            __DIR__ . '/../../ressources/sass/_variables.scss' => resource_path('/sass/_variables.scss'),
            // __DIR__ . '/../Models/LogType.php' => app_path('Models/LogType.php'),
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
