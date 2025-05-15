<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Objet;
use App\Services\GeocoderService;

class UpdateMissingCoordinates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-missing-coordinates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';


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
            $this->info("Mis à jour: {$objet->nom}");
        } else {
            $this->error("Échec pour: {$objet->nom}");
        }
        
        sleep(1); // Respect des limites d'API
    }
    
    $this->info("Terminé ! {$objets->count()} objets traités.");
}
}
