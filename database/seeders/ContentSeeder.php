<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Event;
use App\Models\Contest;
use App\Models\Fundraising;
use Illuminate\Support\Str;

class ContentSeeder extends Seeder
{
    public function run(): void
    {
        // Récupérer l'organisateur
        $organizer = User::where('email', 'organizer@tikehub.com')->first();
        
        if (!$organizer) {
            $this->command->warn('Organisateur non trouvé. Exécutez d\'abord DatabaseSeeder.');
            return;
        }

        // Créer des événements
        $events = [
            [
                'title' => 'Concert de Jazz à Cotonou',
                'description' => 'Un magnifique concert de jazz avec des artistes locaux et internationaux. Venez profiter d\'une soirée musicale exceptionnelle.',
                'category' => 'Concert',
                'type' => 'concert',
                'start_date' => now()->addDays(30),
                'end_date' => now()->addDays(30)->addHours(4),
                'venue_name' => 'Centre Culturel de Cotonou',
                'venue_city' => 'Cotonou',
                'venue_country' => 'Bénin',
                'is_published' => true,
                'status' => 'published',
                'is_free' => false,
            ],
            [
                'title' => 'Tournoi de Football Inter-Entreprises',
                'description' => 'Participez au grand tournoi de football inter-entreprises. Inscrivez votre équipe et montrez vos talents sur le terrain.',
                'category' => 'Sport',
                'type' => 'competition',
                'start_date' => now()->addDays(45),
                'end_date' => now()->addDays(47),
                'venue_name' => 'Stade de l\'Amitié',
                'venue_city' => 'Cotonou',
                'venue_country' => 'Bénin',
                'is_published' => true,
                'status' => 'published',
                'is_free' => false,
            ],
            [
                'title' => 'Conférence sur l\'Entrepreneuriat',
                'description' => 'Une conférence inspirante sur l\'entrepreneuriat avec des intervenants de renom. Apprenez les secrets du succès entrepreneurial.',
                'category' => 'Business',
                'type' => 'other',
                'start_date' => now()->addDays(20),
                'end_date' => now()->addDays(20)->addHours(3),
                'venue_name' => 'Hôtel Novotel',
                'venue_city' => 'Cotonou',
                'venue_country' => 'Bénin',
                'is_published' => true,
                'status' => 'published',
                'is_free' => true,
            ],
        ];

        foreach ($events as $eventData) {
            $eventData['organizer_id'] = $organizer->id;
            $eventData['slug'] = Str::slug($eventData['title']);
            $eventData['subdomain'] = 'ev-' . $eventData['slug'];
            Event::firstOrCreate(
                ['slug' => $eventData['slug']],
                $eventData
            );
        }

        // Créer des concours
        $contests = [
            [
                'name' => 'Miss Bénin 2025',
                'description' => 'Participez au grand concours de beauté Miss Bénin 2025. Votez pour votre candidate favorite et aidez-la à remporter le titre.',
                'rules' => 'Chaque vote coûte 500 XOF. Le candidat avec le plus de votes remporte le concours.',
                'price_per_vote' => 500,
                'points_per_vote' => 1,
                'start_date' => now()->subDays(5),
                'end_date' => now()->addDays(25),
                'is_published' => true,
                'is_active' => true,
            ],
            [
                'name' => 'Meilleur Artiste de l\'Année',
                'description' => 'Votez pour le meilleur artiste de l\'année. Soutenez votre artiste préféré et faites-le gagner ce prestigieux titre.',
                'rules' => 'Chaque vote coûte 1000 XOF. Les votes sont illimités.',
                'price_per_vote' => 1000,
                'points_per_vote' => 1,
                'start_date' => now()->subDays(10),
                'end_date' => now()->addDays(20),
                'is_published' => true,
                'is_active' => true,
            ],
        ];

        foreach ($contests as $contestData) {
            $contestData['organizer_id'] = $organizer->id;
            Contest::firstOrCreate(
                ['name' => $contestData['name'], 'organizer_id' => $organizer->id],
                $contestData
            );
        }

        // Créer des collectes de fonds
        $fundraisings = [
            [
                'name' => 'Aide aux Victimes des Inondations',
                'description' => 'Soutenez les familles affectées par les récentes inondations. Votre contribution aidera à reconstruire leurs maisons et à leur fournir des biens essentiels.',
                'goal_amount' => 5000000,
                'current_amount' => 1250000,
                'start_date' => now()->subDays(15),
                'end_date' => now()->addDays(45),
                'show_donors' => true,
                'is_published' => true,
                'is_active' => true,
            ],
            [
                'name' => 'Construction d\'une École Primaire',
                'description' => 'Aidez-nous à construire une école primaire dans une zone rurale. Chaque contribution compte pour offrir une éducation de qualité aux enfants.',
                'goal_amount' => 10000000,
                'current_amount' => 3500000,
                'start_date' => now()->subDays(30),
                'end_date' => now()->addDays(60),
                'show_donors' => true,
                'is_published' => true,
                'is_active' => true,
            ],
            [
                'name' => 'Soutien aux Orphelins',
                'description' => 'Collecte de fonds pour améliorer les conditions de vie des orphelins. Votre don permettra d\'acheter des fournitures scolaires, des vêtements et de la nourriture.',
                'goal_amount' => 3000000,
                'current_amount' => 800000,
                'start_date' => now()->subDays(7),
                'end_date' => now()->addDays(53),
                'show_donors' => false,
                'is_published' => true,
                'is_active' => true,
            ],
        ];

        foreach ($fundraisings as $fundraisingData) {
            $fundraisingData['organizer_id'] = $organizer->id;
            $fundraisingData['slug'] = Str::slug($fundraisingData['name']);
            Fundraising::firstOrCreate(
                ['slug' => $fundraisingData['slug'], 'organizer_id' => $organizer->id],
                $fundraisingData
            );
        }

        $this->command->info('Données de test créées avec succès !');
        $this->command->info('- ' . Event::count() . ' événements');
        $this->command->info('- ' . Contest::count() . ' concours');
        $this->command->info('- ' . Fundraising::count() . ' collectes de fonds');
    }
}


