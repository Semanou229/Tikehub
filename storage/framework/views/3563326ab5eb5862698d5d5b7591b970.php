

<?php $__env->startSection('title', 'Pipeline CRM'); ?>

<?php $__env->startSection('content'); ?>
<div class="p-6">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Pipeline CRM</h1>
        <p class="text-gray-600 mt-1">Gérez vos relations avec un système Kanban</p>
    </div>

    <!-- Statistiques -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <?php $__currentLoopData = ['prospect', 'confirmed', 'partner', 'closed']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="text-sm text-gray-600 mb-1"><?php echo e(ucfirst($stage)); ?></div>
                <div class="text-3xl font-bold text-indigo-600"><?php echo e($stats[$stage]); ?></div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <!-- Kanban Board -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6" id="kanbanBoard">
        <?php $__currentLoopData = ['prospect', 'confirmed', 'partner', 'closed']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="bg-gray-50 rounded-lg p-4 min-h-[600px]">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-bold text-gray-800"><?php echo e(ucfirst($stage)); ?></h3>
                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-indigo-100 text-indigo-800">
                        <?php echo e($contactsByStage[$stage]->count()); ?>

                    </span>
                </div>
                <div class="space-y-3" data-stage="<?php echo e($stage); ?>">
                    <?php $__currentLoopData = $contactsByStage[$stage]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $contact): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="bg-white rounded-lg shadow-sm p-4 cursor-move hover:shadow-md transition contact-card" 
                             data-contact-id="<?php echo e($contact->id); ?>"
                             draggable="true">
                            <div class="font-semibold text-gray-900 mb-1"><?php echo e($contact->full_name); ?></div>
                            <?php if($contact->company): ?>
                                <div class="text-xs text-gray-500 mb-2"><?php echo e($contact->company); ?></div>
                            <?php endif; ?>
                            <div class="flex items-center justify-between">
                                <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">
                                    <?php echo e(ucfirst($contact->category)); ?>

                                </span>
                                <?php if($contact->assignedUser): ?>
                                    <span class="text-xs text-gray-500"><?php echo e(Str::limit($contact->assignedUser->name, 10)); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
// Drag and Drop pour le pipeline Kanban
document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.contact-card');
    const columns = document.querySelectorAll('[data-stage]');

    cards.forEach(card => {
        card.addEventListener('dragstart', handleDragStart);
        card.addEventListener('dragend', handleDragEnd);
    });

    columns.forEach(column => {
        column.addEventListener('dragover', handleDragOver);
        column.addEventListener('drop', handleDrop);
    });

    let draggedElement = null;

    function handleDragStart(e) {
        draggedElement = this;
        this.style.opacity = '0.5';
        e.dataTransfer.effectAllowed = 'move';
    }

    function handleDragEnd(e) {
        this.style.opacity = '1';
    }

    function handleDragOver(e) {
        if (e.preventDefault) {
            e.preventDefault();
        }
        e.dataTransfer.dropEffect = 'move';
        return false;
    }

    function handleDrop(e) {
        if (e.stopPropagation) {
            e.stopPropagation();
        }

        if (draggedElement !== null) {
            const newStage = this.closest('[data-stage]').dataset.stage;
            const contactId = draggedElement.dataset.contactId;
            const oldStage = draggedElement.closest('[data-stage]').dataset.stage;

            if (newStage !== oldStage) {
                // Mettre à jour via AJAX
                fetch(`<?php echo e(route('organizer.crm.pipeline.updateStage', '')); ?>/${contactId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                    },
                    body: JSON.stringify({ pipeline_stage: newStage })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        this.appendChild(draggedElement);
                        location.reload(); // Recharger pour mettre à jour les statistiques
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    alert('Erreur lors de la mise à jour');
                });
            }
        }

        return false;
    }
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\adoun\Music\Tikehub\resources\views/dashboard/organizer/crm/pipeline/index.blade.php ENDPATH**/ ?>