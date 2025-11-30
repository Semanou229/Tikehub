

<?php $__env->startSection('title', $contact->full_name); ?>

<?php $__env->startSection('content'); ?>
<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800"><?php echo e($contact->full_name); ?></h1>
            <?php if($contact->company): ?>
                <p class="text-gray-600 mt-1"><?php echo e($contact->company); ?></p>
            <?php endif; ?>
        </div>
        <div class="flex gap-3">
            <a href="<?php echo e(route('organizer.crm.contacts.edit', $contact)); ?>" class="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition">
                <i class="fas fa-edit mr-2"></i>Modifier
            </a>
            <a href="<?php echo e(route('organizer.crm.contacts.index')); ?>" class="text-gray-600 hover:text-gray-800 px-6 py-3">
                <i class="fas fa-arrow-left mr-2"></i>Retour
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Colonne principale -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Informations principales -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-xl font-bold text-gray-800 mb-4">Informations</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <span class="text-sm text-gray-600">Prénom:</span>
                        <p class="font-semibold text-gray-800"><?php echo e($contact->first_name); ?></p>
                    </div>
                    <div>
                        <span class="text-sm text-gray-600">Nom:</span>
                        <p class="font-semibold text-gray-800"><?php echo e($contact->last_name); ?></p>
                    </div>
                    <?php if($contact->email): ?>
                        <div>
                            <span class="text-sm text-gray-600">Email:</span>
                            <p class="font-semibold text-gray-800">
                                <a href="mailto:<?php echo e($contact->email); ?>" class="text-indigo-600 hover:text-indigo-800"><?php echo e($contact->email); ?></a>
                            </p>
                        </div>
                    <?php endif; ?>
                    <?php if($contact->phone): ?>
                        <div>
                            <span class="text-sm text-gray-600">Téléphone:</span>
                            <p class="font-semibold text-gray-800">
                                <a href="tel:<?php echo e($contact->phone); ?>" class="text-indigo-600 hover:text-indigo-800"><?php echo e($contact->phone); ?></a>
                            </p>
                        </div>
                    <?php endif; ?>
                    <?php if($contact->company): ?>
                        <div>
                            <span class="text-sm text-gray-600">Entreprise:</span>
                            <p class="font-semibold text-gray-800"><?php echo e($contact->company); ?></p>
                        </div>
                    <?php endif; ?>
                    <?php if($contact->job_title): ?>
                        <div>
                            <span class="text-sm text-gray-600">Poste:</span>
                            <p class="font-semibold text-gray-800"><?php echo e($contact->job_title); ?></p>
                        </div>
                    <?php endif; ?>
                    <?php if($contact->category): ?>
                        <div>
                            <span class="text-sm text-gray-600">Catégorie:</span>
                            <span class="ml-2 px-3 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800">
                                <?php echo e(ucfirst($contact->category)); ?>

                            </span>
                        </div>
                    <?php endif; ?>
                    <?php if($contact->pipeline_stage): ?>
                        <div>
                            <span class="text-sm text-gray-600">Étape pipeline:</span>
                            <span class="ml-2 px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                <?php echo e(ucfirst($contact->pipeline_stage)); ?>

                            </span>
                        </div>
                    <?php endif; ?>
                    <?php if($contact->assignedUser): ?>
                        <div>
                            <span class="text-sm text-gray-600">Assigné à:</span>
                            <p class="font-semibold text-gray-800"><?php echo e($contact->assignedUser->name); ?></p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Tags -->
            <?php if($contact->tags->count() > 0): ?>
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Tags</h3>
                    <div class="flex flex-wrap gap-2">
                        <?php $__currentLoopData = $contact->tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <span class="px-3 py-1 bg-indigo-100 text-indigo-800 text-sm rounded-full">
                                <?php echo e($tag->name); ?>

                            </span>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Segments -->
            <?php if($contact->segments->count() > 0): ?>
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Segments</h3>
                    <div class="flex flex-wrap gap-2">
                        <?php $__currentLoopData = $contact->segments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $segment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <span class="px-3 py-1 bg-green-100 text-green-800 text-sm rounded-full">
                                <?php echo e($segment->name); ?>

                            </span>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Notes -->
            <?php if($contact->notes): ?>
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Notes</h3>
                    <div class="prose max-w-none">
                        <p class="text-gray-800 whitespace-pre-wrap"><?php echo e($contact->notes); ?></p>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Historique des activités -->
            <?php if($activities->count() > 0): ?>
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Historique des activités</h3>
                    <div class="space-y-4">
                        <?php $__currentLoopData = $activities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="border-l-4 border-indigo-500 pl-4 py-2">
                                <div class="flex items-center justify-between mb-1">
                                    <p class="font-semibold text-gray-800"><?php echo e($activity->description ?? 'Activité'); ?></p>
                                    <span class="text-xs text-gray-500"><?php echo e($activity->created_at->translatedFormat('d/m/Y à H:i')); ?></span>
                                </div>
                                <?php if($activity->properties): ?>
                                    <p class="text-sm text-gray-600"><?php echo e(json_encode($activity->properties, JSON_PRETTY_PRINT)); ?></p>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Statistiques -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Statistiques</h3>
                <div class="space-y-3">
                    <div>
                        <span class="text-sm text-gray-600">Billets achetés:</span>
                        <p class="text-2xl font-bold text-indigo-600"><?php echo e($contact->tickets->count()); ?></p>
                    </div>
                    <div>
                        <span class="text-sm text-gray-600">Votes:</span>
                        <p class="text-2xl font-bold text-purple-600"><?php echo e($contact->votes->count()); ?></p>
                    </div>
                    <div>
                        <span class="text-sm text-gray-600">Dons:</span>
                        <p class="text-2xl font-bold text-green-600"><?php echo e($contact->donations->count()); ?></p>
                    </div>
                    <?php if($contact->total_spent > 0): ?>
                        <div>
                            <span class="text-sm text-gray-600">Total dépensé:</span>
                            <p class="text-2xl font-bold text-green-600"><?php echo e(number_format($contact->total_spent, 0, ',', ' ')); ?> XOF</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Dates importantes -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Dates importantes</h3>
                <div class="space-y-3">
                    <?php if($contact->last_contacted_at): ?>
                        <div>
                            <span class="text-sm text-gray-600">Dernier contact:</span>
                            <p class="text-sm font-semibold text-gray-800"><?php echo e($contact->last_contacted_at->translatedFormat('d/m/Y')); ?></p>
                        </div>
                    <?php endif; ?>
                    <?php if($contact->next_follow_up_at): ?>
                        <div>
                            <span class="text-sm text-gray-600">Prochain suivi:</span>
                            <p class="text-sm font-semibold text-gray-800"><?php echo e($contact->next_follow_up_at->translatedFormat('d/m/Y')); ?></p>
                        </div>
                    <?php endif; ?>
                    <div>
                        <span class="text-sm text-gray-600">Créé le:</span>
                        <p class="text-sm font-semibold text-gray-800"><?php echo e($contact->created_at->translatedFormat('d/m/Y')); ?></p>
                    </div>
                </div>
            </div>

            <!-- Statut -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Statut</h3>
                <div class="space-y-2">
                    <div>
                        <span class="px-3 py-1 text-sm font-semibold rounded-full <?php echo e($contact->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'); ?>">
                            <?php echo e($contact->is_active ? 'Actif' : 'Inactif'); ?>

                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Billets -->
    <?php if($contact->tickets->count() > 0): ?>
        <div class="mt-6 bg-white rounded-lg shadow-md p-6">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Billets achetés</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Événement</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Prix</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php $__currentLoopData = $contact->tickets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ticket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <?php if($ticket->event): ?>
                                        <a href="<?php echo e(route('events.show', $ticket->event)); ?>" class="text-indigo-600 hover:text-indigo-800">
                                            <?php echo e($ticket->event->title); ?>

                                        </a>
                                    <?php else: ?>
                                        N/A
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo e($ticket->ticketType->name ?? 'N/A'); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo e(number_format($ticket->price, 0, ',', ' ')); ?> XOF</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo e($ticket->created_at->translatedFormat('d/m/Y')); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 text-xs font-semibold rounded <?php echo e($ticket->status === 'paid' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'); ?>">
                                        <?php echo e(ucfirst($ticket->status)); ?>

                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\adoun\Music\Tikehub\resources\views/dashboard/organizer/crm/contacts/show.blade.php ENDPATH**/ ?>