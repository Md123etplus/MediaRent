<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\GeocoderService;
use App\Models\Objet;

class UpdateObjectsCoordinates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-objects-coordinates';

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
    $objets = Objet::whereNull('latitude')->get();

    foreach ($objets as $objet) {
        $geodata = GeocoderService::getCoordinates($objet->ville);
        
        if ($geodata['lat']) {
            $objet->update([
                'latitude' => $geodata['lat'],
                'longitude' => $geodata['lng']
            ]);
            $this->info("Updated {$objet->nom}");
        } else {
            $this->error("Failed {$objet->nom}");
        }
    }

    $this->info("Completed. Updated: ".$objets->count());
}
}
