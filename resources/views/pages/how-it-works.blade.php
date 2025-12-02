@extends('layouts.app')

@section('title', 'Comment ça marche - Tikehub')

@section('content')
<!-- Hero Section -->
<section class="py-16 bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-600 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl sm:text-5xl font-bold mb-4">Comment ça marche ?</h1>
        <p class="text-xl text-indigo-100 max-w-2xl mx-auto">
            Découvrez comment utiliser Tikehub pour créer des événements, organiser des concours ou lancer des collectes de fonds
        </p>
    </div>
</section>

<!-- Tabs Section -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Tabs Navigation -->
        <div class="flex justify-center mb-12">
            <div class="bg-gray-100 rounded-lg p-1 inline-flex gap-2">
                <button id="organizer-tab" class="tab-button active px-6 py-3 rounded-lg font-semibold transition-all duration-300 bg-white text-indigo-600 shadow-md" data-tab="organizer">
                    <i class="fas fa-user-tie mr-2"></i>Pour les Organisateurs
                </button>
                <button id="client-tab" class="tab-button px-6 py-3 rounded-lg font-semibold transition-all duration-300 text-gray-600 hover:text-indigo-600" data-tab="client">
                    <i class="fas fa-users mr-2"></i>Pour les Clients
                </button>
            </div>
        </div>

        <!-- Organizer Tab Content -->
        <div id="organizer-content" class="tab-content">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Step 1 -->
                <div class="step-card group bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border-l-4 border-indigo-500">
                    <div class="flex items-center mb-4">
                        <div class="bg-indigo-100 text-indigo-600 w-12 h-12 rounded-full flex items-center justify-center font-bold text-xl mr-4 group-hover:bg-indigo-600 group-hover:text-white transition">
                            1
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800">Créez votre compte</h3>
                    </div>
                    <p class="text-gray-600 leading-relaxed mb-4">
                        Inscrivez-vous gratuitement en tant qu'organisateur. Remplissez votre profil et vérifiez votre identité pour commencer.
                    </p>
                    <ul class="text-sm text-gray-600 space-y-2">
                        <li class="flex items-center"><i class="fas fa-check-circle text-indigo-500 mr-2"></i>Inscription gratuite</li>
                        <li class="flex items-center"><i class="fas fa-check-circle text-indigo-500 mr-2"></i>Vérification d'identité</li>
                        <li class="flex items-center"><i class="fas fa-check-circle text-indigo-500 mr-2"></i>Configuration du profil</li>
                    </ul>
                </div>

                <!-- Step 2 -->
                <div class="step-card group bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border-l-4 border-purple-500">
                    <div class="flex items-center mb-4">
                        <div class="bg-purple-100 text-purple-600 w-12 h-12 rounded-full flex items-center justify-center font-bold text-xl mr-4 group-hover:bg-purple-600 group-hover:text-white transition">
                            2
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800">Créez votre contenu</h3>
                    </div>
                    <p class="text-gray-600 leading-relaxed mb-4">
                        Créez un événement, un concours ou une collecte de fonds. Personnalisez tous les détails et configurez vos billets ou options de vote.
                    </p>
                    <ul class="text-sm text-gray-600 space-y-2">
                        <li class="flex items-center"><i class="fas fa-check-circle text-purple-500 mr-2"></i>Événements avec billetterie</li>
                        <li class="flex items-center"><i class="fas fa-check-circle text-purple-500 mr-2"></i>Concours avec votes payants</li>
                        <li class="flex items-center"><i class="fas fa-check-circle text-purple-500 mr-2"></i>Collectes de fonds</li>
                    </ul>
                </div>

                <!-- Step 3 -->
                <div class="step-card group bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border-l-4 border-green-500">
                    <div class="flex items-center mb-4">
                        <div class="bg-green-100 text-green-600 w-12 h-12 rounded-full flex items-center justify-center font-bold text-xl mr-4 group-hover:bg-green-600 group-hover:text-white transition">
                            3
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800">Publiez et partagez</h3>
                    </div>
                    <p class="text-gray-600 leading-relaxed mb-4">
                        Publiez votre contenu et partagez-le sur vos réseaux sociaux. Les participants peuvent maintenant acheter des billets ou voter.
                    </p>
                    <ul class="text-sm text-gray-600 space-y-2">
                        <li class="flex items-center"><i class="fas fa-check-circle text-green-500 mr-2"></i>Publication instantanée</li>
                        <li class="flex items-center"><i class="fas fa-check-circle text-green-500 mr-2"></i>Partage sur réseaux sociaux</li>
                        <li class="flex items-center"><i class="fas fa-check-circle text-green-500 mr-2"></i>Lien personnalisé</li>
                    </ul>
                </div>

                <!-- Step 4 -->
                <div class="step-card group bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border-l-4 border-yellow-500">
                    <div class="flex items-center mb-4">
                        <div class="bg-yellow-100 text-yellow-600 w-12 h-12 rounded-full flex items-center justify-center font-bold text-xl mr-4 group-hover:bg-yellow-600 group-hover:text-white transition">
                            4
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800">Gérez vos ventes</h3>
                    </div>
                    <p class="text-gray-600 leading-relaxed mb-4">
                        Suivez vos ventes en temps réel, gérez vos participants et scannez les billets le jour de l'événement.
                    </p>
                    <ul class="text-sm text-gray-600 space-y-2">
                        <li class="flex items-center"><i class="fas fa-check-circle text-yellow-500 mr-2"></i>Tableau de bord en temps réel</li>
                        <li class="flex items-center"><i class="fas fa-check-circle text-yellow-500 mr-2"></i>Scanner QR codes</li>
                        <li class="flex items-center"><i class="fas fa-check-circle text-yellow-500 mr-2"></i>Rapports détaillés</li>
                    </ul>
                </div>

                <!-- Step 5 -->
                <div class="step-card group bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border-l-4 border-red-500">
                    <div class="flex items-center mb-4">
                        <div class="bg-red-100 text-red-600 w-12 h-12 rounded-full flex items-center justify-center font-bold text-xl mr-4 group-hover:bg-red-600 group-hover:text-white transition">
                            5
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800">Recevez vos paiements</h3>
                    </div>
                    <p class="text-gray-600 leading-relaxed mb-4">
                        Retirez vos fonds facilement. Nous prélevons seulement {{ get_commission_rate() }}% de commission sur chaque vente.
                    </p>
                    <ul class="text-sm text-gray-600 space-y-2">
                        <li class="flex items-center"><i class="fas fa-check-circle text-red-500 mr-2"></i>Retraits sécurisés</li>
                        <li class="flex items-center"><i class="fas fa-check-circle text-red-500 mr-2"></i>Commission transparente</li>
                        <li class="flex items-center"><i class="fas fa-check-circle text-red-500 mr-2"></i>Historique des transactions</li>
                    </ul>
                </div>

                <!-- Step 6 -->
                <div class="step-card group bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border-l-4 border-blue-500">
                    <div class="flex items-center mb-4">
                        <div class="bg-blue-100 text-blue-600 w-12 h-12 rounded-full flex items-center justify-center font-bold text-xl mr-4 group-hover:bg-blue-600 group-hover:text-white transition">
                            6
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800">Utilisez le CRM</h3>
                    </div>
                    <p class="text-gray-600 leading-relaxed mb-4">
                        Gérez vos contacts, créez des campagnes email et automatisez votre marketing pour maximiser vos ventes.
                    </p>
                    <ul class="text-sm text-gray-600 space-y-2">
                        <li class="flex items-center"><i class="fas fa-check-circle text-blue-500 mr-2"></i>Gestion de contacts</li>
                        <li class="flex items-center"><i class="fas fa-check-circle text-blue-500 mr-2"></i>Campagnes email</li>
                        <li class="flex items-center"><i class="fas fa-check-circle text-blue-500 mr-2"></i>Automations marketing</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Client Tab Content -->
        <div id="client-content" class="tab-content hidden">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Step 1 -->
                <div class="step-card group bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border-l-4 border-indigo-500">
                    <div class="flex items-center mb-4">
                        <div class="bg-indigo-100 text-indigo-600 w-12 h-12 rounded-full flex items-center justify-center font-bold text-xl mr-4 group-hover:bg-indigo-600 group-hover:text-white transition">
                            1
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800">Explorez</h3>
                    </div>
                    <p class="text-gray-600 leading-relaxed mb-4">
                        Parcourez les événements, concours et collectes disponibles. Utilisez les filtres pour trouver ce qui vous intéresse.
                    </p>
                    <ul class="text-sm text-gray-600 space-y-2">
                        <li class="flex items-center"><i class="fas fa-check-circle text-indigo-500 mr-2"></i>Recherche par catégorie</li>
                        <li class="flex items-center"><i class="fas fa-check-circle text-indigo-500 mr-2"></i>Filtres avancés</li>
                        <li class="flex items-center"><i class="fas fa-check-circle text-indigo-500 mr-2"></i>Événements à venir</li>
                    </ul>
                </div>

                <!-- Step 2 -->
                <div class="step-card group bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border-l-4 border-purple-500">
                    <div class="flex items-center mb-4">
                        <div class="bg-purple-100 text-purple-600 w-12 h-12 rounded-full flex items-center justify-center font-bold text-xl mr-4 group-hover:bg-purple-600 group-hover:text-white transition">
                            2
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800">Choisissez</h3>
                    </div>
                    <p class="text-gray-600 leading-relaxed mb-4">
                        Sélectionnez l'événement, le concours ou la collecte qui vous intéresse. Consultez tous les détails avant de continuer.
                    </p>
                    <ul class="text-sm text-gray-600 space-y-2">
                        <li class="flex items-center"><i class="fas fa-check-circle text-purple-500 mr-2"></i>Détails complets</li>
                        <li class="flex items-center"><i class="fas fa-check-circle text-purple-500 mr-2"></i>Photos et descriptions</li>
                        <li class="flex items-center"><i class="fas fa-check-circle text-purple-500 mr-2"></i>Informations pratiques</li>
                    </ul>
                </div>

                <!-- Step 3 -->
                <div class="step-card group bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border-l-4 border-green-500">
                    <div class="flex items-center mb-4">
                        <div class="bg-green-100 text-green-600 w-12 h-12 rounded-full flex items-center justify-center font-bold text-xl mr-4 group-hover:bg-green-600 group-hover:text-white transition">
                            3
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800">Achetez ou participez</h3>
                    </div>
                    <p class="text-gray-600 leading-relaxed mb-4">
                        Achetez vos billets, votez pour un candidat ou contribuez à une collecte. Le paiement est sécurisé via Moneroo.
                    </p>
                    <ul class="text-sm text-gray-600 space-y-2">
                        <li class="flex items-center"><i class="fas fa-check-circle text-green-500 mr-2"></i>Paiement sécurisé</li>
                        <li class="flex items-center"><i class="fas fa-check-circle text-green-500 mr-2"></i>Mobile money accepté</li>
                        <li class="flex items-center"><i class="fas fa-check-circle text-green-500 mr-2"></i>Confirmation immédiate</li>
                    </ul>
                </div>

                <!-- Step 4 -->
                <div class="step-card group bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border-l-4 border-yellow-500">
                    <div class="flex items-center mb-4">
                        <div class="bg-yellow-100 text-yellow-600 w-12 h-12 rounded-full flex items-center justify-center font-bold text-xl mr-4 group-hover:bg-yellow-600 group-hover:text-white transition">
                            4
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800">Recevez vos billets</h3>
                    </div>
                    <p class="text-gray-600 leading-relaxed mb-4">
                        Recevez vos billets par email avec un QR code unique. Vous pouvez aussi les télécharger depuis votre compte.
                    </p>
                    <ul class="text-sm text-gray-600 space-y-2">
                        <li class="flex items-center"><i class="fas fa-check-circle text-yellow-500 mr-2"></i>Email de confirmation</li>
                        <li class="flex items-center"><i class="fas fa-check-circle text-yellow-500 mr-2"></i>QR code unique</li>
                        <li class="flex items-center"><i class="fas fa-check-circle text-yellow-500 mr-2"></i>Accès à votre compte</li>
                    </ul>
                </div>

                <!-- Step 5 -->
                <div class="step-card group bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border-l-4 border-red-500">
                    <div class="flex items-center mb-4">
                        <div class="bg-red-100 text-red-600 w-12 h-12 rounded-full flex items-center justify-center font-bold text-xl mr-4 group-hover:bg-red-600 group-hover:text-white transition">
                            5
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800">Participez</h3>
                    </div>
                    <p class="text-gray-600 leading-relaxed mb-4">
                        Le jour de l'événement, présentez votre QR code à l'entrée. Pour les concours, suivez les résultats en temps réel.
                    </p>
                    <ul class="text-sm text-gray-600 space-y-2">
                        <li class="flex items-center"><i class="fas fa-check-circle text-red-500 mr-2"></i>Scan QR code à l'entrée</li>
                        <li class="flex items-center"><i class="fas fa-check-circle text-red-500 mr-2"></i>Suivi en temps réel</li>
                        <li class="flex items-center"><i class="fas fa-check-circle text-red-500 mr-2"></i>Notifications</li>
                    </ul>
                </div>

                <!-- Step 6 -->
                <div class="step-card group bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border-l-4 border-blue-500">
                    <div class="flex items-center mb-4">
                        <div class="bg-blue-100 text-blue-600 w-12 h-12 rounded-full flex items-center justify-center font-bold text-xl mr-4 group-hover:bg-blue-600 group-hover:text-white transition">
                            6
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800">Gérez vos billets</h3>
                    </div>
                    <p class="text-gray-600 leading-relaxed mb-4">
                        Accédez à votre tableau de bord pour voir tous vos billets, vos participations aux concours et vos contributions.
                    </p>
                    <ul class="text-sm text-gray-600 space-y-2">
                        <li class="flex items-center"><i class="fas fa-check-circle text-blue-500 mr-2"></i>Historique complet</li>
                        <li class="flex items-center"><i class="fas fa-check-circle text-blue-500 mr-2"></i>Téléchargement PDF</li>
                        <li class="flex items-center"><i class="fas fa-check-circle text-blue-500 mr-2"></i>Support client</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- CTA Section -->
        <div class="mt-16 text-center">
            <h2 class="text-3xl font-bold text-gray-800 mb-4">Prêt à commencer ?</h2>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                @auth
                    @if(auth()->user()->isOrganizer())
                        <a href="{{ route('events.create') }}" class="bg-indigo-600 text-white px-8 py-4 rounded-lg font-semibold text-lg hover:bg-indigo-700 transition duration-300 shadow-lg">
                            <i class="fas fa-plus-circle mr-2"></i>Créer un événement
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="bg-indigo-600 text-white px-8 py-4 rounded-lg font-semibold text-lg hover:bg-indigo-700 transition duration-300 shadow-lg">
                            <i class="fas fa-user-plus mr-2"></i>Devenir organisateur
                        </a>
                    @endif
                @else
                    <a href="{{ route('register') }}" class="bg-indigo-600 text-white px-8 py-4 rounded-lg font-semibold text-lg hover:bg-indigo-700 transition duration-300 shadow-lg">
                        <i class="fas fa-user-plus mr-2"></i>Créer un compte
                    </a>
                @endauth
                <a href="{{ route('events.index') }}" class="bg-white text-indigo-600 px-8 py-4 rounded-lg font-semibold text-lg hover:bg-indigo-50 transition duration-300 border-2 border-indigo-600 shadow-lg">
                    <i class="fas fa-calendar-alt mr-2"></i>Voir les événements
                </a>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const organizerTab = document.getElementById('organizer-tab');
    const clientTab = document.getElementById('client-tab');
    const organizerContent = document.getElementById('organizer-content');
    const clientContent = document.getElementById('client-content');

    organizerTab.addEventListener('click', function() {
        organizerTab.classList.add('active', 'bg-white', 'text-indigo-600', 'shadow-md');
        organizerTab.classList.remove('text-gray-600');
        clientTab.classList.remove('active', 'bg-white', 'text-indigo-600', 'shadow-md');
        clientTab.classList.add('text-gray-600');
        
        organizerContent.classList.remove('hidden');
        clientContent.classList.add('hidden');
    });

    clientTab.addEventListener('click', function() {
        clientTab.classList.add('active', 'bg-white', 'text-indigo-600', 'shadow-md');
        clientTab.classList.remove('text-gray-600');
        organizerTab.classList.remove('active', 'bg-white', 'text-indigo-600', 'shadow-md');
        organizerTab.classList.add('text-gray-600');
        
        clientContent.classList.remove('hidden');
        organizerContent.classList.add('hidden');
    });
});
</script>
@endpush

@endsection

