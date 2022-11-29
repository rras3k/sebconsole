<?php

namespace Rras3k\Console\app\commands;

use Rras3k\Console\App\Lib\MenuMaker;


use Illuminate\Console\Command;

class Choix extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'console:choix';

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
        $choix = $this->choice(
            'Saisir votre choix?',
            [
                "Quitter",
                "Afficher les actions possibles",
                "Publication après l'installation",
                'Copier console.scss dans /ressource/sass',
                'Copier _variables.example.scss dans /ressource/sass',
                'Copier console.php dans /config',
                'Ajouter RoleSeeder dans la base de données: '.env('DB_DATABASE'),
            ],
        );
        switch ($choix) {
            case 0: //
                return Command::SUCCESS;
                break;

            default:
                break;
        }

        return Command::SUCCESS;
    }

    private function publishConfiguration($forcePublish = false)
    {
        $params = [
            '--provider' => "Rras3k\Console\ConsoleServiceProvider",
            '--tag' => "config"
        ];

        if ($forcePublish === true) {
            $params['--force'] = true;
        }

        $this->call('vendor:publish', $params);
    }
}
