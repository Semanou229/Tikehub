

<?php $__env->startSection('title', 'Mes Billets'); ?>

<?php $__env->startSection('content'); ?>
<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Mes Billets</h1>
        <a href="<?php echo e(route('home')); ?>" class="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition">
            <i class="fas fa-search mr-2"></i>Découvrir des événements
        </a>
    </div>

    <!-- Filtres -->
    <div class="bg-white rounded-lg shadow-md p-4 mb-6">
        <form method="GET" action="<?php echo e(route('buyer.tickets')); ?>" class="flex flex-wrap gap-4 items-end">
            <div class="flex-1 min-w-[200px]">
                <label class="block text-sm font-medium text-gray-700 mb-2">Rechercher</label>
                <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Nom de l'événement..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <div class="min-w-[150px]">
                <label class="block text-sm font-medium text-gray-700 mb-2">Filtrer par</label>
                <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">Tous</option>
                    <option value="upcoming" <?php echo e(request('status') === 'upcoming' ? 'selected' : ''); ?>>À venir</option>
                    <option value="past" <?php echo e(request('status') === 'past' ? 'selected' : ''); ?>>Passés</option>
                    <option value="virtual" <?php echo e(request('status') === 'virtual' ? 'selected' : ''); ?>>Virtuels</option>
                </select>
            </div>
            <div>
                <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 transition">
                    <i class="fas fa-filter mr-2"></i>Filtrer
                </button>
            </div>
            <?php if(request('search') || request('status')): ?>
                <div>
                    <a href="<?php echo e(route('buyer.tickets')); ?>" class="text-gray-600 hover:text-gray-800 px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                        <i class="fas fa-times mr-2"></i>Réinitialiser
                    </a>
                </div>
            <?php endif; ?>
        </form>
    </div>

    <!-- Liste des billets -->
    <?php if($tickets->count() > 0): ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php $__currentLoopData = $tickets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ticket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                    <?php if($ticket->event->cover_image): ?>
                        <img src="<?php echo e(asset('storage/' . $ticket->event->cover_image)); ?>" alt="<?php echo e($ticket->event->title); ?>" class="w-full h-48 object-cover">
                    <?php else: ?>
                        <div class="w-full h-48 bg-gradient-to-r from-indigo-500 to-purple-500 flex items-center justify-center">
                            <i class="fas fa-calendar-alt text-white text-6xl opacity-50"></i>
                        </div>
                    <?php endif; ?>
                    
                    <div class="p-6">
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex-1">
                                <h3 class="text-lg font-bold text-gray-900 mb-1"><?php echo e($ticket->event->title); ?></h3>
                                <p class="text-sm text-gray-600"><?php echo e($ticket->ticketType->name); ?></p>
                            </div>
                            <?php if($ticket->event->is_virtual): ?>
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                    <i class="fas fa-video"></i> Virtuel
                                </span>
                            <?php endif; ?>
                        </div>

                        <div class="space-y-2 mb-4 text-sm text-gray-600">
                            <div class="flex items-center">
                                <i class="fas fa-calendar-alt text-indigo-600 mr-2 w-4"></i>
                                <span><?php echo e($ticket->event->start_date->translatedFormat('d/m/Y H:i')); ?></span>
                            </div>
                            <?php if(!$ticket->event->is_virtual && $ticket->event->venue_city): ?>
                                <div class="flex items-center">
                                    <i class="fas fa-map-marker-alt text-indigo-600 mr-2 w-4"></i>
                                    <span><?php echo e($ticket->event->venue_city); ?></span>
                                </div>
                            <?php endif; ?>
                            <div class="flex items-center">
                                <i class="fas fa-barcode text-indigo-600 mr-2 w-4"></i>
                                <span class="font-mono text-xs"><?php echo e($ticket->code); ?></span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-money-bill-wave text-indigo-600 mr-2 w-4"></i>
                                <span><?php echo e(number_format($ticket->price, 0, ',', ' ')); ?> XOF</span>
                            </div>
                        </div>

                        <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                            <div class="flex items-center gap-2">
                                <a href="<?php echo e(route('tickets.show', $ticket)); ?>" class="text-indigo-600 hover:text-indigo-800 p-2 rounded-lg hover:bg-indigo-50" title="Voir le billet">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="<?php echo e(route('tickets.download', $ticket)); ?>" class="text-green-600 hover:text-green-800 p-2 rounded-lg hover:bg-green-50" title="Télécharger PDF">
                                    <i class="fas fa-download"></i>
                                </a>
                            </div>
                            <?php if($ticket->event->is_virtual && $ticket->virtual_access_token && $ticket->event->start_date >= now()): ?>
                                <a href="<?php echo e($ticket->getVirtualAccessUrl()); ?>" target="_blank" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 text-sm font-medium">
                                    <i class="fas fa-video mr-1"></i>Rejoindre
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <div class="mt-6">
            <?php echo e($tickets->links()); ?>

        </div>
    <?php else: ?>
        <div class="bg-white rounded-lg shadow-md p-12 text-center">
            <i class="fas fa-ticket-alt text-6xl text-gray-300 mb-4"></i>
            <p class="text-gray-500 mb-4">Aucun billet trouvé</p>
            <a href="<?php echo e(route('home')); ?>" class="inline-block bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition">
                <i class="fas fa-search mr-2"></i>Découvrir des événements
            </a>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.buyer-dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\adoun\Music\Tikehub\resources\views/dashboard/buyer/tickets.blade.php ENDPATH**/ ?>