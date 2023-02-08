<?php

namespace Rras3k\SebconsoleRoot\commands;


use Illuminate\Support\ServiceProvider;
use Rras3k\Sebconsole\Lib\GeneratorMvc;

use Illuminate\Console\Command;

class GeneratorMvcCommands extends Command
{



    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    // protected $signature = 'sebconsole:mvc {model} {themeCode} {themeUrl} {--prefix1=} {--prefix2=}';
    protected $signature = 'sebconsole:mvc {model} {table} {themeCode} {themeUrl} {--prefix1=} {--prefix2=} {--force=false}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Génère les fichiers et codes pour un MVC à partir d\'un modèle';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info("php artisan sebconsole:mvc {model} {table} {themeCode} {themeUrl} {--prefix1=} {--prefix2=} {--force=}");
        $this->info("Exempe :");
        $this->info("php artisan sebconsole:mvc Formulaire formulaires mes_formulaires mes-formulaires --prefix1=console --prefix2=affilies --force=true");
        $model = $this->argument('model');
        $table = $this->argument('table');
        $themeCode = $this->argument('themeCode');
        $themeUrl = $this->argument('themeUrl');
        $prefix1 = $this->option('prefix1');
        $prefix2 = $this->option('prefix2');
        $force = $this->option('force');
        $genMvc = new GeneratorMvc();

        $ret = $genMvc->setInfo($model, $table, $themeCode, $themeUrl, $prefix1, $prefix2, $force);

        // Grille
        // $this->info("Pour l'affichage de la table:");
        // $eltsLibelle=['non', 'oui'];
        // foreach ($ret as $champName => $champInfo) {
        //     $choix = $this->choice(
        //         'Afficher le champ: '. $champName,
        //         $eltsLibelle
        //     );
        //     $ret[$champName]['grille']['visible'] = ($choix == "oui");
        // }

        // // Edition
        // $this->info("Pour le formulaire:");
        // $eltsLibelle=['oui','non'];
        // $eltsTypeSaisie = ['']
        // foreach ($ret as $champName => $champInfo) {
        //     $choix = $this->choice(
        //         'Saisir : '. $champName,
        //         $eltsLibelle
        //     );
        //     $ret[$champName]['grille_visible'] = $choix ==1;
        // }
        $ret = $genMvc->genere($ret);
        if ($ret) return Command::SUCCESS;
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

    /*
    if ($this->prefix1 && $this->prefix2): 
			$prefix = $this->prefix1 . '/' . $this->prefix2 . '/';
		elseif ($this->prefix1 && !$this->prefix2): 
			$prefix = $this->prefix1 . '/';
		elseif (!$this->prefix1 && $this->prefix2): 
			$prefix = $this->prefix2 . '/';
		$prefix .=  $this->themeUrl;

		if($this->prefix2): $prefixRouteName = $this->prefix2.'.';

		 $content .= "Route::get(‘" . $prefix . " ', [".$patController.$this->model."Controller::class, '".$this->themeCode."_index'])->name('".$prefixRouteName.".$this->themeCode.".index');";
		 $this->writeFic('routes\/' . $prefix  . '-' . $this->model . '_web.php', $content);

         */
}
