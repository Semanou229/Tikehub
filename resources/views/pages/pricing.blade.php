@extends('layouts.app')

@section('title', 'Tarifs - Tikehub')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-indigo-50 via-white to-purple-50">
    <!-- Hero Section -->
    <section class="relative py-24 md:py-32 px-4 sm:px-6 lg:px-8 overflow-hidden bg-gradient-to-br from-indigo-50 via-white to-purple-50">
        <!-- Background decorative elements -->
        <div class="absolute top-0 left-0 w-72 h-72 bg-indigo-200/30 rounded-full blur-3xl -translate-x-1/2 -translate-y-1/2"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-purple-200/30 rounded-full blur-3xl translate-x-1/2 translate-y-1/2"></div>
        
        <div class="max-w-7xl mx-auto relative z-10">
            <div class="text-center">
                <!-- Badge -->
                <div class="inline-block mb-6">
                    <span class="bg-indigo-100 text-indigo-700 px-6 py-2 rounded-full text-sm font-bold uppercase tracking-wider">
                        💰 Tarification Simple
                    </span>
                </div>
                
                <h1 class="text-5xl md:text-6xl lg:text-7xl font-black text-gray-900 mb-6 leading-tight">
                    Des <span class="bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">Tarifs</span> Transparents
                </h1>
                
                <p class="text-xl md:text-2xl lg:text-3xl text-gray-600 max-w-4xl mx-auto mb-12 leading-relaxed">
                    Une commission simple et équitable pour vous permettre de réussir vos événements
                </p>
                
                <!-- Key points -->
                <div class="flex flex-wrap justify-center gap-6 md:gap-8 mt-12">
                    <div class="flex items-center space-x-3 bg-white/80 backdrop-blur-sm px-6 py-3 rounded-full shadow-lg border border-indigo-100">
                        <i class="fas fa-check-circle text-green-500 text-xl"></i>
                        <span class="font-semibold text-gray-800">Aucun frais caché</span>
                    </div>
                    <div class="flex items-center space-x-3 bg-white/80 backdrop-blur-sm px-6 py-3 rounded-full shadow-lg border border-indigo-100">
                        <i class="fas fa-check-circle text-green-500 text-xl"></i>
                        <span class="font-semibold text-gray-800">Transparence totale</span>
                    </div>
                    <div class="flex items-center space-x-3 bg-white/80 backdrop-blur-sm px-6 py-3 rounded-full shadow-lg border border-indigo-100">
                        <i class="fas fa-check-circle text-green-500 text-xl"></i>
                        <span class="font-semibold text-gray-800">Paiement rapide</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Commission Highlight -->
    <section class="py-16 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="bg-gradient-to-br from-indigo-600 to-purple-600 rounded-3xl shadow-2xl p-8 md:p-12 text-white relative overflow-hidden">
                <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -mr-32 -mt-32"></div>
                <div class="absolute bottom-0 left-0 w-48 h-48 bg-white/10 rounded-full -ml-24 -mb-24"></div>
                
                <div class="relative z-10 text-center">
                    <div class="inline-block bg-white/20 backdrop-blur-sm rounded-2xl px-6 py-3 mb-6">
                        <span class="text-sm font-semibold uppercase tracking-wider">Taux de Commission</span>
                    </div>
                    
                    <div class="mb-8">
                        <div class="text-8xl md:text-9xl font-black mb-4">
                            {{ $commissionRate }}<span class="text-5xl md:text-6xl">%</span>
                        </div>
                        <p class="text-xl md:text-2xl font-medium opacity-90">
                            Seulement sur chaque vente réussie
                        </p>
                    </div>
                    
                    <div class="grid md:grid-cols-3 gap-6 mt-12 max-w-4xl mx-auto">
                        <div class="bg-white/10 backdrop-blur-sm rounded-xl p-6 border border-white/20">
                            <div class="text-3xl font-bold mb-2">0%</div>
                            <div class="text-sm opacity-90">Frais d'inscription</div>
                        </div>
                        <div class="bg-white/10 backdrop-blur-sm rounded-xl p-6 border border-white/20">
                            <div class="text-3xl font-bold mb-2">0 XOF</div>
                            <div class="text-sm opacity-90">Frais mensuels</div>
                        </div>
                        <div class="bg-white/10 backdrop-blur-sm rounded-xl p-6 border border-white/20">
                            <div class="text-3xl font-bold mb-2">0 XOF</div>
                            <div class="text-sm opacity-90">Frais cachés</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works -->
    <section class="py-16 px-4 sm:px-6 lg:px-8 bg-white">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
                    Comment ça fonctionne ?
                </h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Un système simple et transparent pour vous permettre de maximiser vos revenus
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-gradient-to-br from-indigo-50 to-indigo-100 rounded-2xl p-8 text-center transform hover:scale-105 transition-transform duration-300">
                    <div class="w-20 h-20 bg-indigo-600 rounded-full flex items-center justify-center mx-auto mb-6">
                        <span class="text-3xl font-bold text-white">1</span>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Créez votre événement</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Publiez votre événement gratuitement sur Tikehub. Aucun frais d'inscription, aucune limite.
                    </p>
                </div>

                <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-2xl p-8 text-center transform hover:scale-105 transition-transform duration-300">
                    <div class="w-20 h-20 bg-purple-600 rounded-full flex items-center justify-center mx-auto mb-6">
                        <span class="text-3xl font-bold text-white">2</span>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Vendez vos billets</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Les participants achètent directement sur la plateforme. Vous recevez les paiements automatiquement.
                    </p>
                </div>

                <div class="bg-gradient-to-br from-pink-50 to-pink-100 rounded-2xl p-8 text-center transform hover:scale-105 transition-transform duration-300">
                    <div class="w-20 h-20 bg-pink-600 rounded-full flex items-center justify-center mx-auto mb-6">
                        <span class="text-3xl font-bold text-white">3</span>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Recevez vos revenus</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Nous prélevons seulement {{ $commissionRate }}% de commission sur chaque vente. Le reste est pour vous !
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Details -->
    <section class="py-16 px-4 sm:px-6 lg:px-8 bg-gray-50">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
                    Détails des Tarifs
                </h2>
                <p class="text-xl text-gray-600">
                    Tout ce que vous devez savoir sur nos tarifs
                </p>
            </div>

            <div class="grid md:grid-cols-2 gap-8 max-w-5xl mx-auto">
                <!-- Commission Card -->
                <div class="bg-white rounded-2xl shadow-xl p-8 border-2 border-indigo-200">
                    <div class="flex items-center mb-6">
                        <div class="w-16 h-16 bg-indigo-600 rounded-xl flex items-center justify-center mr-4">
                            <i class="fas fa-percentage text-white text-2xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900">Commission</h3>
                    </div>
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                            <div>
                                <p class="font-semibold text-gray-900">Taux unique : {{ $commissionRate }}%</p>
                                <p class="text-sm text-gray-600">Appliqué uniquement sur les ventes réussies</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                            <div>
                                <p class="font-semibold text-gray-900">Pas de frais cachés</p>
                                <p class="text-sm text-gray-600">Ce que vous voyez est ce que vous payez</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                            <div>
                                <p class="font-semibold text-gray-900">Transparence totale</p>
                                <p class="text-sm text-gray-600">Tous les détails sont visibles avant la vente</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Withdrawal Card -->
                <div class="bg-white rounded-2xl shadow-xl p-8 border-2 border-purple-200">
                    <div class="flex items-center mb-6">
                        <div class="w-16 h-16 bg-purple-600 rounded-xl flex items-center justify-center mr-4">
                            <i class="fas fa-wallet text-white text-2xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900">Retraits</h3>
                    </div>
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                            <div>
                                <p class="font-semibold text-gray-900">Minimum : {{ number_format($minWithdrawal, 0, ',', ' ') }} XOF</p>
                                <p class="text-sm text-gray-600">Montant minimum pour effectuer un retrait</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                            <div>
                                <p class="font-semibold text-gray-900">Délai : {{ $withdrawalProcessingDays }} jours</p>
                                <p class="text-sm text-gray-600">Traitement rapide et sécurisé</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                            <div>
                                <p class="font-semibold text-gray-900">Sans frais supplémentaires</p>
                                <p class="text-sm text-gray-600">Aucun frais de retrait</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Example Calculation -->
    <section class="py-16 px-4 sm:px-6 lg:px-8 bg-white">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
                    Exemple de Calcul
                </h2>
                <p class="text-xl text-gray-600">
                    Voyez concrètement comment fonctionne notre commission
                </p>
            </div>

            <div class="bg-gradient-to-br from-indigo-50 to-purple-50 rounded-3xl p-8 md:p-12 border-2 border-indigo-200">
                <div class="space-y-6">
                    <div class="flex justify-between items-center pb-4 border-b-2 border-indigo-200">
                        <span class="text-lg font-semibold text-gray-700">Vente totale de billets</span>
                        <span class="text-2xl font-bold text-gray-900">100 000 XOF</span>
                    </div>
                    <div class="flex justify-between items-center pb-4 border-b-2 border-indigo-200">
                        <span class="text-lg font-semibold text-gray-700">Commission Tikehub ({{ $commissionRate }}%)</span>
                        <span class="text-2xl font-bold text-indigo-600">- {{ number_format(100000 * ($commissionRate / 100), 0, ',', ' ') }} XOF</span>
                    </div>
                    <div class="flex justify-between items-center pt-4">
                        <span class="text-xl font-bold text-gray-900">Votre revenu net</span>
                        <span class="text-3xl font-black text-green-600">{{ number_format(100000 * (1 - $commissionRate / 100), 0, ',', ' ') }} XOF</span>
                    </div>
                </div>

                <div class="mt-8 p-6 bg-white rounded-xl border-2 border-green-200">
                    <div class="flex items-start">
                        <i class="fas fa-lightbulb text-yellow-500 text-2xl mr-4 mt-1"></i>
                        <div>
                            <p class="font-bold text-gray-900 mb-2">💡 Astuce</p>
                            <p class="text-gray-700">
                                Avec {{ $commissionRate }}% de commission, vous gardez <strong>{{ 100 - $commissionRate }}%</strong> de vos ventes. 
                                Plus vous vendez, plus vous gagnez !
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Included -->
    <section class="py-16 px-4 sm:px-6 lg:px-8 bg-gradient-to-br from-gray-50 to-indigo-50">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
                    Tout est inclus dans la commission
                </h2>
                <p class="text-xl text-gray-600">
                    Aucun frais supplémentaire, tout ce dont vous avez besoin est inclus
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white rounded-xl p-6 shadow-lg text-center hover:shadow-xl transition-shadow">
                    <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-ticket-alt text-indigo-600 text-2xl"></i>
                    </div>
                    <h3 class="font-bold text-gray-900 mb-2">Gestion des billets</h3>
                    <p class="text-sm text-gray-600">Système complet de billetterie</p>
                </div>

                <div class="bg-white rounded-xl p-6 shadow-lg text-center hover:shadow-xl transition-shadow">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-credit-card text-purple-600 text-2xl"></i>
                    </div>
                    <h3 class="font-bold text-gray-900 mb-2">Paiements sécurisés</h3>
                    <p class="text-sm text-gray-600">Intégration Moneroo incluse</p>
                </div>

                <div class="bg-white rounded-xl p-6 shadow-lg text-center hover:shadow-xl transition-shadow">
                    <div class="w-16 h-16 bg-pink-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-qrcode text-pink-600 text-2xl"></i>
                    </div>
                    <h3 class="font-bold text-gray-900 mb-2">QR Codes</h3>
                    <p class="text-sm text-gray-600">Génération automatique</p>
                </div>

                <div class="bg-white rounded-xl p-6 shadow-lg text-center hover:shadow-xl transition-shadow">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-chart-line text-green-600 text-2xl"></i>
                    </div>
                    <h3 class="font-bold text-gray-900 mb-2">Statistiques</h3>
                    <p class="text-sm text-gray-600">Tableaux de bord détaillés</p>
                </div>

                <div class="bg-white rounded-xl p-6 shadow-lg text-center hover:shadow-xl transition-shadow">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-envelope text-blue-600 text-2xl"></i>
                    </div>
                    <h3 class="font-bold text-gray-900 mb-2">Notifications</h3>
                    <p class="text-sm text-gray-600">Emails automatiques</p>
                </div>

                <div class="bg-white rounded-xl p-6 shadow-lg text-center hover:shadow-xl transition-shadow">
                    <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-headset text-yellow-600 text-2xl"></i>
                    </div>
                    <h3 class="font-bold text-gray-900 mb-2">Support client</h3>
                    <p class="text-sm text-gray-600">Assistance 24/7</p>
                </div>

                <div class="bg-white rounded-xl p-6 shadow-lg text-center hover:shadow-xl transition-shadow">
                    <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-mobile-alt text-red-600 text-2xl"></i>
                    </div>
                    <h3 class="font-bold text-gray-900 mb-2">Application mobile</h3>
                    <p class="text-sm text-gray-600">Interface responsive</p>
                </div>

                <div class="bg-white rounded-xl p-6 shadow-lg text-center hover:shadow-xl transition-shadow">
                    <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-shield-alt text-indigo-600 text-2xl"></i>
                    </div>
                    <h3 class="font-bold text-gray-900 mb-2">Sécurité</h3>
                    <p class="text-sm text-gray-600">Protection des données</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 px-4 sm:px-6 lg:px-8 bg-gradient-to-r from-indigo-600 to-purple-600">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-4xl md:text-5xl font-black text-white mb-6">
                Prêt à démarrer ?
            </h2>
            <p class="text-xl text-indigo-100 mb-8 max-w-2xl mx-auto">
                Rejoignez des centaines d'organisateurs qui font confiance à Tikehub pour leurs événements
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                @auth
                    @if(auth()->user()->hasRole('organizer'))
                        <a href="{{ route('dashboard') }}" class="bg-white text-indigo-600 px-8 py-4 rounded-xl font-bold text-lg hover:bg-indigo-50 transition shadow-xl">
                            Accéder au Dashboard
                        </a>
                    @else
                        <a href="{{ route('events.create') }}" class="bg-white text-indigo-600 px-8 py-4 rounded-xl font-bold text-lg hover:bg-indigo-50 transition shadow-xl">
                            Créer mon premier événement
                        </a>
                    @endif
                @else
                    <a href="{{ route('register') }}" class="bg-white text-indigo-600 px-8 py-4 rounded-xl font-bold text-lg hover:bg-indigo-50 transition shadow-xl">
                        Créer un compte gratuit
                    </a>
                @endauth
                <a href="{{ route('contact') }}" class="bg-indigo-700 text-white px-8 py-4 rounded-xl font-bold text-lg hover:bg-indigo-800 transition border-2 border-white/20">
                    Nous contacter
                </a>
            </div>
        </div>
    </section>
</div>
@endsection

