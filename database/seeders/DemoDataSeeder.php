<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Contest;
use App\Models\ContestCandidate;
use App\Models\Fundraising;
use App\Models\Donation;
use App\Models\Vote;
use App\Models\Payment;
use App\Models\Event;
use App\Models\TicketType;
use App\Models\Ticket;
use Illuminate\Support\Str;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        $organizer = User::where('email', 'organizer@tikehub.com')->first();
        
        if (!$organizer) {
            $this->command->warn('Organisateur non trouvé. Exécutez d\'abord DatabaseSeeder.');
            return;
        }

        // Créer quelques utilisateurs pour les votes et dons
        $users = User::factory()->count(15)->create();

        // ===== CONCOURS MISS BÉNIN 2025 =====
        $missBenin = Contest::where('name', 'Miss Bénin 2025')->first();
        
        if ($missBenin) {
            // Candidats pour Miss Bénin
            $candidatesMissBenin = [
                [
                    'name' => 'Amina Diallo',
                    'description' => 'Étudiante en droit, passionnée de mode et de culture. Ambassadrice de la beauté béninoise.',
                    'number' => 1,
                ],
                [
                    'name' => 'Fatou Sall',
                    'description' => 'Mannequin professionnelle et entrepreneure. Fondatrice d\'une marque de vêtements éthiques.',
                    'number' => 2,
                ],
                [
                    'name' => 'Mariam Traoré',
                    'description' => 'Médecin et activiste sociale. Engagée dans la lutte contre les violences faites aux femmes.',
                    'number' => 3,
                ],
                [
                    'name' => 'Aissatou Barry',
                    'description' => 'Artiste peintre et photographe. Son art célèbre la beauté et la diversité africaine.',
                    'number' => 4,
                ],
                [
                    'name' => 'Kadiatou Camara',
                    'description' => 'Ingénieure en informatique et entrepreneure tech. Fondatrice d\'une startup innovante.',
                    'number' => 5,
                ],
                [
                    'name' => 'Nafissatou Ouedraogo',
                    'description' => 'Danseuse professionnelle et chorégraphe. Représente l\'élégance et la grâce béninoise.',
                    'number' => 6,
                ],
            ];

            foreach ($candidatesMissBenin as $candidateData) {
                $candidate = ContestCandidate::firstOrCreate(
                    [
                        'contest_id' => $missBenin->id,
                        'number' => $candidateData['number'],
                    ],
                    [
                        'name' => $candidateData['name'],
                        'description' => $candidateData['description'],
                        'is_active' => true,
                    ]
                );

                // Créer des votes pour chaque candidat (simulation)
                $voteCount = rand(50, 300); // Nombre de votes aléatoire
                $points = 0;
                
                for ($i = 0; $i < $voteCount; $i++) {
                    $user = $users->random();
                    $quantity = rand(1, 5); // 1 à 5 votes par transaction
                    $totalAmount = $missBenin->price_per_vote * $quantity;
                    $totalPoints = $missBenin->points_per_vote * $quantity;
                    
                    // Créer un paiement simulé
                    $payment = Payment::create([
                        'user_id' => $user->id,
                        'event_id' => null,
                        'paymentable_type' => Contest::class,
                        'paymentable_id' => $missBenin->id,
                        'amount' => $totalAmount,
                        'currency' => 'XOF',
                        'status' => 'completed',
                        'platform_commission' => $totalAmount * 0.05,
                        'organizer_amount' => $totalAmount * 0.95,
                    ]);

                    // Créer les votes
                    for ($j = 0; $j < $quantity; $j++) {
                        Vote::create([
                            'contest_id' => $missBenin->id,
                            'candidate_id' => $candidate->id,
                            'user_id' => $user->id,
                            'payment_id' => $payment->id,
                            'points' => $missBenin->points_per_vote,
                            'ip_address' => fake()->ipv4(),
                            'user_agent' => fake()->userAgent(),
                            'created_at' => now()->subDays(rand(0, 5)),
                        ]);
                        $points += $missBenin->points_per_vote;
                    }
                }
            }
        }

        // ===== CONCOURS MEILLEUR ARTISTE =====
        $artisteContest = Contest::where('name', 'Meilleur Artiste de l\'Année')->first();
        
        if ($artisteContest) {
            $candidatesArtiste = [
                [
                    'name' => 'Angélique Kidjo',
                    'description' => 'Chanteuse et compositrice de renommée internationale. Ambassadrice de la musique africaine.',
                    'number' => 1,
                ],
                [
                    'name' => 'Fally Ipupa',
                    'description' => 'Auteur-compositeur-interprète et danseur. Star de la musique congolaise moderne.',
                    'number' => 2,
                ],
                [
                    'name' => 'Burna Boy',
                    'description' => 'Artiste nigérian, lauréat d\'un Grammy Award. Pionnier de l\'Afrobeats.',
                    'number' => 3,
                ],
                [
                    'name' => 'Davido',
                    'description' => 'Chanteur et producteur nigérian. L\'une des plus grandes stars de l\'Afrobeats.',
                    'number' => 4,
                ],
            ];

            foreach ($candidatesArtiste as $candidateData) {
                $candidate = ContestCandidate::firstOrCreate(
                    [
                        'contest_id' => $artisteContest->id,
                        'number' => $candidateData['number'],
                    ],
                    [
                        'name' => $candidateData['name'],
                        'description' => $candidateData['description'],
                        'is_active' => true,
                    ]
                );

                // Créer des votes
                $voteCount = rand(30, 200);
                
                for ($i = 0; $i < $voteCount; $i++) {
                    $user = $users->random();
                    $quantity = rand(1, 3);
                    $totalAmount = $artisteContest->price_per_vote * $quantity;
                    
                    $payment = Payment::create([
                        'user_id' => $user->id,
                        'event_id' => null,
                        'paymentable_type' => Contest::class,
                        'paymentable_id' => $artisteContest->id,
                        'amount' => $totalAmount,
                        'currency' => 'XOF',
                        'status' => 'completed',
                        'platform_commission' => $totalAmount * 0.05,
                        'organizer_amount' => $totalAmount * 0.95,
                    ]);

                    for ($j = 0; $j < $quantity; $j++) {
                        Vote::create([
                            'contest_id' => $artisteContest->id,
                            'candidate_id' => $candidate->id,
                            'user_id' => $user->id,
                            'payment_id' => $payment->id,
                            'points' => $artisteContest->points_per_vote,
                            'ip_address' => fake()->ipv4(),
                            'user_agent' => fake()->userAgent(),
                            'created_at' => now()->subDays(rand(0, 10)),
                        ]);
                    }
                }
            }
        }

        // ===== COLLECTE INONDATIONS =====
        $inondations = Fundraising::where('name', 'Aide aux Victimes des Inondations')->first();
        
        if ($inondations) {
            // Ajouter des paliers
            $inondations->update([
                'milestones' => [
                    [
                        'name' => 'Palier 1 : Aide d\'urgence',
                        'description' => 'Fournir des kits d\'urgence (nourriture, eau, médicaments) à 100 familles',
                        'amount' => 1000000,
                    ],
                    [
                        'name' => 'Palier 2 : Abris temporaires',
                        'description' => 'Construire des abris temporaires pour 50 familles déplacées',
                        'amount' => 2500000,
                    ],
                    [
                        'name' => 'Palier 3 : Reconstruction',
                        'description' => 'Aider à la reconstruction de 20 maisons endommagées',
                        'amount' => 5000000,
                    ],
                ],
            ]);

            // Créer des dons
            $donationMessages = [
                'Courage à toutes les familles affectées !',
                'Ensemble, nous pouvons les aider à reconstruire.',
                'Ma petite contribution pour une grande cause.',
                'Solidarité avec nos frères et sœurs en difficulté.',
                'Que Dieu bénisse tous les donateurs.',
                'Chaque geste compte, merci pour votre générosité.',
                'Espérant que cela aidera les familles dans le besoin.',
                'Solidarité et compassion pour nos compatriotes.',
            ];

            for ($i = 0; $i < 45; $i++) {
                $user = $users->random();
                $amount = [5000, 10000, 15000, 20000, 25000, 50000, 100000][array_rand([5000, 10000, 15000, 20000, 25000, 50000, 100000])];
                $isAnonymous = rand(0, 10) < 2; // 20% de dons anonymes
                
                $payment = Payment::create([
                    'user_id' => $user->id,
                    'event_id' => null,
                    'paymentable_type' => Fundraising::class,
                    'paymentable_id' => $inondations->id,
                    'amount' => $amount,
                    'currency' => 'XOF',
                    'status' => 'completed',
                    'platform_commission' => $amount * 0.05,
                    'organizer_amount' => $amount * 0.95,
                ]);

                Donation::create([
                    'fundraising_id' => $inondations->id,
                    'user_id' => $user->id,
                    'payment_id' => $payment->id,
                    'amount' => $amount,
                    'is_anonymous' => $isAnonymous,
                    'message' => rand(0, 10) < 7 ? $donationMessages[array_rand($donationMessages)] : null,
                    'created_at' => now()->subDays(rand(0, 15)),
                ]);
            }

            // Mettre à jour le montant collecté
            $totalCollected = Donation::where('fundraising_id', $inondations->id)->sum('amount');
            $inondations->update(['current_amount' => $totalCollected]);
        }

        // ===== COLLECTE ÉCOLE PRIMAIRE =====
        $ecole = Fundraising::where('name', 'Construction d\'une École Primaire')->first();
        
        if ($ecole) {
            $ecole->update([
                'milestones' => [
                    [
                        'name' => 'Palier 1 : Terrain et fondations',
                        'description' => 'Achat du terrain et travaux de fondation',
                        'amount' => 2000000,
                    ],
                    [
                        'name' => 'Palier 2 : Structure principale',
                        'description' => 'Construction des murs et toiture de l\'école',
                        'amount' => 5000000,
                    ],
                    [
                        'name' => 'Palier 3 : Équipement',
                        'description' => 'Achat du mobilier scolaire et équipements pédagogiques',
                        'amount' => 8000000,
                    ],
                    [
                        'name' => 'Palier 4 : Finalisation',
                        'description' => 'Peinture, électricité, eau et inauguration',
                        'amount' => 10000000,
                    ],
                ],
            ]);

            for ($i = 0; $i < 60; $i++) {
                $user = $users->random();
                $amount = [10000, 20000, 50000, 100000, 200000, 500000][array_rand([10000, 20000, 50000, 100000, 200000, 500000])];
                $isAnonymous = rand(0, 10) < 3;
                
                $payment = Payment::create([
                    'user_id' => $user->id,
                    'event_id' => null,
                    'paymentable_type' => Fundraising::class,
                    'paymentable_id' => $ecole->id,
                    'amount' => $amount,
                    'currency' => 'XOF',
                    'status' => 'completed',
                    'platform_commission' => $amount * 0.05,
                    'organizer_amount' => $amount * 0.95,
                ]);

                Donation::create([
                    'fundraising_id' => $ecole->id,
                    'user_id' => $user->id,
                    'payment_id' => $payment->id,
                    'amount' => $amount,
                    'is_anonymous' => $isAnonymous,
                    'message' => rand(0, 10) < 6 ? $donationMessages[array_rand($donationMessages)] : null,
                    'created_at' => now()->subDays(rand(0, 30)),
                ]);
            }

            $totalCollected = Donation::where('fundraising_id', $ecole->id)->sum('amount');
            $ecole->update(['current_amount' => $totalCollected]);
        }

        // ===== COLLECTE ORPHELINS =====
        $orphelins = Fundraising::where('name', 'Soutien aux Orphelins')->first();
        
        if ($orphelins) {
            for ($i = 0; $i < 25; $i++) {
                $user = $users->random();
                $amount = [5000, 10000, 15000, 25000, 50000][array_rand([5000, 10000, 15000, 25000, 50000])];
                $isAnonymous = rand(0, 10) < 4; // Plus de dons anonymes pour cette collecte
                
                $payment = Payment::create([
                    'user_id' => $user->id,
                    'event_id' => null,
                    'paymentable_type' => Fundraising::class,
                    'paymentable_id' => $orphelins->id,
                    'amount' => $amount,
                    'currency' => 'XOF',
                    'status' => 'completed',
                    'platform_commission' => $amount * 0.05,
                    'organizer_amount' => $amount * 0.95,
                ]);

                Donation::create([
                    'fundraising_id' => $orphelins->id,
                    'user_id' => $user->id,
                    'payment_id' => $payment->id,
                    'amount' => $amount,
                    'is_anonymous' => $isAnonymous,
                    'message' => rand(0, 10) < 5 ? $donationMessages[array_rand($donationMessages)] : null,
                    'created_at' => now()->subDays(rand(0, 7)),
                ]);
            }

            $totalCollected = Donation::where('fundraising_id', $orphelins->id)->sum('amount');
            $orphelins->update(['current_amount' => $totalCollected]);
        }

        // ===== TICKETS POUR ÉVÉNEMENTS =====
        $events = Event::where('is_published', true)->get();
        
        foreach ($events as $event) {
            // Créer des types de billets pour chaque événement
            $ticketTypes = [];
            
            if (str_contains($event->title, 'Concert')) {
                $ticketTypes = [
                    [
                        'name' => 'Early Bird',
                        'description' => 'Billet à prix réduit pour les premiers acheteurs',
                        'price' => 5000,
                        'quantity' => 100,
                        'start_sale_date' => now()->subDays(10),
                        'end_sale_date' => $event->start_date->subDay(),
                    ],
                    [
                        'name' => 'Standard',
                        'description' => 'Billet standard pour le concert',
                        'price' => 7500,
                        'quantity' => 200,
                        'start_sale_date' => now()->subDays(5),
                        'end_sale_date' => $event->start_date->subDay(),
                    ],
                    [
                        'name' => 'VIP',
                        'description' => 'Accès VIP avec rencontre avec les artistes',
                        'price' => 15000,
                        'quantity' => 50,
                        'start_sale_date' => now()->subDays(15),
                        'end_sale_date' => $event->start_date->subDay(),
                    ],
                ];
            } elseif (str_contains($event->title, 'Tournoi')) {
                $ticketTypes = [
                    [
                        'name' => 'Tribune',
                        'description' => 'Place en tribune',
                        'price' => 3000,
                        'quantity' => 300,
                        'start_sale_date' => now()->subDays(20),
                        'end_sale_date' => $event->start_date->subDay(),
                    ],
                    [
                        'name' => 'Pelouse',
                        'description' => 'Place en pelouse',
                        'price' => 2000,
                        'quantity' => 500,
                        'start_sale_date' => now()->subDays(20),
                        'end_sale_date' => $event->start_date->subDay(),
                    ],
                ];
            } else {
                // Pour les autres événements (conférences, etc.)
                $ticketTypes = [
                    [
                        'name' => 'Entrée Standard',
                        'description' => 'Accès à la conférence',
                        'price' => $event->is_free ? 0 : 5000,
                        'quantity' => 150,
                        'start_sale_date' => now()->subDays(10),
                        'end_sale_date' => $event->start_date->subDay(),
                    ],
                ];
            }

            foreach ($ticketTypes as $ticketTypeData) {
                $ticketType = TicketType::firstOrCreate(
                    [
                        'event_id' => $event->id,
                        'name' => $ticketTypeData['name'],
                    ],
                    array_merge($ticketTypeData, [
                        'sold_quantity' => 0,
                        'is_active' => true,
                    ])
                );

                // Créer des tickets vendus (simulation)
                $soldCount = rand(10, min(50, (int)($ticketType->quantity * 0.4))); // 10 à 40% des billets vendus
                
                for ($i = 0; $i < $soldCount; $i++) {
                    $buyer = $users->random();
                    
                    $payment = Payment::create([
                        'user_id' => $buyer->id,
                        'event_id' => $event->id,
                        'paymentable_type' => Event::class,
                        'paymentable_id' => $event->id,
                        'amount' => $ticketType->price,
                        'currency' => 'XOF',
                        'status' => 'completed',
                        'platform_commission' => $ticketType->price * 0.05,
                        'organizer_amount' => $ticketType->price * 0.95,
                    ]);

                    Ticket::create([
                        'event_id' => $event->id,
                        'ticket_type_id' => $ticketType->id,
                        'buyer_id' => $buyer->id,
                        'payment_id' => $payment->id,
                        'price' => $ticketType->price,
                        'status' => 'paid',
                        'buyer_name' => $buyer->name,
                        'buyer_email' => $buyer->email,
                        'buyer_phone' => $buyer->phone,
                        'is_physical' => false,
                        'created_at' => now()->subDays(rand(0, 10)),
                    ]);
                }

                // Mettre à jour la quantité vendue
                $ticketType->update([
                    'sold_quantity' => $soldCount,
                ]);
            }
        }

        $this->command->info('✅ Données de démonstration créées avec succès !');
        $this->command->info('📊 Candidats créés : ' . ContestCandidate::count());
        $this->command->info('🗳️  Votes créés : ' . Vote::count());
        $this->command->info('💝 Dons créés : ' . Donation::count());
        $this->command->info('🎫 Types de billets créés : ' . TicketType::count());
        $this->command->info('🎟️  Billets vendus : ' . Ticket::where('status', 'paid')->count());
    }
}

