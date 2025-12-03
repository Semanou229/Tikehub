<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\User;
use Illuminate\Support\Str;

class BlogArticlesSeeder extends Seeder
{
    public function run(): void
    {
        // Récupérer ou créer un admin pour les articles
        $admin = User::where('email', 'admin@tikehub.com')->first();
        if (!$admin) {
            $admin = User::whereHas('roles', function($q) {
                $q->where('name', 'admin');
            })->first();
        }
        
        if (!$admin) {
            $this->command->warn('Aucun admin trouvé. Les articles ne peuvent pas être créés.');
            return;
        }

        // Créer ou récupérer les catégories
        $categorieGuide = BlogCategory::firstOrCreate(
            ['slug' => 'guides'],
            [
                'name' => 'Guides',
                'description' => 'Guides pratiques pour organisateurs d\'événements',
                'color' => '#4f46e5',
                'is_active' => true,
                'order' => 1
            ]
        );

        $categorieConseils = BlogCategory::firstOrCreate(
            ['slug' => 'conseils'],
            [
                'name' => 'Conseils',
                'description' => 'Conseils et astuces pour réussir vos événements',
                'color' => '#7c3aed',
                'is_active' => true,
                'order' => 2
            ]
        );

        $categorieTechnologie = BlogCategory::firstOrCreate(
            ['slug' => 'technologie'],
            [
                'name' => 'Technologie',
                'description' => 'Actualités et innovations technologiques',
                'color' => '#10b981',
                'is_active' => true,
                'order' => 3
            ]
        );

        // Article 1: Comment organiser un événement réussi en Afrique
        Blog::firstOrCreate(
            ['slug' => 'comment-organiser-evenement-reussi-afrique'],
            [
                'blog_category_id' => $categorieConseils->id,
                'user_id' => $admin->id,
                'title' => 'Comment organiser un événement réussi en Afrique : Guide complet 2024',
                'slug' => 'comment-organiser-evenement-reussi-afrique',
                'excerpt' => 'Découvrez les meilleures pratiques pour organiser un événement réussi en Afrique. De la planification à la billetterie en ligne, ce guide complet vous accompagne étape par étape.',
                'content' => $this->getArticle1Content(),
                'meta_title' => 'Comment organiser un événement réussi en Afrique | Guide complet 2024',
                'meta_description' => 'Guide complet pour organiser un événement réussi en Afrique. Conseils pratiques, billetterie en ligne, gestion d\'événements, marketing et communication. Optimisé pour le marché africain.',
                'is_published' => true,
                'published_at' => now(),
                'order' => 1,
            ]
        );

        // Article 2: Guide complet de la billetterie en ligne
        Blog::firstOrCreate(
            ['slug' => 'guide-complet-billetterie-en-ligne-organisateurs'],
            [
                'blog_category_id' => $categorieGuide->id,
                'user_id' => $admin->id,
                'title' => 'Guide complet de la billetterie en ligne pour organisateurs d\'événements',
                'slug' => 'guide-complet-billetterie-en-ligne-organisateurs',
                'excerpt' => 'Tout ce que vous devez savoir sur la billetterie en ligne pour vos événements. Découvrez comment choisir la bonne plateforme, optimiser vos ventes et gérer efficacement vos billets.',
                'content' => $this->getArticle2Content(),
                'meta_title' => 'Guide complet billetterie en ligne | Tikehub pour organisateurs',
                'meta_description' => 'Guide complet sur la billetterie en ligne pour organisateurs. Comment vendre des billets en ligne, gérer les QR codes, optimiser les ventes et maximiser vos revenus d\'événements.',
                'is_published' => true,
                'published_at' => now()->subDays(2),
                'order' => 2,
            ]
        );

        // Article 3: Moneroo et paiements mobiles
        Blog::firstOrCreate(
            ['slug' => 'moneroo-paiements-mobiles-revolution-evenements-afrique'],
            [
                'blog_category_id' => $categorieTechnologie->id,
                'user_id' => $admin->id,
                'title' => 'Moneroo et paiements mobiles : révolutionner les événements en Afrique',
                'slug' => 'moneroo-paiements-mobiles-revolution-evenements-afrique',
                'excerpt' => 'Découvrez comment Moneroo et les paiements mobiles transforment l\'industrie des événements en Afrique. Mobile money, cartes bancaires et solutions de paiement adaptées au marché africain.',
                'content' => $this->getArticle3Content(),
                'meta_title' => 'Moneroo et paiements mobiles pour événements en Afrique | Tikehub',
                'meta_description' => 'Comment Moneroo révolutionne les paiements pour événements en Afrique. Mobile money, paiements sécurisés, solutions adaptées au marché africain. Guide complet 2024.',
                'is_published' => true,
                'published_at' => now()->subDays(5),
                'order' => 3,
            ]
        );

        $this->command->info('3 articles de blog optimisés SEO créés avec succès !');
    }

    private function getArticle1Content(): string
    {
        return <<<'HTML'
<h2>Introduction</h2>
<p>Organiser un événement réussi en Afrique nécessite une approche adaptée aux spécificités du marché local. Que vous planifiiez un concert, une conférence, un festival ou un événement corporatif, ce guide complet vous accompagne à chaque étape pour garantir le succès de votre événement.</p>

<h2>1. Planification et préparation</h2>
<h3>1.1 Définir vos objectifs</h3>
<p>Avant de commencer, il est essentiel de définir clairement vos objectifs :</p>
<ul>
    <li><strong>Objectifs financiers</strong> : Quel est votre budget ? Quel revenu souhaitez-vous générer ?</li>
    <li><strong>Objectifs de participation</strong> : Combien de participants visez-vous ?</li>
    <li><strong>Objectifs de communication</strong> : Quel message souhaitez-vous transmettre ?</li>
</ul>

<h3>1.2 Choisir la date et le lieu</h3>
<p>Le choix de la date et du lieu est crucial pour le succès de votre événement :</p>
<ul>
    <li>Évitez les périodes de fêtes religieuses ou nationales</li>
    <li>Vérifiez la disponibilité des salles et les conditions météorologiques</li>
    <li>Assurez-vous que le lieu est accessible en transport en commun</li>
    <li>Vérifiez la capacité d'accueil et les équipements disponibles</li>
</ul>

<h2>2. Billetterie en ligne avec Tikehub</h2>
<h3>2.1 Pourquoi choisir la billetterie en ligne ?</h3>
<p>La billetterie en ligne offre de nombreux avantages :</p>
<ul>
    <li><strong>Accessibilité 24/7</strong> : Vos participants peuvent acheter leurs billets à tout moment</li>
    <li><strong>Gestion simplifiée</strong> : Suivez vos ventes en temps réel</li>
    <li><strong>Paiements sécurisés</strong> : Intégration avec Moneroo pour des paiements sécurisés</li>
    <li><strong>QR codes uniques</strong> : Lutte contre la fraude et gestion facilitée à l'entrée</li>
</ul>

<h3>2.2 Créer votre événement sur Tikehub</h3>
<p>Créer un événement sur Tikehub est simple et rapide :</p>
<ol>
    <li>Connectez-vous à votre compte organisateur</li>
    <li>Cliquez sur "Créer un événement"</li>
    <li>Remplissez les informations de base (titre, description, date, lieu)</li>
    <li>Configurez vos types de billets (VIP, Standard, Étudiant, etc.)</li>
    <li>Définissez vos prix et la quantité disponible</li>
    <li>Publiez votre événement</li>
</ol>

<h2>3. Marketing et communication</h2>
<h3>3.1 Utiliser les réseaux sociaux</h3>
<p>Les réseaux sociaux sont essentiels pour promouvoir votre événement :</p>
<ul>
    <li><strong>Facebook</strong> : Créez un événement Facebook et partagez-le régulièrement</li>
    <li><strong>Instagram</strong> : Utilisez des visuels attractifs et des hashtags pertinents</li>
    <li><strong>Twitter</strong> : Partagez des mises à jour et créez du buzz</li>
    <li><strong>WhatsApp</strong> : Créez des groupes de diffusion pour toucher votre audience locale</li>
</ul>

<h3>3.2 Partenariats locaux</h3>
<p>Établir des partenariats avec des acteurs locaux peut considérablement augmenter votre visibilité :</p>
<ul>
    <li>Médias locaux (radio, télévision, presse)</li>
    <li>Influenceurs et blogueurs locaux</li>
    <li>Associations et organisations communautaires</li>
    <li>Entreprises locales</li>
</ul>

<h2>4. Gestion le jour J</h2>
<h3>4.1 Équipe et matériel</h3>
<p>Assurez-vous d'avoir :</p>
<ul>
    <li>Une équipe suffisante pour gérer l'accueil et le contrôle des billets</li>
    <li>Des scanners QR code fonctionnels (via l'application Tikehub)</li>
    <li>Un système de secours en cas de problème technique</li>
    <li>Une signalétique claire pour guider les participants</li>
</ul>

<h3>4.2 Gestion des imprévus</h3>
<p>Préparez-vous aux imprévus :</p>
<ul>
    <li>Ayez un plan B en cas de mauvais temps (pour événements extérieurs)</li>
    <li>Prévoyez une solution de secours pour les paiements</li>
    <li>Assurez-vous d'avoir des contacts d'urgence</li>
</ul>

<h2>5. Suivi et analyse post-événement</h2>
<h3>5.1 Analyser les résultats</h3>
<p>Après votre événement, analysez les données disponibles sur Tikehub :</p>
<ul>
    <li>Nombre de billets vendus</li>
    <li>Revenus générés</li>
    <li>Profil des participants</li>
    <li>Taux de participation effectif</li>
</ul>

<h3>5.2 Collecter les retours</h3>
<p>Demandez des retours à vos participants :</p>
<ul>
    <li>Créez un formulaire de satisfaction</li>
    <li>Utilisez les réseaux sociaux pour recueillir des témoignages</li>
    <li>Analysez les points d'amélioration pour vos prochains événements</li>
</ul>

<h2>Conclusion</h2>
<p>Organiser un événement réussi en Afrique nécessite une bonne planification, les bons outils et une communication efficace. Avec Tikehub, vous disposez d'une plateforme complète pour gérer tous les aspects de votre événement, de la billetterie en ligne à l'analyse des résultats.</p>

<p><strong>Prêt à organiser votre premier événement ?</strong> <a href="/register">Créez votre compte organisateur sur Tikehub</a> et commencez dès aujourd'hui !</p>
HTML;
    }

    private function getArticle2Content(): string
    {
        return <<<'HTML'
<h2>Introduction</h2>
<p>La billetterie en ligne a révolutionné la façon dont nous organisons et participons aux événements. Pour les organisateurs, elle offre une solution complète de gestion des ventes, des participants et des revenus. Ce guide complet vous explique tout ce que vous devez savoir sur la billetterie en ligne.</p>

<h2>1. Pourquoi passer à la billetterie en ligne ?</h2>
<h3>1.1 Avantages pour les organisateurs</h3>
<p>La billetterie en ligne présente de nombreux avantages :</p>
<ul>
    <li><strong>Gain de temps</strong> : Plus besoin de gérer manuellement les réservations</li>
    <li><strong>Ventes 24/7</strong> : Vos billets sont disponibles à tout moment</li>
    <li><strong>Gestion centralisée</strong> : Toutes vos données en un seul endroit</li>
    <li><strong>Paiements sécurisés</strong> : Transactions sécurisées via Moneroo</li>
    <li><strong>Lutte contre la fraude</strong> : QR codes uniques et traçabilité complète</li>
    <li><strong>Statistiques en temps réel</strong> : Suivez vos ventes et performances</li>
</ul>

<h3>1.2 Avantages pour les participants</h3>
<p>Vos participants apprécient également la billetterie en ligne :</p>
<ul>
    <li>Achat depuis leur smartphone, tablette ou ordinateur</li>
    <li>Billets numériques reçus instantanément</li>
    <li>Pas de file d'attente pour l'achat</li>
    <li>Paiements sécurisés et multiples options de paiement</li>
</ul>

<h2>2. Comment fonctionne la billetterie en ligne ?</h2>
<h3>2.1 Le processus de vente</h3>
<p>Voici comment fonctionne une vente de billet en ligne :</p>
<ol>
    <li>Le participant visite votre page d'événement</li>
    <li>Il sélectionne le type et la quantité de billets souhaités</li>
    <li>Il procède au paiement via Moneroo (mobile money, carte bancaire)</li>
    <li>Il reçoit immédiatement ses billets par email avec QR code unique</li>
    <li>Le jour de l'événement, le QR code est scanné à l'entrée</li>
</ol>

<h3>2.2 Les QR codes : votre allié sécurité</h3>
<p>Chaque billet généré sur Tikehub possède un QR code unique :</p>
<ul>
    <li><strong>Unicite</strong> : Impossible de dupliquer un billet</li>
    <li><strong>Validation instantanée</strong> : Scan rapide à l'entrée</li>
    <li><strong>Traçabilité</strong> : Chaque scan est enregistré</li>
    <li><strong>Lutte contre la fraude</strong> : Un QR code ne peut être utilisé qu'une seule fois</li>
</ul>

<h2>3. Optimiser vos ventes de billets</h2>
<h3>3.1 Stratégies de pricing</h3>
<p>Plusieurs stratégies peuvent optimiser vos ventes :</p>
<ul>
    <li><strong>Early Bird</strong> : Offrez des prix réduits pour les premiers acheteurs</li>
    <li><strong>Tarifs dégressifs</strong> : Réductions pour les groupes</li>
    <li><strong>Codes promo</strong> : Créez des codes promotionnels pour des campagnes spécifiques</li>
    <li><strong>Tarifs étudiants</strong> : Offrez des réductions pour les étudiants</li>
</ul>

<h3>3.2 Communication efficace</h3>
<p>Pour maximiser vos ventes :</p>
<ul>
    <li>Partagez régulièrement votre événement sur les réseaux sociaux</li>
    <li>Envoyez des rappels par email aux personnes intéressées</li>
    <li>Créez de l'urgence avec des messages "Plus que X billets disponibles"</li>
    <li>Utilisez le CRM intégré de Tikehub pour vos campagnes email</li>
</ul>

<h2>4. Gérer vos billets efficacement</h2>
<h3>4.1 Types de billets</h3>
<p>Sur Tikehub, vous pouvez créer différents types de billets :</p>
<ul>
    <li><strong>VIP</strong> : Accès privilégié avec avantages supplémentaires</li>
    <li><strong>Standard</strong> : Billets classiques</li>
    <li><strong>Étudiant</strong> : Tarifs réduits pour les étudiants</li>
    <li><strong>Gratuit</strong> : Pour les événements sans frais d'entrée</li>
</ul>

<h3>4.2 Gestion des stocks</h3>
<p>Contrôlez parfaitement vos stocks :</p>
<ul>
    <li>Définissez la quantité disponible pour chaque type de billet</li>
    <li>Recevez des alertes quand les stocks sont faibles</li>
    <li>Gérez les listes d'attente automatiquement</li>
</ul>

<h2>5. Le jour J : validation des billets</h2>
<h3>5.1 Application de scan</h3>
<p>Avec Tikehub, scannez les billets facilement :</p>
<ul>
    <li>Application mobile dédiée pour les agents</li>
    <li>Scan rapide du QR code</li>
    <li>Validation instantanée</li>
    <li>Statistiques en temps réel</li>
</ul>

<h3>5.2 Gestion des agents</h3>
<p>Créez des équipes d'agents pour gérer vos événements :</p>
<ul>
    <li>Assignez des agents à des zones spécifiques</li>
    <li>Suivez les performances de chaque agent</li>
    <li>Gérez les permissions et accès</li>
</ul>

<h2>6. Analyse et rapports</h2>
<h3>6.1 Statistiques en temps réel</h3>
<p>Suivez vos performances en direct :</p>
<ul>
    <li>Nombre de billets vendus</li>
    <li>Revenus générés</li>
    <li>Taux de conversion</li>
    <li>Profil des participants</li>
</ul>

<h3>6.2 Rapports détaillés</h3>
<p>Exportez vos données pour une analyse approfondie :</p>
<ul>
    <li>Export Excel pour analyse financière</li>
    <li>Export PDF pour présentation</li>
    <li>Graphiques et visualisations</li>
</ul>

<h2>Conclusion</h2>
<p>La billetterie en ligne est devenue un outil indispensable pour tout organisateur d'événements sérieux. Avec Tikehub, vous disposez d'une solution complète, adaptée au marché africain, avec des paiements sécurisés via Moneroo et une gestion simplifiée de tous les aspects de vos événements.</p>

<p><strong>Prêt à simplifier votre billetterie ?</strong> <a href="/register">Rejoignez Tikehub dès aujourd'hui</a> et découvrez comment nous pouvons transformer la gestion de vos événements !</p>
HTML;
    }

    private function getArticle3Content(): string
    {
        return <<<'HTML'
<h2>Introduction</h2>
<p>L'Afrique connaît une révolution numérique sans précédent, particulièrement dans le domaine des paiements mobiles. Avec l'intégration de Moneroo sur Tikehub, les organisateurs d'événements peuvent désormais offrir à leurs participants des solutions de paiement adaptées au marché africain. Découvrez comment cette technologie transforme l'industrie des événements.</p>

<h2>1. La révolution des paiements mobiles en Afrique</h2>
<h3>1.1 Le contexte africain</h3>
<p>L'Afrique présente des spécificités uniques en matière de paiements :</p>
<ul>
    <li><strong>Penetration mobile élevée</strong> : Plus de 80% de la population possède un téléphone mobile</li>
    <li><strong>Bancarisation limitée</strong> : Seulement 43% de la population a accès aux services bancaires traditionnels</li>
    <li><strong>Mobile money dominant</strong> : Le mobile money est devenu la principale méthode de paiement</li>
    <li><strong>Croissance rapide</strong> : Le marché des paiements mobiles croît de 20% par an</li>
</ul>

<h3>1.2 Les solutions de paiement populaires</h3>
<p>En Afrique de l'Ouest, plusieurs solutions dominent :</p>
<ul>
    <li><strong>Mobile Money</strong> : MTN Mobile Money, Orange Money, Moov Money</li>
    <li><strong>Cartes bancaires</strong> : Visa, Mastercard (croissance rapide)</li>
    <li><strong>Portefeuilles électroniques</strong> : Solutions locales et internationales</li>
</ul>

<h2>2. Moneroo : la solution de paiement pour l'Afrique</h2>
<h3>2.1 Qu'est-ce que Moneroo ?</h3>
<p>Moneroo est une plateforme de paiement panafricaine qui permet aux entreprises d'accepter des paiements via :</p>
<ul>
    <li>Mobile Money (MTN, Orange, Moov, etc.)</li>
    <li>Cartes bancaires (Visa, Mastercard)</li>
    <li>Portefeuilles électroniques</li>
    <li>Virements bancaires</li>
</ul>

<h3>2.2 Avantages de Moneroo</h3>
<p>Pour les organisateurs d'événements, Moneroo offre :</p>
<ul>
    <li><strong>Multiples méthodes de paiement</strong> : Acceptez tous les types de paiements</li>
    <li><strong>Sécurité renforcée</strong> : Transactions cryptées et sécurisées</li>
    <li><strong>Paiements instantanés</strong> : Réception immédiate des fonds</li>
    <li><strong>Interface simple</strong> : Intégration facile avec Tikehub</li>
    <li><strong>Support local</strong> : Équipe dédiée pour l'Afrique</li>
</ul>

<h2>3. Intégration Moneroo sur Tikehub</h2>
<h3>3.1 Configuration simple</h3>
<p>Intégrer Moneroo sur Tikehub est très simple :</p>
<ol>
    <li>Créez votre compte Moneroo</li>
    <li>Récupérez vos clés API</li>
    <li>Configurez Moneroo dans les paramètres Tikehub</li>
    <li>Activez les méthodes de paiement souhaitées</li>
    <li>C'est prêt ! Vos participants peuvent maintenant payer</li>
</ol>

<h3>3.2 Expérience utilisateur optimisée</h3>
<p>Vos participants bénéficient d'une expérience optimale :</p>
<ul>
    <li>Interface de paiement intuitive</li>
    <li>Choix de la méthode de paiement préférée</li>
    <li>Confirmation instantanée</li>
    <li>Reçu électronique automatique</li>
</ul>

<h2>4. Impact sur les événements en Afrique</h2>
<h3>4.1 Augmentation des ventes</h3>
<p>Les paiements mobiles ont un impact direct sur les ventes :</p>
<ul>
    <li><strong>+35% de conversion</strong> : Les participants préfèrent payer avec leur mobile</li>
    <li><strong>Ventes 24/7</strong> : Plus de contraintes horaires</li>
    <li><strong>Accessibilité</strong> : Plus de personnes peuvent participer</li>
</ul>

<h3>4.2 Réduction des coûts</h3>
<p>Les paiements numériques réduisent les coûts :</p>
<ul>
    <li>Moins de gestion de cash</li>
    <li>Réduction des risques de vol</li>
    <li>Automatisation des processus</li>
    <li>Commissions transparentes</li>
</ul>

<h2>5. Tendances et avenir</h2>
<h3>5.1 Évolution du marché</h3>
<p>Le marché des paiements en Afrique évolue rapidement :</p>
<ul>
    <li>Croissance continue du mobile money</li>
    <li>Adoption croissante des cartes bancaires</li>
    <li>Émergence de nouvelles solutions (cryptomonnaies, blockchain)</li>
    <li>Intégration avec les plateformes e-commerce</li>
</ul>

<h3>5.2 Innovations à venir</h3>
<p>Les innovations futures incluent :</p>
<ul>
    <li>Paiements par QR code</li>
    <li>Paiements vocaux</li>
    <li>Intelligence artificielle pour la détection de fraude</li>
    <li>Blockchain pour la transparence</li>
</ul>

<h2>6. Conseils pour optimiser vos paiements</h2>
<h3>6.1 Offrir plusieurs options</h3>
<p>Proposez toujours plusieurs méthodes de paiement :</p>
<ul>
    <li>Mobile Money (essentiel en Afrique)</li>
    <li>Cartes bancaires (pour les participants internationaux)</li>
    <li>Paiement en plusieurs fois (si disponible)</li>
</ul>

<h3>6.2 Communication claire</h3>
<p>Informez vos participants des méthodes acceptées :</p>
<ul>
    <li>Indiquez clairement sur votre page d'événement</li>
    <li>Envoyez des rappels par email</li>
    <li>Répondez aux questions rapidement</li>
</ul>

<h2>Conclusion</h2>
<p>L'intégration de Moneroo sur Tikehub représente une véritable révolution pour les événements en Afrique. En offrant des solutions de paiement adaptées au marché local, nous permettons à plus de personnes de participer aux événements et facilitons la vie des organisateurs.</p>

<p>La combinaison de Tikehub et Moneroo crée un écosystème complet pour l'industrie des événements en Afrique, où technologie, accessibilité et sécurité se rencontrent pour offrir la meilleure expérience possible.</p>

<p><strong>Prêt à révolutionner vos paiements d'événements ?</strong> <a href="/register">Rejoignez Tikehub</a> et découvrez comment Moneroo peut transformer votre façon de gérer les paiements !</p>
HTML;
    }
}

