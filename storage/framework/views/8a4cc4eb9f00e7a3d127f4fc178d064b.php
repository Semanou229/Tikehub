<?php $__env->startSection('title', $event->title . ' - Tikehub'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header avec date en rouge -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
        <div class="flex flex-col md:flex-row">
            <!-- Date Box (Rouge) -->
            <div class="bg-red-600 text-white p-6 text-center min-w-[120px] flex flex-col justify-center items-center">
                <div class="text-2xl font-bold uppercase"><?php echo e($event->start_date->translatedFormat('M')); ?></div>
                <div class="text-5xl font-bold"><?php echo e($event->start_date->format('d')); ?></div>
                <div class="text-lg mt-2"><?php echo e($event->start_date->translatedFormat('l')); ?></div>
            </div>

            <!-- Contenu principal du header -->
            <div class="flex-1 p-6">
                <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4">
                    <div class="flex-1">
                        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4"><?php echo e($event->title); ?></h1>
                        
                        <!-- Informations date et lieu -->
                        <div class="space-y-2 text-gray-700">
                            <div class="flex items-center">
                                <i class="fas fa-calendar-alt text-red-600 mr-3 w-5"></i>
                                <span>
                                    <?php echo e($event->start_date->translatedFormat('D, d M Y')); ?> 
                                    <?php if($event->end_date && $event->end_date->format('Y-m-d') !== $event->start_date->format('Y-m-d')): ?>
                                        - <?php echo e($event->end_date->translatedFormat('D, d M Y')); ?>

                                    <?php endif; ?>
                                    (<?php echo e($event->start_date->format('H:i')); ?> - <?php echo e($event->end_date ? $event->end_date->format('H:i') : '23:59'); ?>)
                                    <?php echo e(config('app.timezone', 'UTC')); ?>

                                </span>
                            </div>
                            <?php if($event->venue_name || $event->venue_city): ?>
                                <div class="flex items-center">
                                    <i class="fas fa-map-marker-alt text-red-600 mr-3 w-5"></i>
                                    <span>
                                        <?php if($event->venue_name): ?><?php echo e($event->venue_name); ?>, <?php endif; ?>
                                        <?php if($event->venue_city): ?><?php echo e($event->venue_city); ?><?php endif; ?>
                                        <?php if($event->venue_country): ?>, <?php echo e($event->venue_country); ?><?php endif; ?>
                                    </span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Boutons d'action -->
                    <div class="flex flex-col gap-2 md:min-w-[150px]">
                        <button onclick="shareEvent()" class="flex items-center justify-center gap-2 px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition text-sm">
                            <i class="fas fa-share-alt"></i>
                            <span>PARTAGER</span>
                        </button>
                        <button onclick="reportEvent()" class="flex items-center justify-center gap-2 px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition text-sm">
                            <i class="fas fa-flag"></i>
                            <span>SIGNALER</span>
                        </button>
                        <button onclick="addToCalendar()" class="flex items-center justify-center gap-2 px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition text-sm">
                            <i class="fas fa-calendar-plus"></i>
                            <span>CALENDRIER</span>
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
                <h2 class="text-2xl font-bold mb-4 pb-2 border-b-2 border-red-600">Description</h2>
                <div class="prose max-w-none mb-6">
                    <?php echo nl2br(e($event->description)); ?>

                </div>

                <!-- Points à puces avec checkmarks verts -->
                <?php if($event->ticketTypes->count() > 0 || $event->contests->count() > 0): ?>
                    <div class="space-y-3 mt-6">
                        <?php if($event->ticketTypes->count() > 0): ?>
                            <div class="flex items-start">
                                <i class="fas fa-check-circle text-green-600 mr-3 mt-1"></i>
                                <span>Billets disponibles en ligne</span>
                            </div>
                        <?php endif; ?>
                        <?php if($event->contests->count() > 0): ?>
                            <div class="flex items-start">
                                <i class="fas fa-check-circle text-green-600 mr-3 mt-1"></i>
                                <span>Concours et votes disponibles</span>
                            </div>
                        <?php endif; ?>
                        <?php if($event->fundraisings->count() > 0): ?>
                            <div class="flex items-start">
                                <i class="fas fa-check-circle text-green-600 mr-3 mt-1"></i>
                                <span>Collecte de fonds associée</span>
                            </div>
                        <?php endif; ?>
                        <div class="flex items-start">
                            <i class="fas fa-check-circle text-green-600 mr-3 mt-1"></i>
                            <span>Événement organisé par <?php echo e($event->organizer->name); ?></span>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Call to action avec icône -->
                <?php if($event->venue_city): ?>
                    <div class="mt-6 p-4 bg-pink-50 border-l-4 border-pink-500 rounded">
                        <div class="flex items-start">
                            <i class="fas fa-map-pin text-pink-600 mr-3 mt-1"></i>
                            <p class="text-gray-700">
                                Rendez-vous à <?php echo e($event->venue_name ?? $event->venue_city); ?> pour une expérience inoubliable !
                            </p>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="mt-4 p-4 bg-red-50 border-l-4 border-red-500 rounded">
                    <div class="flex items-start">
                        <i class="fas fa-exclamation-circle text-red-600 mr-3 mt-1"></i>
                        <p class="text-gray-700">
                            Ne ratez pas cet événement unique : réservez vite votre place et venez vivre une expérience mémorable !
                        </p>
                    </div>
                </div>
            </div>

            <!-- Informations sur le billet -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-2xl font-bold mb-4 pb-2 border-b-2 border-red-600">Informations sur le billet</h2>
                <div class="flex items-center justify-between">
                    <span class="font-semibold text-gray-700">Billets</span>
                    <?php if($event->ticketTypes->count() > 0): ?>
                        <?php
                            $hasAvailableTickets = $event->ticketTypes->filter(function($type) {
                                return $type->isOnSale();
                            })->count() > 0;
                        ?>
                        <?php if($hasAvailableTickets): ?>
                            <a href="<?php echo e(route('tickets.index', $event)); ?>" class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700 transition font-semibold">
                                <i class="fas fa-ticket-alt mr-2"></i>Réserver maintenant
                            </a>
                        <?php else: ?>
                            <span class="px-4 py-2 bg-gray-200 text-gray-600 rounded-lg text-sm">
                                Réservation en ligne fermée
                            </span>
                        <?php endif; ?>
                    <?php else: ?>
                        <span class="px-4 py-2 bg-gray-200 text-gray-600 rounded-lg text-sm">
                            Aucun billet disponible
                        </span>
                    <?php endif; ?>
                </div>

                <!-- Liste des types de billets -->
                <?php if($event->ticketTypes->count() > 0): ?>
                    <div class="mt-6 space-y-4">
                        <?php $__currentLoopData = $event->ticketTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ticketType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="border border-gray-200 rounded-lg p-4 hover:border-red-500 transition">
                                <div class="flex justify-between items-start">
                                    <div class="flex-1">
                                        <h3 class="font-semibold text-lg mb-1"><?php echo e($ticketType->name); ?></h3>
                                        <?php if($ticketType->description): ?>
                                            <p class="text-gray-600 text-sm mb-2"><?php echo e($ticketType->description); ?></p>
                                        <?php endif; ?>
                                        <div class="flex items-center gap-4 text-sm text-gray-500">
                                            <span>
                                                <i class="fas fa-ticket-alt mr-1"></i>
                                                <?php echo e($ticketType->available_quantity); ?> disponible(s)
                                            </span>
                                            <?php if($ticketType->sale_start_date && $ticketType->sale_end_date): ?>
                                                <span>
                                                    Du <?php echo e($ticketType->sale_start_date->format('d/m/Y')); ?> au <?php echo e($ticketType->sale_end_date->format('d/m/Y')); ?>

                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="text-right ml-4">
                                        <div class="text-2xl font-bold text-red-600">
                                            <?php echo e(number_format($ticketType->price, 0, ',', ' ')); ?> XOF
                                        </div>
                                        <?php if($ticketType->isOnSale() && auth()->check()): ?>
                                            <a href="<?php echo e(route('tickets.index', $event)); ?>" class="mt-2 inline-block bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition text-sm">
                                                Acheter
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Calendrier des événements -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-2xl font-bold mb-4 pb-2 border-b-2 border-red-600">Calendrier des événements</h2>
                <div class="space-y-3">
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div>
                            <p class="font-semibold">
                                <?php echo e($event->start_date->translatedFormat('l, d F Y')); ?>

                                <?php if($event->end_date && $event->end_date->format('Y-m-d') !== $event->start_date->format('Y-m-d')): ?>
                                    - <?php echo e($event->end_date->translatedFormat('l, d F Y')); ?>

                                <?php endif; ?>
                            </p>
                            <p class="text-sm text-gray-600 mt-1">
                                <?php echo e($event->start_date->format('H:i')); ?> - <?php echo e($event->end_date ? $event->end_date->format('H:i') : '23:59'); ?> 
                                <?php echo e(config('app.timezone', 'UTC')); ?>

                            </p>
                        </div>
                        <?php if($event->end_date && $event->end_date->isPast()): ?>
                            <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-sm font-semibold">
                                Fermé
                            </span>
                        <?php elseif($event->start_date->isFuture()): ?>
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

            <!-- Ajouter un avis -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-2xl font-bold mb-4">Ajouter Un Avis</h2>
                <?php if(auth()->guard()->check()): ?>
                    <form action="#" method="POST" class="space-y-4">
                        <?php echo csrf_field(); ?>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Évaluation</label>
                            <div class="flex gap-1" id="rating-stars">
                                <?php for($i = 1; $i <= 5; $i++): ?>
                                    <button type="button" class="text-2xl text-gray-300 hover:text-yellow-400 focus:outline-none" data-rating="<?php echo e($i); ?>">
                                        <i class="far fa-star"></i>
                                    </button>
                                <?php endfor; ?>
                            </div>
                            <input type="hidden" name="rating" id="rating-value" value="0">
                        </div>
                        <div>
                            <label for="reviewer_name" class="block text-sm font-medium text-gray-700 mb-2">Nom*</label>
                            <input type="text" id="reviewer_name" name="name" value="<?php echo e(auth()->user()->name); ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent" placeholder="Tapez votre nom ici" required>
                        </div>
                        <div>
                            <label for="reviewer_email" class="block text-sm font-medium text-gray-700 mb-2">Votre Email*</label>
                            <input type="email" id="reviewer_email" name="email" value="<?php echo e(auth()->user()->email); ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent" placeholder="Votre email" required>
                        </div>
                        <div>
                            <label for="review_comment" class="block text-sm font-medium text-gray-700 mb-2">Commentaire</label>
                            <textarea id="review_comment" name="comment" rows="5" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent" placeholder="Votre commentaire"></textarea>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" id="save_info" name="save_info" class="mr-2">
                            <label for="save_info" class="text-sm text-gray-600">
                                Enregistrez mon nom, mon e-mail et mon site web dans ce navigateur pour la prochaine fois que je commenterai.
                            </label>
                        </div>
                        <button type="submit" class="w-full bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-700 transition font-semibold">
                            Publier un commentaire
                        </button>
                    </form>
                <?php else: ?>
                    <p class="text-gray-600 mb-4">Vous devez être connecté pour laisser un avis.</p>
                    <a href="<?php echo e(route('login')); ?>" class="inline-block bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-700 transition font-semibold">
                        Se connecter
                    </a>
                <?php endif; ?>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6 sticky top-4 self-start">
            <!-- Organisateur -->
            <div class="bg-gray-100 rounded-lg p-6">
                <div class="bg-white rounded-lg p-4">
                    <div class="flex items-center mb-4">
                        <div class="w-16 h-16 bg-red-600 rounded-full flex items-center justify-center text-white font-bold text-xl mr-3">
                            <?php echo e(strtoupper(substr($event->organizer->name, 0, 2))); ?>

                        </div>
                        <div>
                            <h3 class="font-bold text-lg"><?php echo e($event->organizer->name); ?></h3>
                            <p class="text-sm text-gray-500">ORGANISATEUR</p>
                        </div>
                    </div>
                    <?php if($event->organizer->phone || $event->organizer->email): ?>
                        <div class="space-y-2 mb-4">
                            <?php if($event->organizer->phone): ?>
                                <div class="flex items-center text-sm text-gray-700">
                                    <i class="fas fa-phone text-red-600 mr-2 w-5"></i>
                                    <span><?php echo e($event->organizer->phone); ?></span>
                                </div>
                            <?php endif; ?>
                            <?php if($event->organizer->email): ?>
                                <div class="flex items-center text-sm text-gray-700">
                                    <i class="fas fa-envelope text-red-600 mr-2 w-5"></i>
                                    <span><?php echo e($event->organizer->email); ?></span>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                    <button onclick="contactOrganizer()" class="w-full bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition flex items-center justify-center gap-2">
                        <i class="fas fa-envelope"></i>
                        <span>Envoyer un message</span>
                    </button>
                </div>
            </div>

            <!-- Galerie -->
            <?php if($event->gallery && count($event->gallery) > 0): ?>
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-xl font-bold mb-4">Galerie</h3>
                    <div class="grid grid-cols-2 gap-3">
                        <?php $__currentLoopData = array_slice($event->gallery, 0, 4); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <img src="<?php echo e(asset('storage/' . $image)); ?>" alt="Galerie <?php echo e($event->title); ?>" class="w-full h-32 object-cover rounded-lg">
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <?php if(count($event->gallery) > 4): ?>
                        <button class="mt-3 w-full text-red-600 hover:text-red-700 font-semibold">
                            Voir toutes les photos (<?php echo e(count($event->gallery)); ?>)
                        </button>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <!-- Statistiques -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-xl font-bold mb-4">Statistiques</h3>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Billets vendus</span>
                        <span class="font-semibold"><?php echo e($event->total_tickets_sold ?? 0); ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Revenus</span>
                        <span class="font-semibold"><?php echo e(number_format($event->total_sales ?? 0, 0, ',', ' ')); ?> XOF</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
    // Système de notation avec étoiles
    const stars = document.querySelectorAll('#rating-stars button');
    const ratingInput = document.getElementById('rating-value');
    
    stars.forEach((star, index) => {
        star.addEventListener('click', () => {
            const rating = index + 1;
            ratingInput.value = rating;
            updateStars(rating);
        });
        
        star.addEventListener('mouseenter', () => {
            updateStars(index + 1);
        });
    });
    
    document.getElementById('rating-stars').addEventListener('mouseleave', () => {
        const currentRating = parseInt(ratingInput.value);
        updateStars(currentRating);
    });
    
    function updateStars(rating) {
        stars.forEach((star, index) => {
            const icon = star.querySelector('i');
            if (index < rating) {
                icon.classList.remove('far');
                icon.classList.add('fas');
                icon.classList.remove('text-gray-300');
                icon.classList.add('text-yellow-400');
            } else {
                icon.classList.remove('fas');
                icon.classList.add('far');
                icon.classList.remove('text-yellow-400');
                icon.classList.add('text-gray-300');
            }
        });
    }
    
    function shareEvent() {
        if (navigator.share) {
            navigator.share({
                title: '<?php echo e($event->title); ?>',
                text: '<?php echo e(Str::limit($event->description, 100)); ?>',
                url: window.location.href
            });
        } else {
            // Fallback: copier le lien
            navigator.clipboard.writeText(window.location.href);
            alert('Lien copié dans le presse-papiers !');
        }
    }
    
    function reportEvent() {
        if (confirm('Voulez-vous signaler cet événement ?')) {
            // TODO: Implémenter la fonctionnalité de signalement
            alert('Fonctionnalité de signalement à venir');
        }
    }
    
    function addToCalendar() {
        // TODO: Générer un fichier .ics pour ajouter au calendrier
        alert('Fonctionnalité d\'ajout au calendrier à venir');
    }
    
    function contactOrganizer() {
        // TODO: Ouvrir un formulaire de contact
        alert('Fonctionnalité de contact à venir');
    }
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\adoun\Music\Tikehub\resources\views/events/show.blade.php ENDPATH**/ ?>