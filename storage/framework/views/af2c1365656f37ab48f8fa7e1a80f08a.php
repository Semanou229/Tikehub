

<?php $__env->startSection('title', $contest->name . ' - Tikehub'); ?>

<?php $__env->startSection('content'); ?>
<!-- Hero Section -->
<section class="relative">
    <?php if($contest->cover_image): ?>
        <div class="h-96 bg-cover bg-center" style="background-image: url('<?php echo e(asset('storage/' . $contest->cover_image)); ?>')">
            <div class="absolute inset-0 bg-black bg-opacity-50"></div>
        </div>
    <?php else: ?>
        <div class="h-96 bg-gradient-to-r from-purple-600 to-pink-600">
            <div class="absolute inset-0 bg-black bg-opacity-30"></div>
        </div>
    <?php endif; ?>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 text-white">
        <div class="flex items-center gap-2 mb-4">
            <span class="bg-purple-600 px-4 py-1 rounded-full text-sm font-semibold">
                <i class="fas fa-trophy mr-1"></i>Concours
            </span>
            <?php if($contest->isActive()): ?>
                <span class="bg-green-600 px-4 py-1 rounded-full text-sm font-semibold">Actif</span>
            <?php else: ?>
                <span class="bg-gray-600 px-4 py-1 rounded-full text-sm font-semibold">Terminé</span>
            <?php endif; ?>
        </div>
        <h1 class="text-4xl md:text-5xl font-bold mb-4"><?php echo e($contest->name); ?></h1>
        <div class="flex flex-wrap gap-6 text-lg">
            <div class="flex items-center">
                <i class="fas fa-calendar-alt mr-2"></i>
                <span>Du <?php echo e($contest->start_date->format('d/m/Y')); ?> au <?php echo e($contest->end_date->format('d/m/Y')); ?></span>
            </div>
            <div class="flex items-center">
                <i class="fas fa-coins mr-2"></i>
                <span><?php echo e(number_format($contest->price_per_vote, 0, ',', ' ')); ?> XOF par vote</span>
            </div>
            <div class="flex items-center">
                <i class="fas fa-users mr-2"></i>
                <span><?php echo e($contest->votes()->sum('points')); ?> vote(s) total</span>
            </div>
        </div>
    </div>
</section>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Contenu principal -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Description -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-2xl font-bold mb-4">À propos du concours</h2>
                <div class="prose max-w-none">
                    <?php echo nl2br(e($contest->description)); ?>

                </div>
            </div>

            <!-- Règles -->
            <?php if($contest->rules): ?>
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-2xl font-bold mb-4">Règles du concours</h2>
                    <div class="prose max-w-none">
                        <?php echo nl2br(e($contest->rules)); ?>

                    </div>
                </div>
            <?php endif; ?>

            <!-- Classement -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-2xl font-bold mb-4">Classement</h2>
                <?php if($ranking && $ranking->count() > 0): ?>
                    <div class="space-y-4">
                        <?php $__currentLoopData = $ranking; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $candidate): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $totalVotes = $candidate->votes_sum_points ?? 0;
                                $position = $index + 1;
                            ?>
                            <div class="flex items-center p-4 border-2 rounded-lg <?php echo e($position <= 3 ? 'border-yellow-400 bg-yellow-50' : 'border-gray-200'); ?>">
                                <div class="flex-shrink-0 w-12 h-12 flex items-center justify-center rounded-full font-bold text-lg
                                    <?php echo e($position === 1 ? 'bg-yellow-400 text-yellow-900' : ($position === 2 ? 'bg-gray-300 text-gray-800' : ($position === 3 ? 'bg-orange-300 text-orange-900' : 'bg-gray-200 text-gray-600'))); ?>">
                                    <?php echo e($position); ?>

                                </div>
                                <div class="flex-1 ml-4">
                                    <h3 class="font-semibold text-lg"><?php echo e($candidate->name); ?></h3>
                                    <?php if($candidate->description): ?>
                                        <p class="text-gray-600 text-sm mt-1"><?php echo e($candidate->description); ?></p>
                                    <?php endif; ?>
                                </div>
                                <div class="text-right">
                                    <div class="text-2xl font-bold text-purple-600"><?php echo e(number_format($totalVotes, 0, ',', ' ')); ?></div>
                                    <div class="text-sm text-gray-500">vote(s)</div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php else: ?>
                    <p class="text-gray-500 text-center py-8">Aucun candidat pour le moment</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Informations -->
            <div class="bg-white rounded-lg shadow-md p-6 sticky top-4">
                <h2 class="text-2xl font-bold mb-4">Informations</h2>
                <div class="space-y-4">
                    <div>
                        <h3 class="font-semibold text-gray-700 mb-2">Prix par vote</h3>
                        <p class="text-2xl font-bold text-purple-600">
                            <?php echo e(number_format($contest->price_per_vote, 0, ',', ' ')); ?> XOF
                        </p>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-700 mb-2">Points par vote</h3>
                        <p class="text-lg text-gray-600"><?php echo e($contest->points_per_vote); ?> point(s)</p>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-700 mb-2">Période</h3>
                        <p class="text-gray-600">
                            <i class="fas fa-calendar mr-2"></i>
                            Du <?php echo e($contest->start_date->format('d/m/Y')); ?><br>
                            au <?php echo e($contest->end_date->format('d/m/Y')); ?>

                        </p>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-700 mb-2">Organisateur</h3>
                        <p class="text-gray-600">
                            <i class="fas fa-user mr-2"></i>
                            <?php echo e($contest->organizer->name); ?>

                        </p>
                    </div>
                </div>

                <?php if($contest->isActive() && auth()->check()): ?>
                    <a href="#" onclick="alert('Fonctionnalité de vote à venir'); return false;" class="mt-6 block w-full bg-purple-600 text-white text-center px-4 py-3 rounded-lg hover:bg-purple-700 transition font-semibold">
                        <i class="fas fa-vote-yea mr-2"></i>Voter maintenant
                    </a>
                <?php elseif(!auth()->check()): ?>
                    <a href="<?php echo e(route('login')); ?>" class="mt-6 block w-full bg-purple-600 text-white text-center px-4 py-3 rounded-lg hover:bg-purple-700 transition font-semibold">
                        Se connecter pour voter
                    </a>
                <?php endif; ?>
            </div>

            <!-- Statistiques -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="font-semibold mb-4">Statistiques</h3>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Total votes</span>
                        <span class="font-semibold"><?php echo e(number_format($contest->votes()->sum('points'), 0, ',', ' ')); ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Candidats</span>
                        <span class="font-semibold"><?php echo e($contest->candidates()->count()); ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Revenus</span>
                        <span class="font-semibold"><?php echo e(number_format($contest->votes()->count() * $contest->price_per_vote, 0, ',', ' ')); ?> XOF</span>
                    </div>
                </div>
            </div>

            <!-- Partage -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="font-semibold mb-4">Partager</h3>
                <div class="flex gap-3">
                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo e(urlencode(request()->url())); ?>" target="_blank" class="flex-1 bg-blue-600 text-white px-4 py-2 rounded-lg text-center hover:bg-blue-700">
                        <i class="fab fa-facebook-f mr-2"></i>Facebook
                    </a>
                    <a href="https://twitter.com/intent/tweet?url=<?php echo e(urlencode(request()->url())); ?>" target="_blank" class="flex-1 bg-blue-400 text-white px-4 py-2 rounded-lg text-center hover:bg-blue-500">
                        <i class="fab fa-twitter mr-2"></i>Twitter
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\adoun\Music\Tikehub\resources\views/contests/show.blade.php ENDPATH**/ ?>