

<?php $__env->startSection('title', 'Ticket #' . $ticket->ticket_number); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6">
        <a href="<?php echo e(route('support.tickets.index')); ?>" class="text-indigo-600 hover:text-indigo-800 mb-4 inline-flex items-center">
            <i class="fas fa-arrow-left mr-2"></i>Retour aux tickets
        </a>
        <div class="flex justify-between items-start">
            <div>
                <h1 class="text-3xl font-bold text-gray-800 mb-2">Ticket #<?php echo e($ticket->ticket_number); ?></h1>
                <p class="text-gray-600 text-lg"><?php echo e($ticket->subject); ?></p>
            </div>
            <div class="flex gap-2">
                <?php if(!$ticket->isClosed()): ?>
                    <form method="POST" action="<?php echo e(route('support.tickets.close', $ticket)); ?>" class="inline">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition" onclick="return confirm('Êtes-vous sûr de vouloir fermer ce ticket ?')">
                            <i class="fas fa-lock mr-2"></i>Fermer
                        </button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php if(session('success')): ?>
        <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg mb-6">
            <i class="fas fa-check-circle mr-2"></i><?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg mb-6">
            <i class="fas fa-exclamation-circle mr-2"></i><?php echo e(session('error')); ?>

        </div>
    <?php endif; ?>

    <!-- Infos du ticket -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <p class="text-sm text-gray-500 mb-1">Statut</p>
                <span class="px-3 py-1 rounded-full text-sm font-semibold
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
            </div>
            <div>
                <p class="text-sm text-gray-500 mb-1">Priorité</p>
                <span class="px-3 py-1 rounded-full text-sm font-semibold
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
            <div>
                <p class="text-sm text-gray-500 mb-1">Créé le</p>
                <p class="text-sm font-semibold text-gray-800"><?php echo e($ticket->created_at->translatedFormat('d/m/Y à H:i')); ?></p>
            </div>
            <?php if($ticket->assignedTo): ?>
                <div>
                    <p class="text-sm text-gray-500 mb-1">Assigné à</p>
                    <p class="text-sm font-semibold text-gray-800"><?php echo e($ticket->assignedTo->name); ?></p>
                </div>
            <?php endif; ?>
            <?php if($ticket->last_replied_at): ?>
                <div>
                    <p class="text-sm text-gray-500 mb-1">Dernière réponse</p>
                    <p class="text-sm font-semibold text-gray-800"><?php echo e($ticket->last_replied_at->translatedFormat('d/m/Y à H:i')); ?></p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Messages -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h2 class="text-xl font-bold text-gray-800 mb-6">Conversation</h2>
        
        <div class="space-y-6">
            <?php $__currentLoopData = $ticket->publicMessages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="flex <?php echo e($message->isFromUser() ? 'justify-end' : 'justify-start'); ?>">
                    <div class="max-w-3xl <?php echo e($message->isFromUser() ? 'bg-indigo-50 border-indigo-200' : 'bg-gray-50 border-gray-200'); ?> border rounded-lg p-4">
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center">
                                <?php if($message->user->avatar): ?>
                                    <img src="<?php echo e(asset('storage/' . $message->user->avatar)); ?>" alt="<?php echo e($message->user->name); ?>" class="w-8 h-8 rounded-full mr-2">
                                <?php else: ?>
                                    <div class="w-8 h-8 rounded-full <?php echo e($message->isFromUser() ? 'bg-indigo-600' : 'bg-gray-600'); ?> flex items-center justify-center text-white text-sm font-semibold mr-2">
                                        <?php echo e(strtoupper(substr($message->user->name, 0, 1))); ?>

                                    </div>
                                <?php endif; ?>
                                <div>
                                    <p class="font-semibold text-gray-800"><?php echo e($message->user->name); ?></p>
                                    <p class="text-xs text-gray-500"><?php echo e($message->created_at->translatedFormat('d/m/Y à H:i')); ?></p>
                                </div>
                            </div>
                            <?php if($message->isFromAdmin()): ?>
                                <span class="px-2 py-1 bg-indigo-100 text-indigo-800 text-xs rounded">Support</span>
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
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>

    <!-- Formulaire de réponse -->
    <?php if(!$ticket->isClosed()): ?>
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Répondre au ticket</h3>
            <form method="POST" action="<?php echo e(route('support.tickets.reply', $ticket)); ?>" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="mb-4">
                    <textarea name="message" 
                              rows="6"
                              required
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                              placeholder="Tapez votre message..."></textarea>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Pièces jointes (optionnel)</label>
                    <input type="file" 
                           name="attachments[]" 
                           multiple
                           accept="image/*,.pdf,.doc,.docx"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    <p class="mt-1 text-xs text-gray-500">Formats acceptés : images, PDF, Word. Taille max : 5MB par fichier.</p>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 transition">
                        <i class="fas fa-paper-plane mr-2"></i>Envoyer
                    </button>
                </div>
            </form>
        </div>
    <?php else: ?>
        <div class="bg-gray-50 border border-gray-200 rounded-lg p-6 text-center">
            <i class="fas fa-lock text-4xl text-gray-400 mb-4"></i>
            <p class="text-gray-600 font-semibold mb-2">Ce ticket est fermé</p>
            <p class="text-gray-500 text-sm">Vous ne pouvez plus répondre à ce ticket. Créez un nouveau ticket si vous avez besoin d'aide.</p>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\adoun\Music\Tikehub\resources\views/support/tickets/show.blade.php ENDPATH**/ ?>