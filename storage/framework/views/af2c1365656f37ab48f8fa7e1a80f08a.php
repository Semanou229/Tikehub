<?php $__env->startSection('title', $contest->name . ' - Tikehub'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header avec date en rouge -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
        <div class="flex flex-col md:flex-row">
            <!-- Date Box (Rouge) -->
            <div class="bg-purple-600 text-white p-6 text-center min-w-[120px] flex flex-col justify-center items-center">
                <div class="text-2xl font-bold uppercase"><?php echo e($contest->start_date->translatedFormat('M')); ?></div>
                <div class="text-5xl font-bold"><?php echo e($contest->start_date->format('d')); ?></div>
                <div class="text-lg mt-2"><?php echo e($contest->start_date->translatedFormat('l')); ?></div>
            </div>

            <!-- Contenu principal du header -->
            <div class="flex-1 p-6">
                <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4">
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="bg-purple-600 px-3 py-1 rounded-full text-xs font-semibold text-white">
                                <i class="fas fa-trophy mr-1"></i>Concours
                            </span>
                            <?php if($contest->isActive()): ?>
                                <span class="bg-green-600 px-3 py-1 rounded-full text-xs font-semibold text-white">Actif</span>
                            <?php else: ?>
                                <span class="bg-gray-600 px-3 py-1 rounded-full text-xs font-semibold text-white">Terminé</span>
                            <?php endif; ?>
                        </div>
                        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4"><?php echo e($contest->name); ?></h1>
                        
                        <!-- Informations date et prix -->
                        <div class="space-y-2 text-gray-700">
                            <div class="flex items-center">
                                <i class="fas fa-calendar-alt text-purple-600 mr-3 w-5"></i>
                                <span>
                                    Du <?php echo e($contest->start_date->translatedFormat('D, d M Y')); ?> 
                                    au <?php echo e($contest->end_date->translatedFormat('D, d M Y')); ?>

                                </span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-coins text-purple-600 mr-3 w-5"></i>
                                <span><?php echo e(number_format($contest->price_per_vote, 0, ',', ' ')); ?> XOF par vote (<?php echo e($contest->points_per_vote); ?> point(s))</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-users text-purple-600 mr-3 w-5"></i>
                                <span><?php echo e(number_format($contest->votes()->sum('points'), 0, ',', ' ')); ?> vote(s) total</span>
                            </div>
                        </div>
                    </div>

                    <!-- Boutons d'action -->
                    <div class="flex flex-col gap-2 md:min-w-[150px]">
                        <button onclick="shareContest()" class="flex items-center justify-center gap-2 px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition text-sm">
                            <i class="fas fa-share-alt"></i>
                            <span>PARTAGER</span>
                        </button>
                        <button onclick="reportContest()" class="flex items-center justify-center gap-2 px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition text-sm">
                            <i class="fas fa-flag"></i>
                            <span>SIGNALER</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Colonne principale -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Description -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-2xl font-bold mb-4 pb-2 border-b-2 border-purple-600">Description</h2>
                <div class="prose max-w-none mb-6">
                    <?php echo nl2br(e($contest->description)); ?>

                </div>

                <!-- Points à puces avec checkmarks verts -->
                <div class="space-y-3 mt-6">
                    <div class="flex items-start">
                        <i class="fas fa-check-circle text-green-600 mr-3 mt-1"></i>
                        <span>Votez pour votre candidat favori</span>
                    </div>
                    <div class="flex items-start">
                        <i class="fas fa-check-circle text-green-600 mr-3 mt-1"></i>
                        <span>Chaque vote compte et fait la différence</span>
                    </div>
                    <div class="flex items-start">
                        <i class="fas fa-check-circle text-green-600 mr-3 mt-1"></i>
                        <span>Concours organisé par <?php echo e($contest->organizer->name); ?></span>
                    </div>
                </div>

                <!-- Call to action avec icône -->
                <?php if($contest->isActive()): ?>
                    <div class="mt-6 p-4 bg-purple-50 border-l-4 border-purple-500 rounded">
                        <div class="flex items-start">
                            <i class="fas fa-vote-yea text-purple-600 mr-3 mt-1"></i>
                            <p class="text-gray-700">
                                Le concours est actuellement actif ! Votez maintenant pour soutenir votre candidat favori et l'aider à remporter la victoire.
                            </p>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="mt-4 p-4 bg-red-50 border-l-4 border-red-500 rounded">
                    <div class="flex items-start">
                        <i class="fas fa-exclamation-circle text-red-600 mr-3 mt-1"></i>
                        <p class="text-gray-700">
                            Ne manquez pas cette opportunité unique : participez au vote et faites gagner votre candidat préféré !
                        </p>
                    </div>
                </div>
            </div>

            <!-- Règles du concours -->
            <?php if($contest->rules): ?>
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-2xl font-bold mb-4 pb-2 border-b-2 border-purple-600">Règles du concours</h2>
                    <div class="prose max-w-none">
                        <?php echo nl2br(e($contest->rules)); ?>

                    </div>
                </div>
            <?php endif; ?>

            <!-- Classement -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-2xl font-bold mb-4 pb-2 border-b-2 border-purple-600">Classement</h2>
                <?php if($ranking && $ranking->count() > 0): ?>
                    <div class="space-y-4">
                        <?php $__currentLoopData = $ranking; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $candidate): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $totalPoints = (int)($candidate->total_points ?? 0);
                            ?>
                            <div class="flex items-center p-4 border-2 rounded-lg <?php echo e($candidate->position <= 3 ? 'border-yellow-400 bg-yellow-50' : 'border-gray-200'); ?>">
                                <div class="flex-shrink-0 w-12 h-12 flex items-center justify-center rounded-full font-bold text-lg
                                    <?php echo e($candidate->position === 1 ? 'bg-yellow-400 text-yellow-900' : ($candidate->position === 2 ? 'bg-gray-300 text-gray-800' : ($candidate->position === 3 ? 'bg-orange-300 text-orange-900' : 'bg-gray-200 text-gray-600'))); ?>">
                                    <?php echo e($candidate->position); ?>

                                </div>
                                <div class="flex-1 ml-4">
                                    <h3 class="font-semibold text-lg"><?php echo e($candidate->name); ?></h3>
                                    <?php if($candidate->description): ?>
                                        <p class="text-gray-600 text-sm mt-1"><?php echo e(\Illuminate\Support\Str::limit($candidate->description, 80)); ?></p>
                                    <?php endif; ?>
                                </div>
                                <div class="text-right">
                                    <div class="text-2xl font-bold text-purple-600"><?php echo e(number_format($totalPoints, 0, ',', ' ')); ?></div>
                                    <div class="text-sm text-gray-500">point(s)</div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php else: ?>
                    <p class="text-gray-500 text-center py-8">Aucun candidat pour le moment</p>
                <?php endif; ?>
            </div>

            <!-- Candidats -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-2xl font-bold mb-4 pb-2 border-b-2 border-purple-600">Candidats</h2>
                <?php if($candidates && $candidates->count() > 0): ?>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <?php $__currentLoopData = $candidates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $candidate): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $totalPoints = (int)($candidate->votes_sum_points ?? 0);
                            ?>
                            <div class="border-2 border-gray-200 rounded-lg p-4 hover:border-purple-500 transition">
                                <?php if($candidate->photo): ?>
                                    <img src="<?php echo e(asset('storage/' . $candidate->photo)); ?>" alt="<?php echo e($candidate->name); ?>" class="w-full h-48 object-cover rounded-lg mb-4">
                                <?php else: ?>
                                    <div class="w-full h-48 bg-gradient-to-br from-purple-400 to-pink-500 rounded-lg mb-4 flex items-center justify-center">
                                        <i class="fas fa-user text-6xl text-white opacity-50"></i>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="mb-4">
                                    <h3 class="text-xl font-semibold mb-2"><?php echo e($candidate->name); ?></h3>
                                    <?php if($candidate->description): ?>
                                        <p class="text-gray-600 text-sm mb-3"><?php echo e(\Illuminate\Support\Str::limit($candidate->description, 120)); ?></p>
                                    <?php endif; ?>
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <div class="text-2xl font-bold text-purple-600"><?php echo e(number_format($totalPoints, 0, ',', ' ')); ?></div>
                                            <div class="text-xs text-gray-500">point(s)</div>
                                        </div>
                                        <?php if($candidate->number): ?>
                                            <span class="bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-sm font-semibold">
                                                #<?php echo e($candidate->number); ?>

                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <?php if($contest->isActive()): ?>
                                    <?php if(auth()->guard()->check()): ?>
                                        <form action="<?php echo e(route('contests.vote', ['contest' => $contest, 'candidate' => $candidate])); ?>" method="POST" class="space-y-3">
                                            <?php echo csrf_field(); ?>
                                            <div class="flex items-center gap-2">
                                                <label for="quantity_<?php echo e($candidate->id); ?>" class="text-sm text-gray-700">Nombre de votes:</label>
                                                <input type="number" name="quantity" id="quantity_<?php echo e($candidate->id); ?>" min="1" max="100" value="1" class="w-20 px-2 py-1 border border-gray-300 rounded text-center" required>
                                            </div>
                                            <button type="submit" class="block w-full bg-purple-600 text-white text-center px-4 py-3 rounded-lg hover:bg-purple-700 transition font-semibold">
                                                <i class="fas fa-vote-yea mr-2"></i>Voter pour <?php echo e($candidate->name); ?>

                                            </button>
                                            <p class="text-xs text-gray-500 text-center">
                                                Total: <?php echo e(number_format($contest->price_per_vote, 0, ',', ' ')); ?> XOF × <span id="total_<?php echo e($candidate->id); ?>">1</span> = 
                                                <span class="font-semibold" id="amount_<?php echo e($candidate->id); ?>"><?php echo e(number_format($contest->price_per_vote, 0, ',', ' ')); ?></span> XOF
                                            </p>
                                        </form>
                                    <?php else: ?>
                                        <a href="<?php echo e(route('login')); ?>" class="block w-full bg-purple-600 text-white text-center px-4 py-3 rounded-lg hover:bg-purple-700 transition font-semibold">
                                            Se connecter pour voter
                                        </a>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <button disabled class="block w-full bg-gray-400 text-white text-center px-4 py-3 rounded-lg cursor-not-allowed font-semibold">
                                        Concours terminé
                                    </button>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php else: ?>
                    <p class="text-gray-500 text-center py-8">Aucun candidat pour le moment</p>
                <?php endif; ?>
            </div>

            <!-- Calendrier du concours -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-2xl font-bold mb-4 pb-2 border-b-2 border-purple-600">Calendrier du concours</h2>
                <div class="space-y-3">
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div>
                            <p class="font-semibold">
                                Du <?php echo e($contest->start_date->translatedFormat('l, d F Y')); ?> 
                                au <?php echo e($contest->end_date->translatedFormat('l, d F Y')); ?>

                            </p>
                            <p class="text-sm text-gray-600 mt-1">
                                Période de vote active
                            </p>
                        </div>
                        <?php if($contest->end_date->isPast()): ?>
                            <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-sm font-semibold">
                                Terminé
                            </span>
                        <?php elseif($contest->start_date->isFuture()): ?>
                            <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm font-semibold">
                                À venir
                            </span>
                        <?php else: ?>
                            <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm font-semibold">
                                En cours
                            </span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6 sticky top-4 self-start">
            <!-- Organisateur -->
            <div class="bg-gray-100 rounded-lg p-6">
                <div class="bg-white rounded-lg p-4">
                    <div class="flex items-center mb-4">
                        <div class="w-16 h-16 bg-purple-600 rounded-full flex items-center justify-center text-white font-bold text-xl mr-3">
                            <?php echo e(strtoupper(substr($contest->organizer->name, 0, 2))); ?>

                        </div>
                        <div>
                            <h3 class="font-bold text-lg"><?php echo e($contest->organizer->name); ?></h3>
                            <p class="text-sm text-gray-500">ORGANISATEUR</p>
                        </div>
                    </div>
                    <?php if($contest->organizer->email): ?>
                        <div class="space-y-2 mb-4">
                            <div class="flex items-center text-sm text-gray-700">
                                <i class="fas fa-envelope text-purple-600 mr-2 w-5"></i>
                                <span><?php echo e($contest->organizer->email); ?></span>
                            </div>
                        </div>
                    <?php endif; ?>
                    <button onclick="contactOrganizer()" class="w-full bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition flex items-center justify-center gap-2">
                        <i class="fas fa-envelope"></i>
                        <span>Envoyer un message</span>
                    </button>
                </div>
            </div>

            <!-- Informations -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-xl font-bold mb-4">Informations</h3>
                <div class="space-y-3">
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
                            <i class="fas fa-calendar mr-2 text-purple-600"></i>
                            Du <?php echo e($contest->start_date->translatedFormat('d/m/Y')); ?><br>
                            au <?php echo e($contest->end_date->translatedFormat('d/m/Y')); ?>

                        </p>
                    </div>
                </div>
            </div>

            <!-- Statistiques -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-xl font-bold mb-4">Statistiques</h3>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Total votes</span>
                        <span class="font-semibold"><?php echo e(number_format($contest->votes()->sum('points'), 0, ',', ' ')); ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Candidats</span>
                        <span class="font-semibold"><?php echo e($candidates->count()); ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Revenus</span>
                        <span class="font-semibold"><?php echo e(number_format($contest->votes()->count() * $contest->price_per_vote, 0, ',', ' ')); ?> XOF</span>
                    </div>
                </div>
            </div>

            <!-- Partage -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-xl font-bold mb-4">Partager</h3>
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

<?php $__env->startPush('scripts'); ?>
<script>
    // Calculer le montant total en fonction du nombre de votes
    document.querySelectorAll('input[type="number"][name="quantity"]').forEach(input => {
        const candidateId = input.id.replace('quantity_', '');
        const pricePerVote = <?php echo e($contest->price_per_vote); ?>;
        
        input.addEventListener('input', function() {
            const quantity = parseInt(this.value) || 1;
            const total = pricePerVote * quantity;
            
            document.getElementById('total_' + candidateId).textContent = quantity;
            document.getElementById('amount_' + candidateId).textContent = total.toLocaleString('fr-FR');
        });
    });
    
    function shareContest() {
        if (navigator.share) {
            navigator.share({
                title: '<?php echo e($contest->name); ?>',
                text: '<?php echo e(Str::limit($contest->description, 100)); ?>',
                url: window.location.href
            });
        } else {
            navigator.clipboard.writeText(window.location.href);
            alert('Lien copié dans le presse-papiers !');
        }
    }
    
    function reportContest() {
        if (confirm('Voulez-vous signaler ce concours ?')) {
            alert('Fonctionnalité de signalement à venir');
        }
    }
    
    function contactOrganizer() {
        alert('Fonctionnalité de contact à venir');
    }
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\adoun\Music\Tikehub\resources\views/contests/show.blade.php ENDPATH**/ ?>