

<?php $__env->startSection('title', 'Mes Tickets de Support'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8">
        <div class="flex justify-between items-center mb-2">
            <div>
                <h1 class="text-4xl font-bold text-gray-800 mb-2">Mes Tickets de Support</h1>
                <p class="text-gray-600">Gérez vos demandes d'assistance</p>
            </div>
            <a href="<?php echo e(route('support.tickets.create')); ?>" class="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition shadow-md hover:shadow-lg">
                <i class="fas fa-plus mr-2"></i>Nouveau Ticket
            </a>
        </div>
    </div>

    <!-- Filtres -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <form method="GET" action="<?php echo e(route('support.tickets.index')); ?>" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Statut</label>
                    <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Tous les statuts</option>
                        <option value="open" <?php echo e(request('status') == 'open' ? 'selected' : ''); ?>>Ouvert</option>
                        <option value="in_progress" <?php echo e(request('status') == 'in_progress' ? 'selected' : ''); ?>>En cours</option>
                        <option value="resolved" <?php echo e(request('status') == 'resolved' ? 'selected' : ''); ?>>Résolu</option>
                        <option value="closed" <?php echo e(request('status') == 'closed' ? 'selected' : ''); ?>>Fermé</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Priorité</label>
                    <select name="priority" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Toutes les priorités</option>
                        <option value="low" <?php echo e(request('priority') == 'low' ? 'selected' : ''); ?>>Basse</option>
                        <option value="medium" <?php echo e(request('priority') == 'medium' ? 'selected' : ''); ?>>Moyenne</option>
                        <option value="high" <?php echo e(request('priority') == 'high' ? 'selected' : ''); ?>>Haute</option>
                        <option value="urgent" <?php echo e(request('priority') == 'urgent' ? 'selected' : ''); ?>>Urgente</option>
                    </select>
                </div>
                <div class="flex items-end">
                    <button type="submit" class="w-full bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
                        <i class="fas fa-filter mr-2"></i>Filtrer
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Liste des tickets -->
    <div class="space-y-4">
        <?php $__empty_1 = true; $__currentLoopData = $tickets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ticket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-xl transition duration-300 border-l-4 
                <?php if($ticket->priority == 'urgent'): ?> border-red-500
                <?php elseif($ticket->priority == 'high'): ?> border-orange-500
                <?php elseif($ticket->priority == 'medium'): ?> border-yellow-500
                <?php else: ?> border-green-500
                <?php endif; ?>">
                <div class="flex justify-between items-start mb-4">
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-2">
                            <a href="<?php echo e(route('support.tickets.show', $ticket)); ?>" class="text-xl font-semibold text-gray-800 hover:text-indigo-600 transition">
                                #<?php echo e($ticket->ticket_number); ?> - <?php echo e($ticket->subject); ?>

                            </a>
                            <span class="px-3 py-1 rounded-full text-xs font-semibold
                                <?php if($ticket->status == 'open'): ?> bg-green-100 text-green-800
                                <?php elseif($ticket->status == 'in_progress'): ?> bg-blue-100 text-blue-800
                                <?php elseif($ticket->status == 'resolved'): ?> bg-gray-100 text-gray-800
                                <?php else: ?> bg-red-100 text-red-800
                                <?php endif; ?>">
                                <?php if($ticket->status == 'open'): ?> Ouvert
                                <?php elseif($ticket->status == 'in_progress'): ?> En cours
                                <?php elseif($ticket->status == 'resolved'): ?> Résolu
                                <?php else: ?> Fermé
                                <?php endif; ?>
                            </span>
                            <span class="px-3 py-1 rounded-full text-xs font-semibold
                                <?php if($ticket->priority == 'urgent'): ?> bg-red-100 text-red-800
                                <?php elseif($ticket->priority == 'high'): ?> bg-orange-100 text-orange-800
                                <?php elseif($ticket->priority == 'medium'): ?> bg-yellow-100 text-yellow-800
                                <?php else: ?> bg-green-100 text-green-800
                                <?php endif; ?>">
                                <?php if($ticket->priority == 'urgent'): ?> Urgente
                                <?php elseif($ticket->priority == 'high'): ?> Haute
                                <?php elseif($ticket->priority == 'medium'): ?> Moyenne
                                <?php else: ?> Basse
                                <?php endif; ?>
                            </span>
                        </div>
                        <p class="text-gray-600 text-sm mb-3 line-clamp-2"><?php echo e(Str::limit($ticket->description, 150)); ?></p>
                        <div class="flex items-center gap-4 text-sm text-gray-500">
                            <span><i class="fas fa-calendar mr-1"></i>Créé le <?php echo e($ticket->created_at->translatedFormat('d/m/Y à H:i')); ?></span>
                            <?php if($ticket->last_replied_at): ?>
                                <span><i class="fas fa-reply mr-1"></i>Dernière réponse le <?php echo e($ticket->last_replied_at->translatedFormat('d/m/Y à H:i')); ?></span>
                            <?php endif; ?>
                            <?php if($ticket->assignedTo): ?>
                                <span><i class="fas fa-user-shield mr-1"></i>Assigné à <?php echo e($ticket->assignedTo->name); ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <a href="<?php echo e(route('support.tickets.show', $ticket)); ?>" class="ml-4 bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
                        <i class="fas fa-eye mr-2"></i>Voir
                    </a>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="bg-white rounded-lg shadow-md p-12 text-center">
                <i class="fas fa-ticket-alt text-6xl text-gray-300 mb-4"></i>
                <p class="text-gray-500 text-lg mb-2">Aucun ticket trouvé</p>
                <p class="text-gray-400 text-sm mb-6">Créez votre premier ticket de support pour commencer</p>
                <a href="<?php echo e(route('support.tickets.create')); ?>" class="inline-block bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition">
                    <i class="fas fa-plus mr-2"></i>Créer un ticket
                </a>
            </div>
        <?php endif; ?>
    </div>

    <!-- Pagination -->
    <?php if($tickets->hasPages()): ?>
        <div class="mt-8 flex justify-center">
            <div class="bg-white rounded-lg shadow-md px-4 py-3 inline-flex items-center space-x-2">
                <?php echo e($tickets->links()); ?>

            </div>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\adoun\Music\Tikehub\resources\views/support/tickets/index.blade.php ENDPATH**/ ?>