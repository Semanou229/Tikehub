

<?php $__env->startSection('title', 'Support Client'); ?>

<?php $__env->startSection('content'); ?>
<div class="p-6">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Support Client</h1>
        <p class="text-gray-600 mt-2">Gérer les tickets de support</p>
    </div>

    <!-- Statistiques rapides -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow-md p-4 border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Ouverts</p>
                    <p class="text-2xl font-bold text-gray-800"><?php echo e(\App\Models\SupportTicket::open()->count()); ?></p>
                </div>
                <i class="fas fa-folder-open text-3xl text-blue-500"></i>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-md p-4 border-l-4 border-yellow-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">En cours</p>
                    <p class="text-2xl font-bold text-gray-800"><?php echo e(\App\Models\SupportTicket::inProgress()->count()); ?></p>
                </div>
                <i class="fas fa-spinner text-3xl text-yellow-500"></i>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-md p-4 border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Non assignés</p>
                    <p class="text-2xl font-bold text-gray-800"><?php echo e(\App\Models\SupportTicket::unassigned()->count()); ?></p>
                </div>
                <i class="fas fa-user-slash text-3xl text-green-500"></i>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-md p-4 border-l-4 border-red-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Urgents</p>
                    <p class="text-2xl font-bold text-gray-800"><?php echo e(\App\Models\SupportTicket::where('priority', 'urgent')->whereIn('status', ['open', 'in_progress'])->count()); ?></p>
                </div>
                <i class="fas fa-exclamation-triangle text-3xl text-red-500"></i>
            </div>
        </div>
    </div>

    <!-- Filtres -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <form method="GET" action="<?php echo e(route('admin.support.index')); ?>" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Recherche</label>
                    <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Numéro, sujet, utilisateur..." 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Statut</label>
                    <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500">
                        <option value="">Tous</option>
                        <option value="open" <?php echo e(request('status') == 'open' ? 'selected' : ''); ?>>Ouvert</option>
                        <option value="in_progress" <?php echo e(request('status') == 'in_progress' ? 'selected' : ''); ?>>En cours</option>
                        <option value="resolved" <?php echo e(request('status') == 'resolved' ? 'selected' : ''); ?>>Résolu</option>
                        <option value="closed" <?php echo e(request('status') == 'closed' ? 'selected' : ''); ?>>Fermé</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Priorité</label>
                    <select name="priority" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500">
                        <option value="">Toutes</option>
                        <option value="low" <?php echo e(request('priority') == 'low' ? 'selected' : ''); ?>>Basse</option>
                        <option value="medium" <?php echo e(request('priority') == 'medium' ? 'selected' : ''); ?>>Moyenne</option>
                        <option value="high" <?php echo e(request('priority') == 'high' ? 'selected' : ''); ?>>Haute</option>
                        <option value="urgent" <?php echo e(request('priority') == 'urgent' ? 'selected' : ''); ?>>Urgente</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Type</label>
                    <select name="type" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500">
                        <option value="">Tous</option>
                        <option value="client" <?php echo e(request('type') == 'client' ? 'selected' : ''); ?>>Client</option>
                        <option value="organizer" <?php echo e(request('type') == 'organizer' ? 'selected' : ''); ?>>Organisateur</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Assigné à</label>
                    <select name="assigned_to" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500">
                        <option value="">Tous</option>
                        <option value="unassigned" <?php echo e(request('assigned_to') == 'unassigned' ? 'selected' : ''); ?>>Non assigné</option>
                        <?php $__currentLoopData = $admins; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $admin): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($admin->id); ?>" <?php echo e(request('assigned_to') == $admin->id ? 'selected' : ''); ?>><?php echo e($admin->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </div>
            <div class="flex justify-end">
                <button type="submit" class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700 transition">
                    <i class="fas fa-filter mr-2"></i>Filtrer
                </button>
            </div>
        </form>
    </div>

    <!-- Liste des tickets -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ticket</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Utilisateur</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Priorité</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Assigné à</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dernière activité</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php $__empty_1 = true; $__currentLoopData = $tickets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ticket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div>
                                    <a href="<?php echo e(route('admin.support.show', $ticket)); ?>" class="text-sm font-semibold text-gray-900 hover:text-red-600">
                                        #<?php echo e($ticket->ticket_number); ?>

                                    </a>
                                    <p class="text-sm text-gray-500 truncate max-w-xs"><?php echo e($ticket->subject); ?></p>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900"><?php echo e($ticket->user->name); ?></div>
                                <div class="text-sm text-gray-500"><?php echo e($ticket->user->email); ?></div>
                                <span class="px-2 py-1 text-xs rounded <?php echo e($ticket->type == 'organizer' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800'); ?>">
                                    <?php echo e($ticket->type == 'organizer' ? 'Organisateur' : 'Client'); ?>

                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs font-semibold rounded
                                    <?php if($ticket->priority == 'urgent'): ?> bg-red-100 text-red-800
                                    <?php elseif($ticket->priority == 'high'): ?> bg-orange-100 text-orange-800
                                    <?php elseif($ticket->priority == 'medium'): ?> bg-yellow-100 text-yellow-800
                                    <?php else: ?> bg-green-100 text-green-800
                                    <?php endif; ?>">
                                    <?php echo e(ucfirst($ticket->priority)); ?>

                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs font-semibold rounded
                                    <?php if($ticket->status == 'open'): ?> bg-green-100 text-green-800
                                    <?php elseif($ticket->status == 'in_progress'): ?> bg-blue-100 text-blue-800
                                    <?php elseif($ticket->status == 'resolved'): ?> bg-gray-100 text-gray-800
                                    <?php else: ?> bg-red-100 text-red-800
                                    <?php endif; ?>">
                                    <?php echo e(ucfirst(str_replace('_', ' ', $ticket->status))); ?>

                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?php if($ticket->assignedTo): ?>
                                    <?php echo e($ticket->assignedTo->name); ?>

                                <?php else: ?>
                                    <span class="text-red-600 font-semibold">Non assigné</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?php if($ticket->last_replied_at): ?>
                                    <?php echo e($ticket->last_replied_at->diffForHumans()); ?>

                                <?php else: ?>
                                    <?php echo e($ticket->created_at->diffForHumans()); ?>

                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="<?php echo e(route('admin.support.show', $ticket)); ?>" class="text-red-600 hover:text-red-900">
                                    <i class="fas fa-eye mr-1"></i>Voir
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <i class="fas fa-inbox text-4xl text-gray-300 mb-4"></i>
                                <p class="text-gray-500">Aucun ticket trouvé</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <?php if($tickets->hasPages()): ?>
        <div class="mt-6 flex justify-center">
            <div class="bg-white rounded-lg shadow-md px-4 py-3 inline-flex items-center space-x-2">
                <?php echo e($tickets->links()); ?>

            </div>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\adoun\Music\Tikehub\resources\views/admin/support/index.blade.php ENDPATH**/ ?>