<?php

namespace Rras3k\SebconsoleRoot\commands;

use Rras3k\Console\App\Lib\MenuMaker;

use Illuminate\Support\ServiceProvider;

use Illuminate\Console\Command;

class Menu extends Command
{



    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sebconsole:menu';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Construit le menu principal de la console';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $eltsLibelle = [
            "Quitter",
            "Afficher les actions possibles",
            "Publication après l'installation",
            'Ajouter RoleSeeder dans la base de données: ' . env('DB_DATABASE'),
        ];
        $eltsFct = [

        ];

        $choix = $this->choice(
            'Saisir votre choix?',
            $eltsLibelle
        );

        switch ($choix) {
            case "Quitter": //
                $this->info("Bye");
                return Command::SUCCESS;
                break;

            case "Afficher les actions possibles": //
                $this->info("Actions Possibles:");
                return Command::SUCCESS;
                break;

            case "Publication après l'installation": //
                $this->publishAfterInstall();
                return Command::SUCCESS;
                break;

            default:
                $this->info($choix);
                break;
        }

        return Command::SUCCESS;
    }


    private function publishConfiguration($forcePublish = false)
    {
        $params = [
            '--provider' => "Rras3k\Sebconsole\Provider\SebconsoleServiceProvider",
            '--tag' => "config"
        ];

        if ($forcePublish === true) {
            $params['--force'] = true;
        }

        $this->call('vendor:publish', $params);
    }

    private function publishAfterInstall()
    {
        $this->info('Publication après installation');

        // Asset
        $this->publishes([
            __DIR__ . '/../../public/js' => public_path('js'),
        ]);

        // console.css
        $this->publishes([
            __DIR__ . '/../../ressoucres/sass/sebconsole.scss' => resource_path('/sass/sebconsole.scss'),
            __DIR__ . '/../../ressoucres/sass/_variables.scss' => resource_path('/sass/_variables.example.scss'),
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
