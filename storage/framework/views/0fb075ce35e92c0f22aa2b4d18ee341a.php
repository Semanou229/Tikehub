

<?php $__env->startSection('title', 'Ticket #' . $ticket->ticket_number); ?>

<?php $__env->startSection('content'); ?>
<div class="p-6">
    <div class="mb-6">
        <a href="<?php echo e(route('admin.support.index')); ?>" class="text-red-600 hover:text-red-800 mb-4 inline-block">
            <i class="fas fa-arrow-left mr-2"></i>Retour à la liste
        </a>
        <div class="flex justify-between items-start">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Ticket #<?php echo e($ticket->ticket_number); ?></h1>
                <p class="text-gray-600 text-lg"><?php echo e($ticket->subject); ?></p>
            </div>
        </div>
    </div>

    <?php if(session('success')): ?>
        <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg mb-6">
            <i class="fas fa-check-circle mr-2"></i><?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Colonne principale -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Informations du ticket -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Description du problème</h2>
                <div class="prose max-w-none">
                    <p class="text-gray-800 whitespace-pre-wrap"><?php echo e($ticket->description); ?></p>
                </div>
            </div>

            <!-- Messages -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-6">Conversation</h2>
                
                <div class="space-y-6">
                    <?php $__currentLoopData = $ticket->messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if(!$message->is_internal || auth()->user()->isAdmin()): ?>
                            <div class="flex <?php echo e($message->isFromUser() ? 'justify-end' : 'justify-start'); ?>">
                                <div class="max-w-3xl <?php echo e($message->isFromUser() ? 'bg-gray-50 border-gray-200' : ($message->is_internal ? 'bg-yellow-50 border-yellow-200' : 'bg-blue-50 border-blue-200')); ?> border rounded-lg p-4">
                                    <div class="flex items-center justify-between mb-2">
                                        <div class="flex items-center">
                                            <?php if($message->user->avatar): ?>
                                                <img src="<?php echo e(asset('storage/' . $message->user->avatar)); ?>" alt="<?php echo e($message->user->name); ?>" class="w-8 h-8 rounded-full mr-2">
                                            <?php else: ?>
                                                <div class="w-8 h-8 rounded-full <?php echo e($message->isFromUser() ? 'bg-gray-600' : 'bg-blue-600'); ?> flex items-center justify-center text-white text-sm font-semibold mr-2">
                                                    <?php echo e(strtoupper(substr($message->user->name, 0, 1))); ?>

                                                </div>
                                            <?php endif; ?>
                                            <div>
                                                <p class="font-semibold text-gray-800"><?php echo e($message->user->name); ?></p>
                                                <p class="text-xs text-gray-500"><?php echo e($message->created_at->translatedFormat('d/m/Y à H:i')); ?></p>
                                            </div>
                                        </div>
                                        <?php if($message->is_internal): ?>
                                            <span class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs rounded">Note interne</span>
                                        <?php elseif($message->isFromAdmin()): ?>
                                            <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded">Support</span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="text-gray-800 whitespace-pre-wrap"><?php echo e($message->message); ?></div>
                                    
                                    <?php if($message->attachments && count($message->attachments) > 0): ?>
                                        <div class="mt-4 pt-4 border-t border-gray-200">
                                            <p class="text-sm font-semibold text-gray-700 mb-2">Pièces jointes :</p>
                                            <div class="flex flex-wrap gap-2">
                                                <?php $__currentLoopData = $message->attachments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attachment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <a href="<?php echo e(asset('storage/' . $attachment['path'])); ?>" target="_blank" class="inline-flex items-center px-3 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg transition">
                                                        <i class="fas fa-paperclip mr-2"></i>
                                                        <span class="text-sm"><?php echo e($attachment['name']); ?></span>
                                                    </a>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>

            <!-- Formulaire de réponse -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Répondre au ticket</h3>
                <form method="POST" action="<?php echo e(route('admin.support.reply', $ticket)); ?>" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="mb-4">
                        <textarea name="message" 
                                  rows="6"
                                  required
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500"
                                  placeholder="Tapez votre réponse..."></textarea>
                    </div>
                    <div class="mb-4">
                        <label class="flex items-center">
                            <input type="checkbox" name="is_internal" value="1" class="rounded border-gray-300 text-red-600 focus:ring-red-500">
                            <span class="ml-2 text-sm text-gray-700">Note interne (visible uniquement par les admins)</span>
                        </label>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Pièces jointes (optionnel)</label>
                        <input type="file" 
                               name="attachments[]" 
                               multiple
                               accept="image/*,.pdf,.doc,.docx"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500">
                        <p class="mt-1 text-xs text-gray-500">Formats acceptés : images, PDF, Word. Taille max : 5MB par fichier.</p>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700 transition">
                            <i class="fas fa-paper-plane mr-2"></i>Envoyer
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Informations -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Informations</h3>
                <div class="space-y-4">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Utilisateur</p>
                        <p class="font-semibold text-gray-800"><?php echo e($ticket->user->name); ?></p>
                        <p class="text-sm text-gray-600"><?php echo e($ticket->user->email); ?></p>
                        <span class="inline-block mt-1 px-2 py-1 text-xs rounded <?php echo e($ticket->type == 'organizer' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800'); ?>">
                            <?php echo e($ticket->type == 'organizer' ? 'Organisateur' : 'Client'); ?>

                        </span>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Créé le</p>
                        <p class="text-sm text-gray-800"><?php echo e($ticket->created_at->translatedFormat('d/m/Y à H:i')); ?></p>
                    </div>
                    <?php if($ticket->last_replied_at): ?>
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Dernière réponse</p>
                            <p class="text-sm text-gray-800"><?php echo e($ticket->last_replied_at->translatedFormat('d/m/Y à H:i')); ?></p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Statut -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Statut</h3>
                <form method="POST" action="<?php echo e(route('admin.support.status', $ticket)); ?>" class="mb-4">
                    <?php echo csrf_field(); ?>
                    <select name="status" onchange="this.form.submit()" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500">
                        <option value="open" <?php echo e($ticket->status == 'open' ? 'selected' : ''); ?>>Ouvert</option>
                        <option value="in_progress" <?php echo e($ticket->status == 'in_progress' ? 'selected' : ''); ?>>En cours</option>
                        <option value="resolved" <?php echo e($ticket->status == 'resolved' ? 'selected' : ''); ?>>Résolu</option>
                        <option value="closed" <?php echo e($ticket->status == 'closed' ? 'selected' : ''); ?>>Fermé</option>
                    </select>
                </form>
            </div>

            <!-- Priorité -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Priorité</h3>
                <form method="POST" action="<?php echo e(route('admin.support.priority', $ticket)); ?>">
                    <?php echo csrf_field(); ?>
                    <select name="priority" onchange="this.form.submit()" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500">
                        <option value="low" <?php echo e($ticket->priority == 'low' ? 'selected' : ''); ?>>Basse</option>
                        <option value="medium" <?php echo e($ticket->priority == 'medium' ? 'selected' : ''); ?>>Moyenne</option>
                        <option value="high" <?php echo e($ticket->priority == 'high' ? 'selected' : ''); ?>>Haute</option>
                        <option value="urgent" <?php echo e($ticket->priority == 'urgent' ? 'selected' : ''); ?>>Urgente</option>
                    </select>
                </form>
            </div>

            <!-- Assignation -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Assignation</h3>
                <form method="POST" action="<?php echo e(route('admin.support.assign', $ticket)); ?>">
                    <?php echo csrf_field(); ?>
                    <select name="assigned_to" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 mb-3">
                        <option value="">Non assigné</option>
                        <?php $__currentLoopData = \App\Models\User::role('admin')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $admin): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($admin->id); ?>" <?php echo e($ticket->assigned_to == $admin->id ? 'selected' : ''); ?>><?php echo e($admin->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <button type="submit" class="w-full bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition">
                        Assigner
                    </button>
                </form>
                <?php if($ticket->assignedTo): ?>
                    <p class="mt-3 text-sm text-gray-600">
                        Actuellement assigné à : <strong><?php echo e($ticket->assignedTo->name); ?></strong>
                    </p>
                <?php endif; ?>
            </div>

            <!-- Actions -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Actions</h3>
                <form method="POST" action="<?php echo e(route('admin.support.destroy', $ticket)); ?>" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce ticket ? Cette action est irréversible.');">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="w-full bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition">
                        <i class="fas fa-trash mr-2"></i>Supprimer le ticket
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\adoun\Music\Tikehub\resources\views/admin/support/show.blade.php ENDPATH**/ ?>