<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;
use App\Models\User;
use App\Models\TicketType;
use Illuminate\Support\Str;
use Carbon\Carbon;

class VirtualEventsSeeder extends Seeder
{
    public function run(): void
    {
        // Récupérer l'organisateur de test
        $organizer = User::where('email', 'organizer@tikehub.com')->first();
        
        if (!$organizer) {
            $this->command->error('Organisateur de test non trouvé. Exécutez d\'abord DatabaseSeeder.');
            return;
        }

        $virtualEvents = [
            [
                'title' => 'Formation en ligne : Marketing Digital',
                'description' => 'Formation complète sur les stratégies de marketing digital, les réseaux sociaux, le SEO et le marketing par email. Session interactive avec Q&A en direct.',
                'category' => 'Éducation',
                'platform_type' => 'google_meet',
                'meeting_link' => 'https://meet.google.com/abc-defg-hij',
                'meeting_id' => 'abc-defg-hij',
                'meeting_password' => null,
                'virtual_access_instructions' => 'Veuillez activer votre caméra et votre micro. Utilisez votre nom complet pour rejoindre la réunion.',
                'start_date' => Carbon::now()->addDays(7)->setTime(14, 0),
                'end_date' => Carbon::now()->addDays(7)->setTime(17, 0),
            ],
            [
                'title' => 'Webinaire : Intelligence Artificielle et Avenir',
                'description' => 'Découvrez comment l\'IA transforme notre quotidien et notre façon de travailler. Présentation par des experts du domaine.',
                'category' => 'Technologie',
                'platform_type' => 'zoom',
                'meeting_link' => 'https://zoom.us/j/1234567890',
                'meeting_id' => '1234567890',
                'meeting_password' => 'IA2024',
                'virtual_access_instructions' => 'Le mot de passe est requis. Rejoignez 5 minutes avant le début.',
                'start_date' => Carbon::now()->addDays(10)->setTime(18, 30),
                'end_date' => Carbon::now()->addDays(10)->setTime(20, 30),
            ],
            [
                'title' => 'Conférence virtuelle : Entrepreneuriat en Afrique',
                'description' => 'Table ronde avec des entrepreneurs africains qui partagent leurs expériences et leurs conseils pour réussir dans le business.',
                'category' => 'Business',
                'platform_type' => 'teams',
                'meeting_link' => 'https://teams.microsoft.com/l/meetup-join/19%3ameeting_abcdefghijk',
                'meeting_id' => null,
                'meeting_password' => null,
                'virtual_access_instructions' => 'Utilisez Microsoft Teams (application ou navigateur). Votre nom sera visible par tous les participants.',
                'start_date' => Carbon::now()->addDays(14)->setTime(15, 0),
                'end_date' => Carbon::now()->addDays(14)->setTime(17, 30),
            ],
            [
                'title' => 'Masterclass : Photographie Professionnelle',
                'description' => 'Apprenez les techniques avancées de photographie avec un photographe professionnel. Session pratique en direct.',
                'category' => 'Art',
                'platform_type' => 'webex',
                'meeting_link' => 'https://example.webex.com/example/j.php?MTID=m1234567890abcdef',
                'meeting_id' => '1234567890',
                'meeting_password' => 'PHOTO2024',
                'virtual_access_instructions' => 'Installez Cisco Webex ou utilisez le navigateur. Testez votre connexion avant la session.',
                'start_date' => Carbon::now()->addDays(5)->setTime(10, 0),
                'end_date' => Carbon::now()->addDays(5)->setTime(12, 30),
            ],
            [
                'title' => 'Séance de Yoga en ligne',
                'description' => 'Séance de yoga relaxante en direct avec un instructeur certifié. Tous niveaux bienvenus. Préparez votre tapis !',
                'category' => 'Santé',
                'platform_type' => 'google_meet',
                'meeting_link' => 'https://meet.google.com/xyz-uvwx-rst',
                'meeting_id' => 'xyz-uvwx-rst',
                'meeting_password' => null,
                'virtual_access_instructions' => 'Préparez un espace confortable et votre tapis de yoga. Portez des vêtements confortables.',
                'start_date' => Carbon::now()->addDays(3)->setTime(8, 0),
                'end_date' => Carbon::now()->addDays(3)->setTime(9, 0),
            ],
            [
                'title' => 'Concert virtuel : Musique Afrobeat',
                'description' => 'Concert live en streaming avec des artistes locaux. Profitez d\'une expérience musicale immersive depuis chez vous.',
                'category' => 'Musique',
                'platform_type' => 'zoom',
                'meeting_link' => 'https://zoom.us/j/9876543210',
                'meeting_id' => '9876543210',
                'meeting_password' => 'MUSIC2024',
                'virtual_access_instructions' => 'Pour une meilleure expérience, utilisez des écouteurs ou des haut-parleurs de qualité. Activez votre caméra si vous le souhaitez.',
                'start_date' => Carbon::now()->addDays(12)->setTime(20, 0),
                'end_date' => Carbon::now()->addDays(12)->setTime(23, 0),
            ],
        ];

        $this->command->info('Création de ' . count($virtualEvents) . ' événements virtuels...');

        foreach ($virtualEvents as $eventData) {
            $slug = Str::slug($eventData['title']);
            $event = Event::firstOrCreate(
                ['slug' => $slug],
                [
                    'organizer_id' => $organizer->id,
                    'title' => $eventData['title'],
                    'slug' => $slug,
                    'subdomain' => 'ev-' . $slug,
                    'subdomain_enabled' => false,
                    'description' => $eventData['description'],
                    'category' => $eventData['category'],
                    'type' => 'other',
                    'is_virtual' => true,
                    'platform_type' => $eventData['platform_type'],
                    'meeting_link' => $eventData['meeting_link'],
                    'meeting_id' => $eventData['meeting_id'],
                    'meeting_password' => $eventData['meeting_password'],
                    'virtual_access_instructions' => $eventData['virtual_access_instructions'],
                    'start_date' => $eventData['start_date'],
                    'end_date' => $eventData['end_date'],
                    'is_published' => true,
                    'status' => 'published',
                    'venue_latitude' => null,
                    'venue_longitude' => null,
                ]
            );

            // Créer des types de billets pour chaque événement
            $ticketTypes = [
                [
                    'name' => 'Billet Standard',
                    'description' => 'Accès standard à l\'événement virtuel',
                    'price' => 5000,
                    'quantity' => 100,
                    'is_active' => true,
                ],
                [
                    'name' => 'Billet VIP',
                    'description' => 'Accès VIP avec session Q&A exclusive',
                    'price' => 15000,
                    'quantity' => 20,
                    'is_active' => true,
                ],
            ];

            foreach ($ticketTypes as $ticketTypeData) {
                TicketType::firstOrCreate(
                    [
                        'event_id' => $event->id,
                        'name' => $ticketTypeData['name'],
                    ],
                    [
                        'event_id' => $event->id,
                        'name' => $ticketTypeData['name'],
                        'description' => $ticketTypeData['description'],
                        'price' => $ticketTypeData['price'],
                        'quantity' => $ticketTypeData['quantity'],
                        'sold_quantity' => 0,
                        'start_sale_date' => now(),
                        'end_sale_date' => $event->start_date->copy()->subHour(),
                        'is_active' => $ticketTypeData['is_active'],
                    ]
                );
            }

            $this->command->info("✓ Événement créé : {$event->title} ({$eventData['platform_type']})");
        }

        $this->command->info('');
        $this->command->info('═══════════════════════════════════════════════════════');
        $this->command->info('  ÉVÉNEMENTS VIRTUELS CRÉÉS AVEC SUCCÈS');
        $this->command->info('═══════════════════════════════════════════════════════');
        $this->command->info('');
        $this->command->info('Les événements virtuels sont maintenant disponibles sur la plateforme.');
        $this->command->info('Vous pouvez les voir sur : http://localhost:8000/events');
        $this->command->info('');
    }
}
