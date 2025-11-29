<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Contest;

class UpdateContestsOrganizer extends Command
{
    protected $signature = 'contests:update-organizer';
    protected $description = 'Met à jour les concours pour les associer à l\'organisateur de test';

    public function handle()
    {
        $organizer = User::where('email', 'organizer@tikehub.com')->first();
        
        if (!$organizer) {
            $this->error('Organisateur non trouvé. Exécutez d\'abord DatabaseSeeder.');
            return 1;
        }

        $contests = Contest::whereNull('organizer_id')
            ->orWhere('organizer_id', '!=', $organizer->id)
            ->get();

        if ($contests->isEmpty()) {
            $this->info('Tous les concours sont déjà associés à l\'organisateur.');
            return 0;
        }

        $updated = 0;
        foreach ($contests as $contest) {
            $contest->organizer_id = $organizer->id;
            $contest->save();
            $updated++;
            $this->info("Concours '{$contest->name}' mis à jour.");
        }

        $this->info("{$updated} concours mis à jour avec succès.");
        return 0;
    }
}

