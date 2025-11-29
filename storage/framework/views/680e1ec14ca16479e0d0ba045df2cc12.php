<?php $__env->startSection('title', 'Accueil - Tikehub'); ?>

<?php $__env->startSection('content'); ?>
<!-- Hero Section -->
<section class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-5xl md:text-6xl font-bold mb-6">
                Organisez vos événements<br>
                <span class="text-yellow-300">en toute simplicité</span>
            </h1>
            <p class="text-xl md:text-2xl mb-8 text-indigo-100">
                La plateforme complète pour créer, gérer et vendre des billets pour vos événements
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="<?php echo e(route('events.index')); ?>" class="bg-white text-indigo-600 px-8 py-4 rounded-lg font-semibold text-lg hover:bg-indigo-50 transition duration-300 shadow-lg">
                    Découvrir les événements
                </a>
                <?php if(auth()->guard()->check()): ?>
                    <a href="<?php echo e(route('dashboard')); ?>" class="bg-indigo-700 text-white px-8 py-4 rounded-lg font-semibold text-lg hover:bg-indigo-800 transition duration-300 border-2 border-white">
                        Mon tableau de bord
                    </a>
                <?php else: ?>
                    <a href="<?php echo e(route('register')); ?>" class="bg-indigo-700 text-white px-8 py-4 rounded-lg font-semibold text-lg hover:bg-indigo-800 transition duration-300 border-2 border-white">
                        Créer un compte
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<!-- Statistiques -->
<section class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-8 text-center">
            <div class="bg-white p-4 md:p-6 rounded-lg shadow-md">
                <div class="text-3xl md:text-4xl font-bold text-indigo-600 mb-2"><?php echo e($stats['total_events']); ?></div>
                <div class="text-sm md:text-base text-gray-600">Événements</div>
            </div>
            <div class="bg-white p-4 md:p-6 rounded-lg shadow-md">
                <div class="text-3xl md:text-4xl font-bold text-purple-600 mb-2"><?php echo e($stats['active_contests']); ?></div>
                <div class="text-sm md:text-base text-gray-600">Concours actifs</div>
            </div>
            <div class="bg-white p-4 md:p-6 rounded-lg shadow-md">
                <div class="text-3xl md:text-4xl font-bold text-green-600 mb-2"><?php echo e($stats['active_fundraisings']); ?></div>
                <div class="text-sm md:text-base text-gray-600">Collectes actives</div>
            </div>
            <div class="bg-white p-4 md:p-6 rounded-lg shadow-md">
                <div class="text-3xl md:text-4xl font-bold text-yellow-600 mb-2">100%</div>
                <div class="text-sm md:text-base text-gray-600">Sécurisé</div>
            </div>
        </div>
    </div>
</section>

<!-- Fonctionnalités -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-center mb-12 text-gray-800">Pourquoi choisir Tikehub ?</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="text-center">
                <div class="bg-indigo-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-ticket-alt text-3xl text-indigo-600"></i>
                </div>
                <h3 class="text-xl font-semibold mb-2">Billetterie sécurisée</h3>
                <p class="text-gray-600">QR codes uniques, billets numériques et physiques, tout en sécurité</p>
            </div>
            <div class="text-center">
                <div class="bg-purple-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-mobile-alt text-3xl text-purple-600"></i>
                </div>
                <h3 class="text-xl font-semibold mb-2">Mobile-first</h3>
                <p class="text-gray-600">Interface optimisée pour mobile, accessible partout</p>
            </div>
            <div class="text-center">
                <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-credit-card text-3xl text-green-600"></i>
                </div>
                <h3 class="text-xl font-semibold mb-2">Paiements faciles</h3>
                <p class="text-gray-600">Intégration Moneroo pour des paiements rapides et sécurisés</p>
            </div>
            <div class="text-center">
                <div class="bg-yellow-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-chart-line text-3xl text-yellow-600"></i>
                </div>
                <h3 class="text-xl font-semibold mb-2">Rapports détaillés</h3>
                <p class="text-gray-600">Suivez vos ventes et performances en temps réel</p>
            </div>
        </div>
    </div>
</section>

<!-- Événements à venir -->
<?php if($upcomingEvents->count() > 0): ?>
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-bold text-gray-800">Événements à venir</h2>
            <a href="<?php echo e(route('events.index')); ?>" class="text-indigo-600 hover:text-indigo-800 font-semibold">
                Voir tout <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php $__currentLoopData = $upcomingEvents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(route('events.show', $event)); ?>" class="block bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition duration-300">
                    <?php if($event->cover_image): ?>
                        <img src="<?php echo e(asset('storage/' . $event->cover_image)); ?>" alt="<?php echo e($event->title); ?>" class="w-full h-48 object-cover">
                    <?php else: ?>
                        <div class="w-full h-48 bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center">
                            <i class="fas fa-calendar-alt text-6xl text-white opacity-50"></i>
                        </div>
                    <?php endif; ?>
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-2">
                            <span class="bg-indigo-100 text-indigo-800 text-xs font-semibold px-3 py-1 rounded-full">
                                <?php echo e($event->category); ?>

                            </span>
                            <div class="flex gap-2">
                                <?php if($event->is_virtual): ?>
                                    <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-3 py-1 rounded-full">
                                        <i class="fas fa-video mr-1"></i>Virtuel
                                    </span>
                                <?php endif; ?>
                                <?php if($event->is_free): ?>
                                    <span class="bg-green-100 text-green-800 text-xs font-semibold px-3 py-1 rounded-full">
                                        Gratuit
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <h3 class="text-xl font-semibold mb-2 text-gray-800 hover:text-indigo-600 transition"><?php echo e($event->title); ?></h3>
                        <p class="text-gray-600 text-sm mb-4 line-clamp-2"><?php echo e(\Illuminate\Support\Str::limit($event->description, 100)); ?></p>
                        <div class="flex items-center text-sm text-gray-500 mb-4">
                            <i class="fas fa-calendar mr-2"></i>
                            <span><?php echo e($event->start_date->translatedFormat('d/m/Y H:i')); ?></span>
                            <?php if($event->venue_city): ?>
                                <span class="mx-2">•</span>
                                <i class="fas fa-map-marker-alt mr-2"></i>
                                <span><?php echo e($event->venue_city); ?></span>
                            <?php endif; ?>
                        </div>
                        <span class="block w-full bg-indigo-600 text-white text-center px-4 py-2 rounded-lg hover:bg-indigo-700 transition duration-300">
                            Voir l'événement
                        </span>
                    </div>
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Événements populaires -->
<?php if($popularEvents->count() > 0): ?>
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-bold text-gray-800">Événements populaires</h2>
            <a href="<?php echo e(route('events.index')); ?>" class="text-indigo-600 hover:text-indigo-800 font-semibold">
                Voir tout <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php $__currentLoopData = $popularEvents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition duration-300 border-2 border-yellow-200">
                    <a href="<?php echo e(route('events.show', $event)); ?>" class="block">
                        <?php if($event->cover_image): ?>
                            <img src="<?php echo e(asset('storage/' . $event->cover_image)); ?>" alt="<?php echo e($event->title ?? 'Événement'); ?>" class="w-full h-48 object-cover">
                        <?php else: ?>
                            <div class="w-full h-48 bg-gradient-to-br from-yellow-400 to-orange-500 flex items-center justify-center">
                                <i class="fas fa-fire text-6xl text-white opacity-50"></i>
                            </div>
                        <?php endif; ?>
                    </a>
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-2">
                            <span class="bg-yellow-100 text-yellow-800 text-xs font-semibold px-3 py-1 rounded-full">
                                <i class="fas fa-fire mr-1"></i> Populaire
                            </span>
                            <div class="flex items-center gap-2">
                                <?php if($event->is_virtual): ?>
                                    <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-3 py-1 rounded-full">
                                        <i class="fas fa-video mr-1"></i>Virtuel
                                    </span>
                                <?php endif; ?>
                                <span class="text-sm text-gray-500">
                                    <?php echo e($event->tickets_count ?? 0); ?> billet(s) vendu(s)
                                </span>
                            </div>
                        </div>
                        <a href="<?php echo e(route('events.show', $event)); ?>" class="block">
                            <h3 class="text-xl font-semibold mb-2 text-gray-800 hover:text-indigo-600 transition"><?php echo e($event->title ?? 'Sans titre'); ?></h3>
                        </a>
                        <?php if($event->description): ?>
                            <p class="text-gray-600 text-sm mb-2 line-clamp-2"><?php echo e(\Illuminate\Support\Str::limit($event->description, 100)); ?></p>
                        <?php endif; ?>
                        <?php if($event->start_date): ?>
                            <div class="flex items-center text-sm text-gray-500 mb-2">
                                <i class="fas fa-calendar mr-2"></i>
                                <span><?php echo e($event->start_date->translatedFormat('d/m/Y H:i')); ?></span>
                                <?php if($event->venue_city): ?>
                                    <span class="mx-2">•</span>
                                    <i class="fas fa-map-marker-alt mr-2"></i>
                                    <span><?php echo e($event->venue_city); ?></span>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                        <?php if($event->organizer): ?>
                            <div class="flex items-center text-sm text-gray-600 mb-2">
                                <i class="fas fa-user-circle mr-2 text-indigo-600"></i>
                                <span>Par</span>
                                <a href="<?php echo e(route('organizer.profile.show', $event->organizer)); ?>" class="ml-1 text-indigo-600 hover:text-indigo-800 font-semibold hover:underline" onclick="event.stopPropagation()">
                                    <?php echo e($event->organizer->name); ?>

                                </a>
                            </div>
                        <?php endif; ?>
                        <?php
                            $minPrice = $event->ticketTypes()->where('is_active', true)->min('price') ?? 0;
                        ?>
                        <?php if($minPrice > 0): ?>
                            <div class="mb-4">
                                <span class="text-lg font-bold text-indigo-600">
                                    À partir de <?php echo e(number_format($minPrice, 0, ',', ' ')); ?> XOF
                                </span>
                            </div>
                        <?php elseif($event->is_free): ?>
                            <div class="mb-4">
                                <span class="text-lg font-bold text-green-600">
                                    Gratuit
                                </span>
                            </div>
                        <?php endif; ?>
                        <a href="<?php echo e(route('events.show', $event)); ?>" class="block w-full bg-indigo-600 text-white text-center px-4 py-2 rounded-lg hover:bg-indigo-700 transition duration-300">
                            Voir l'événement
                        </a>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- CTA Section -->
<section class="py-16 bg-gradient-to-r from-indigo-600 to-purple-600 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl md:text-4xl font-bold mb-4">Prêt à organiser votre événement ?</h2>
        <p class="text-xl mb-8 text-indigo-100">Rejoignez des milliers d'organisateurs qui font confiance à Tikehub</p>
        <?php if(auth()->guard()->check()): ?>
            <?php if(auth()->user()->isOrganizer()): ?>
                <a href="<?php echo e(route('events.create')); ?>" class="bg-white text-indigo-600 px-8 py-4 rounded-lg font-semibold text-lg hover:bg-indigo-50 transition duration-300 shadow-lg inline-block">
                    Créer un événement
                </a>
            <?php else: ?>
                <a href="<?php echo e(route('events.index')); ?>" class="bg-white text-indigo-600 px-8 py-4 rounded-lg font-semibold text-lg hover:bg-indigo-50 transition duration-300 shadow-lg inline-block">
                    Découvrir les événements
                </a>
            <?php endif; ?>
        <?php else: ?>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="<?php echo e(route('register')); ?>" class="bg-white text-indigo-600 px-8 py-4 rounded-lg font-semibold text-lg hover:bg-indigo-50 transition duration-300 shadow-lg">
                    Créer un compte organisateur
                </a>
                <a href="<?php echo e(route('events.index')); ?>" class="bg-indigo-700 text-white px-8 py-4 rounded-lg font-semibold text-lg hover:bg-indigo-800 transition duration-300 border-2 border-white">
                    Voir les événements
                </a>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- Concours & Votes -->
<?php if($activeContests->count() > 0): ?>
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h2 class="text-3xl font-bold text-gray-800">Concours & Votes payants</h2>
                <p class="text-gray-600 mt-2">Participez aux concours et votez pour vos candidats favoris</p>
            </div>
            <a href="<?php echo e(route('contests.index')); ?>" class="text-indigo-600 hover:text-indigo-800 font-semibold">
                Voir tout <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php $__currentLoopData = $activeContests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $contest): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(route('contests.show', $contest)); ?>" class="block bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition duration-300 border-2 border-purple-200">
                    <?php if($contest->cover_image): ?>
                        <img src="<?php echo e(asset('storage/' . $contest->cover_image)); ?>" alt="<?php echo e($contest->name); ?>" class="w-full h-48 object-cover">
                    <?php else: ?>
                        <div class="w-full h-48 bg-gradient-to-br from-purple-400 to-pink-500 flex items-center justify-center">
                            <i class="fas fa-trophy text-6xl text-white opacity-50"></i>
                        </div>
                    <?php endif; ?>
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-2">
                            <span class="bg-purple-100 text-purple-800 text-xs font-semibold px-3 py-1 rounded-full">
                                <i class="fas fa-vote-yea mr-1"></i> Concours
                            </span>
                        </div>
                        <div class="mb-2">
                            <span class="text-lg font-bold text-purple-600">
                                À partir de <?php echo e(number_format($contest->price_per_vote, 0, ',', ' ')); ?> XOF/vote
                            </span>
                        </div>
                        <h3 class="text-xl font-semibold mb-2 text-gray-800 hover:text-purple-600 transition"><?php echo e($contest->name); ?></h3>
                        <p class="text-gray-600 text-sm mb-4 line-clamp-2"><?php echo e(\Illuminate\Support\Str::limit($contest->description, 100)); ?></p>
                        <div class="flex items-center text-sm text-gray-500 mb-4">
                            <i class="fas fa-calendar mr-2"></i>
                            <span>Jusqu'au <?php echo e($contest->end_date->format('d/m/Y')); ?></span>
                            <span class="mx-2">•</span>
                            <i class="fas fa-users mr-2"></i>
                            <span><?php echo e($contest->votes_count); ?> vote(s)</span>
                        </div>
                        <span class="block w-full bg-purple-600 text-white text-center px-4 py-2 rounded-lg hover:bg-purple-700 transition duration-300">
                            Voir le concours
                        </span>
                    </div>
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Collectes de fonds -->
<?php if($activeFundraisings->count() > 0): ?>
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h2 class="text-3xl font-bold text-gray-800">Collectes de fonds</h2>
                <p class="text-gray-600 mt-2">Soutenez des causes qui vous tiennent à cœur</p>
            </div>
            <a href="<?php echo e(route('fundraisings.index')); ?>" class="text-indigo-600 hover:text-indigo-800 font-semibold">
                Voir tout <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php $__currentLoopData = $activeFundraisings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fundraising): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(route('fundraisings.show', $fundraising)); ?>" class="block bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition duration-300 border-2 border-green-200">
                    <?php if($fundraising->cover_image): ?>
                        <img src="<?php echo e(asset('storage/' . $fundraising->cover_image)); ?>" alt="<?php echo e($fundraising->name); ?>" class="w-full h-48 object-cover">
                    <?php else: ?>
                        <div class="w-full h-48 bg-gradient-to-br from-green-400 to-teal-500 flex items-center justify-center">
                            <i class="fas fa-heart text-6xl text-white opacity-50"></i>
                        </div>
                    <?php endif; ?>
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-2">
                            <span class="bg-green-100 text-green-800 text-xs font-semibold px-3 py-1 rounded-full">
                                <i class="fas fa-hand-holding-heart mr-1"></i> Collecte
                            </span>
                            <span class="text-sm text-gray-500">
                                <?php echo e(number_format($fundraising->progress_percentage, 0)); ?>%
                            </span>
                        </div>
                        <h3 class="text-xl font-semibold mb-2 text-gray-800 hover:text-green-600 transition"><?php echo e($fundraising->name); ?></h3>
                        <p class="text-gray-600 text-sm mb-4 line-clamp-2"><?php echo e(\Illuminate\Support\Str::limit($fundraising->description, 100)); ?></p>
                        
                        <!-- Barre de progression -->
                        <div class="mb-4">
                            <div class="flex justify-between text-xs text-gray-600 mb-1">
                                <span><?php echo e(number_format($fundraising->current_amount, 0, ',', ' ')); ?> XOF</span>
                                <span><?php echo e(number_format($fundraising->goal_amount, 0, ',', ' ')); ?> XOF</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-green-600 h-2 rounded-full" style="width: <?php echo e(min(100, $fundraising->progress_percentage)); ?>%"></div>
                            </div>
                        </div>

                        <div class="flex items-center text-sm text-gray-500 mb-4">
                            <i class="fas fa-calendar mr-2"></i>
                            <span>Jusqu'au <?php echo e($fundraising->end_date->format('d/m/Y')); ?></span>
                        </div>
                        <span class="block w-full bg-green-600 text-white text-center px-4 py-2 rounded-lg hover:bg-green-700 transition duration-300">
                            Contribuer
                        </span>
                    </div>
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Catégories -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-center mb-12 text-gray-800">Explorez par catégorie</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
            <?php
                $categories = ['Concert', 'Sport', 'Culture', 'Business', 'Éducation', 'Autre'];
            ?>
            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(route('events.index', ['category' => $category])); ?>" class="bg-white p-6 rounded-lg shadow-md hover:shadow-xl transition duration-300 text-center group">
                    <div class="text-4xl mb-3 group-hover:scale-110 transition duration-300">
                        <?php if($category === 'Concert'): ?>
                            <i class="fas fa-music text-indigo-600"></i>
                        <?php elseif($category === 'Sport'): ?>
                            <i class="fas fa-futbol text-green-600"></i>
                        <?php elseif($category === 'Culture'): ?>
                            <i class="fas fa-theater-masks text-purple-600"></i>
                        <?php elseif($category === 'Business'): ?>
                            <i class="fas fa-briefcase text-blue-600"></i>
                        <?php elseif($category === 'Éducation'): ?>
                            <i class="fas fa-graduation-cap text-yellow-600"></i>
                        <?php else: ?>
                            <i class="fas fa-star text-gray-600"></i>
                        <?php endif; ?>
                    </div>
                    <div class="font-semibold text-gray-800"><?php echo e($category); ?></div>
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\adoun\Music\Tikehub\resources\views/home.blade.php ENDPATH**/ ?>