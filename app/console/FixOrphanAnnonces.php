<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Annonce;

class FixOrphanAnnonces extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fix-orphan-annonces';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $count = Annonce::doesntHave('objet')->delete();
        $this->info("{$count} annonces orphelines supprimées.");
    }
}
