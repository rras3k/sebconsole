<?php
namespace Rras3k\Console\app\commands;

use Rras3k\Console\App\Lib\MenuMaker;


use Illuminate\Console\Command;

class Console extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'console:test';

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
        // Menu
        // MenuMaker::init();

        $this->info('The command was successful !');
        return Command::SUCCESS;
    }

}
