

<?php $__env->startSection('title', 'Profil de ' . $organizer->name . ' - Tikehub'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header du profil -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 p-8">
            <div class="flex flex-col md:flex-row items-center md:items-start gap-6">
                <!-- Avatar -->
                <div class="flex-shrink-0">
                    <?php if($organizer->avatar): ?>
                        <img src="<?php echo e(asset('storage/' . $organizer->avatar)); ?>" alt="<?php echo e($organizer->name); ?>" class="w-32 h-32 rounded-full border-4 border-white shadow-lg object-cover">
                    <?php else: ?>
                        <div class="w-32 h-32 rounded-full border-4 border-white shadow-lg bg-white flex items-center justify-center">
                            <span class="text-4xl font-bold text-indigo-600"><?php echo e(strtoupper(substr($organizer->name, 0, 2))); ?></span>
                        </div>
                    <?php endif; ?>
                </div>
                
                <!-- Informations -->
                <div class="flex-1 text-center md:text-left text-white">
                    <h1 class="text-3xl md:text-4xl font-bold mb-2"><?php echo e($organizer->name); ?></h1>
                    <?php if($organizer->company_name): ?>
                        <p class="text-xl text-indigo-100 mb-2"><?php echo e($organizer->company_name); ?></p>
                    <?php endif; ?>
                    <?php if($organizer->bio): ?>
                        <p class="text-indigo-100 mb-4"><?php echo e($organizer->bio); ?></p>
                    <?php endif; ?>
                    
                    <!-- Statistiques -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-6">
                        <div class="bg-white/20 backdrop-blur-sm rounded-lg p-3">
                            <div class="text-2xl font-bold"><?php echo e($stats['total_events']); ?></div>
                            <div class="text-sm text-indigo-100">Événements</div>
                        </div>
                        <div class="bg-white/20 backdrop-blur-sm rounded-lg p-3">
                            <div class="text-2xl font-bold"><?php echo e($stats['total_contests']); ?></div>
                            <div class="text-sm text-indigo-100">Concours</div>
                        </div>
                        <div class="bg-white/20 backdrop-blur-sm rounded-lg p-3">
                            <div class="text-2xl font-bold"><?php echo e($stats['total_fundraisings']); ?></div>
                            <div class="text-sm text-indigo-100">Collectes</div>
                        </div>
                        <div class="bg-white/20 backdrop-blur-sm rounded-lg p-3">
                            <div class="text-2xl font-bold"><?php echo e($stats['total_tickets_sold']); ?></div>
                            <div class="text-sm text-indigo-100">Billets vendus</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Informations de contact -->
        <div class="p-6">
            <div class="flex flex-wrap items-center gap-6">
                <?php if($organizer->phone): ?>
                    <div class="flex items-center text-gray-700">
                        <i class="fas fa-phone text-indigo-600 mr-2"></i>
                        <span><?php echo e($organizer->phone); ?></span>
                    </div>
                <?php endif; ?>
                <?php if($organizer->email): ?>
                    <div class="flex items-center text-gray-700">
                        <i class="fas fa-envelope text-indigo-600 mr-2"></i>
                        <span><?php echo e($organizer->email); ?></span>
                    </div>
                <?php endif; ?>
                
                <!-- Réseaux sociaux -->
                <?php
                    $socialNetworks = [
                        'facebook' => ['url' => $organizer->facebook_url, 'icon' => 'fab fa-facebook-f', 'color' => 'text-blue-600'],
                        'twitter' => ['url' => $organizer->twitter_url, 'icon' => 'fab fa-twitter', 'color' => 'text-blue-400'],
                        'instagram' => ['url' => $organizer->instagram_url, 'icon' => 'fab fa-instagram', 'color' => 'text-pink-600'],
                        'linkedin' => ['url' => $organizer->linkedin_url, 'icon' => 'fab fa-linkedin-in', 'color' => 'text-blue-700'],
                        'youtube' => ['url' => $organizer->youtube_url, 'icon' => 'fab fa-youtube', 'color' => 'text-red-600'],
                        'website' => ['url' => $organizer->website_url, 'icon' => 'fas fa-globe', 'color' => 'text-gray-600'],
                    ];
                    $hasSocialNetworks = collect($socialNetworks)->filter(fn($network) => !empty($network['url']))->isNotEmpty();
                ?>
                
                <?php if($hasSocialNetworks): ?>
                    <div class="flex items-center gap-3">
                        <?php $__currentLoopData = $socialNetworks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $name => $network): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if(!empty($network['url'])): ?>
                                <a href="<?php echo e($network['url']); ?>" target="_blank" rel="noopener noreferrer" 
                                   class="w-10 h-10 rounded-full bg-gray-100 hover:bg-gray-200 flex items-center justify-center transition <?php echo e($network['color']); ?>"
                                   title="<?php echo e(ucfirst($name)); ?>">
                                    <i class="<?php echo e($network['icon']); ?>"></i>
                                </a>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Navigation par onglets -->
    <div class="bg-white rounded-lg shadow-md mb-6">
        <div class="border-b border-gray-200">
            <nav class="flex -mb-px">
                <button onclick="showTab('events')" id="tab-events" class="tab-button active px-6 py-4 text-sm font-medium text-indigo-600 border-b-2 border-indigo-600">
                    Événements
                </button>
                <button onclick="showTab('contests')" id="tab-contests" class="tab-button px-6 py-4 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">
                    Concours
                </button>
                <button onclick="showTab('fundraisings')" id="tab-fundraisings" class="tab-button px-6 py-4 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">
                    Collectes
                </button>
            </nav>
        </div>
    </div>

    <!-- Contenu des onglets -->
    <!-- Événements -->
    <div id="content-events" class="tab-content">
        <!-- Événements en cours -->
        <?php if($activeEvents->count() > 0): ?>
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Événements en cours</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php $__currentLoopData = $activeEvents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a href="<?php echo e(route('events.show', $event)); ?>" class="block bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition duration-300">
                            <?php if($event->cover_image): ?>
                                <img src="<?php echo e(asset('storage/' . $event->cover_image)); ?>" alt="<?php echo e($event->title); ?>" class="w-full h-48 object-cover">
                            <?php else: ?>
                                <div class="w-full h-48 bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center">
                                    <i class="fas fa-calendar-alt text-6xl text-white opacity-50"></i>
                                </div>
                            <?php endif; ?>
                            <div class="p-4">
                                <h3 class="text-lg font-semibold mb-2 text-gray-800 hover:text-indigo-600 transition"><?php echo e($event->title); ?></h3>
                                <div class="flex items-center text-sm text-gray-500 mb-2">
                                    <i class="fas fa-calendar mr-2"></i>
                                    <span><?php echo e($event->start_date->translatedFormat('d/m/Y H:i')); ?></span>
                                </div>
                                <?php
                                    $minPrice = $event->ticketTypes()->where('is_active', true)->min('price') ?? 0;
                                ?>
                                <?php if($minPrice > 0): ?>
                                    <div class="mb-2">
                                        <span class="text-sm font-bold text-indigo-600">
                                            À partir de <?php echo e(number_format($minPrice, 0, ',', ' ')); ?> XOF
                                        </span>
                                    </div>
                                <?php endif; ?>
                                <?php if($event->is_virtual): ?>
                                    <span class="inline-block px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800 mb-2">
                                        <i class="fas fa-video"></i> Virtuel
                                    </span>
                                <?php endif; ?>
                            </div>
                        </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- Événements terminés -->
        <?php if($pastEvents->count() > 0): ?>
            <div>
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Événements terminés</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php $__currentLoopData = $pastEvents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a href="<?php echo e(route('events.show', $event)); ?>" class="block bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition duration-300 opacity-75">
                            <?php if($event->cover_image): ?>
                                <img src="<?php echo e(asset('storage/' . $event->cover_image)); ?>" alt="<?php echo e($event->title); ?>" class="w-full h-48 object-cover">
                            <?php else: ?>
                                <div class="w-full h-48 bg-gradient-to-br from-gray-400 to-gray-500 flex items-center justify-center">
                                    <i class="fas fa-calendar-alt text-6xl text-white opacity-50"></i>
                                </div>
                            <?php endif; ?>
                            <div class="p-4">
                                <h3 class="text-lg font-semibold mb-2 text-gray-800"><?php echo e($event->title); ?></h3>
                                <div class="flex items-center text-sm text-gray-500">
                                    <i class="fas fa-calendar mr-2"></i>
                                    <span><?php echo e($event->start_date->translatedFormat('d/m/Y')); ?></span>
                                </div>
                                <span class="inline-block mt-2 px-2 py-1 text-xs font-semibold rounded-full bg-gray-200 text-gray-700">
                                    Terminé
                                </span>
                            </div>
                        </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        <?php endif; ?>

        <?php if($activeEvents->count() == 0 && $pastEvents->count() == 0): ?>
            <div class="bg-white rounded-lg shadow-md p-12 text-center">
                <i class="fas fa-calendar-times text-6xl text-gray-300 mb-4"></i>
                <p class="text-gray-500">Aucun événement disponible</p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Concours -->
    <div id="content-contests" class="tab-content hidden">
        <!-- Concours en cours -->
        <?php if($activeContests->count() > 0): ?>
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Concours en cours</h2>
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
                            <div class="p-4">
                                <h3 class="text-lg font-semibold mb-2 text-gray-800 hover:text-purple-600 transition"><?php echo e($contest->name); ?></h3>
                                <div class="mb-2">
                                    <span class="text-sm font-bold text-purple-600">
                                        À partir de <?php echo e(number_format($contest->price_per_vote, 0, ',', ' ')); ?> XOF/vote
                                    </span>
                                </div>
                                <div class="flex items-center text-sm text-gray-500">
                                    <i class="fas fa-users mr-2"></i>
                                    <span><?php echo e($contest->votes_count); ?> vote(s)</span>
                                </div>
                            </div>
                        </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- Concours terminés -->
        <?php if($pastContests->count() > 0): ?>
            <div>
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Concours terminés</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php $__currentLoopData = $pastContests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $contest): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a href="<?php echo e(route('contests.show', $contest)); ?>" class="block bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition duration-300 opacity-75">
                            <?php if($contest->cover_image): ?>
                                <img src="<?php echo e(asset('storage/' . $contest->cover_image)); ?>" alt="<?php echo e($contest->name); ?>" class="w-full h-48 object-cover">
                            <?php else: ?>
                                <div class="w-full h-48 bg-gradient-to-br from-gray-400 to-gray-500 flex items-center justify-center">
                                    <i class="fas fa-trophy text-6xl text-white opacity-50"></i>
                                </div>
                            <?php endif; ?>
                            <div class="p-4">
                                <h3 class="text-lg font-semibold mb-2 text-gray-800"><?php echo e($contest->name); ?></h3>
                                <span class="inline-block px-2 py-1 text-xs font-semibold rounded-full bg-gray-200 text-gray-700">
                                    Terminé
                                </span>
                            </div>
                        </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        <?php endif; ?>

        <?php if($activeContests->count() == 0 && $pastContests->count() == 0): ?>
            <div class="bg-white rounded-lg shadow-md p-12 text-center">
                <i class="fas fa-trophy text-6xl text-gray-300 mb-4"></i>
                <p class="text-gray-500">Aucun concours disponible</p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Collectes -->
    <div id="content-fundraisings" class="tab-content hidden">
        <!-- Collectes en cours -->
        <?php if($activeFundraisings->count() > 0): ?>
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Collectes en cours</h2>
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
                            <div class="p-4">
                                <h3 class="text-lg font-semibold mb-2 text-gray-800 hover:text-green-600 transition"><?php echo e($fundraising->name); ?></h3>
                                <div class="mb-2">
                                    <div class="flex justify-between text-xs text-gray-600 mb-1">
                                        <span><?php echo e(number_format($fundraising->current_amount, 0, ',', ' ')); ?> XOF</span>
                                        <span><?php echo e(number_format($fundraising->goal_amount, 0, ',', ' ')); ?> XOF</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="bg-green-600 h-2 rounded-full" style="width: <?php echo e(min(100, $fundraising->progress_percentage)); ?>%"></div>
                                    </div>
                                </div>
                                <span class="text-sm text-gray-600"><?php echo e(number_format($fundraising->progress_percentage, 1)); ?>% atteint</span>
                            </div>
                        </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- Collectes terminées -->
        <?php if($pastFundraisings->count() > 0): ?>
            <div>
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Collectes terminées</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php $__currentLoopData = $pastFundraisings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fundraising): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a href="<?php echo e(route('fundraisings.show', $fundraising)); ?>" class="block bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition duration-300 opacity-75">
                            <?php if($fundraising->cover_image): ?>
                                <img src="<?php echo e(asset('storage/' . $fundraising->cover_image)); ?>" alt="<?php echo e($fundraising->name); ?>" class="w-full h-48 object-cover">
                            <?php else: ?>
                                <div class="w-full h-48 bg-gradient-to-br from-gray-400 to-gray-500 flex items-center justify-center">
                                    <i class="fas fa-heart text-6xl text-white opacity-50"></i>
                                </div>
                            <?php endif; ?>
                            <div class="p-4">
                                <h3 class="text-lg font-semibold mb-2 text-gray-800"><?php echo e($fundraising->name); ?></h3>
                                <span class="inline-block px-2 py-1 text-xs font-semibold rounded-full bg-gray-200 text-gray-700">
                                    Terminé
                                </span>
                            </div>
                        </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        <?php endif; ?>

        <?php if($activeFundraisings->count() == 0 && $pastFundraisings->count() == 0): ?>
            <div class="bg-white rounded-lg shadow-md p-12 text-center">
                <i class="fas fa-heart text-6xl text-gray-300 mb-4"></i>
                <p class="text-gray-500">Aucune collecte disponible</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
function showTab(tabName) {
    // Masquer tous les contenus
    document.querySelectorAll('.tab-content').forEach(content => {
        content.classList.add('hidden');
    });
    
    // Désactiver tous les onglets
    document.querySelectorAll('.tab-button').forEach(button => {
        button.classList.remove('active', 'text-indigo-600', 'border-indigo-600');
        button.classList.add('text-gray-500');
    });
    
    // Afficher le contenu sélectionné
    document.getElementById('content-' + tabName).classList.remove('hidden');
    
    // Activer l'onglet sélectionné
    const activeButton = document.getElementById('tab-' + tabName);
    activeButton.classList.add('active', 'text-indigo-600', 'border-b-2', 'border-indigo-600');
    activeButton.classList.remove('text-gray-500');
}
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\adoun\Music\Tikehub\resources\views/organizer/profile.blade.php ENDPATH**/ ?>