

<?php $__env->startSection('title', 'Soumissions - ' . $form->name); ?>

<?php $__env->startSection('content'); ?>
<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Soumissions</h1>
            <p class="text-gray-600 mt-1"><?php echo e($form->name); ?></p>
        </div>
        <a href="<?php echo e(route('organizer.crm.forms.show', $form)); ?>" class="text-indigo-600 hover:text-indigo-800">
            <i class="fas fa-arrow-left mr-2"></i>Retour au formulaire
        </a>
    </div>

    <!-- Liste des soumissions -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Soumissionnaire</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php $__empty_1 = true; $__currentLoopData = $submissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $submission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <div class="font-semibold text-gray-900"><?php echo e($submission->submitter_name ?? 'N/A'); ?></div>
                            <?php if($submission->submitter_email): ?>
                                <div class="text-sm text-gray-500"><?php echo e($submission->submitter_email); ?></div>
                            <?php endif; ?>
                            <?php if($submission->submitter_phone): ?>
                                <div class="text-xs text-gray-400"><?php echo e($submission->submitter_phone); ?></div>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            <?php echo e($submission->created_at->format('d/m/Y H:i')); ?>

                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full
                                <?php echo e($submission->status === 'approved' ? 'bg-green-100 text-green-800' : ''); ?>

                                <?php echo e($submission->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : ''); ?>

                                <?php echo e($submission->status === 'rejected' ? 'bg-red-100 text-red-800' : ''); ?>

                                <?php echo e($submission->status === 'archived' ? 'bg-gray-100 text-gray-800' : ''); ?>">
                                <?php echo e(ucfirst($submission->status)); ?>

                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <button onclick="showSubmission(<?php echo e($submission->id); ?>)" class="text-indigo-600 hover:text-indigo-900" title="Voir">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <?php if($submission->status === 'pending' && $form->requires_approval): ?>
                                    <form action="<?php echo e(route('organizer.crm.forms.submissions.approve', [$form, $submission])); ?>" method="POST" class="inline">
                                        <?php echo csrf_field(); ?>
                                        <input type="hidden" name="status" value="approved">
                                        <button type="submit" class="text-green-600 hover:text-green-900" title="Approuver" onclick="return confirm('Approuver cette soumission ?')">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                    <form action="<?php echo e(route('organizer.crm.forms.submissions.approve', [$form, $submission])); ?>" method="POST" class="inline">
                                        <?php echo csrf_field(); ?>
                                        <input type="hidden" name="status" value="rejected">
                                        <button type="submit" class="text-red-600 hover:text-red-900" title="Rejeter" onclick="return confirm('Rejeter cette soumission ?')">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                            <i class="fas fa-inbox text-4xl mb-3 text-gray-300"></i>
                            <p>Aucune soumission trouvée</p>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php if($submissions->hasPages()): ?>
        <div class="mt-4">
            <?php echo e($submissions->links()); ?>

        </div>
    <?php endif; ?>
</div>

<!-- Modal pour afficher les détails d'une soumission -->
<div id="submissionModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 max-w-2xl w-full mx-4 max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-xl font-bold text-gray-800">Détails de la soumission</h3>
            <button onclick="closeSubmission()" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div id="submissionContent">
            <!-- Le contenu sera chargé ici -->
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
function showSubmission(id) {
    // Charger les détails de la soumission via AJAX
    fetch(`/organizer/crm/forms/<?php echo e($form->id); ?>/submissions/${id}`)
        .then(response => response.json())
        .then(data => {
            let html = '<div class="space-y-4">';
            html += `<div><strong>Nom:</strong> ${data.submitter_name || 'N/A'}</div>`;
            html += `<div><strong>Email:</strong> ${data.submitter_email || 'N/A'}</div>`;
            html += `<div><strong>Téléphone:</strong> ${data.submitter_phone || 'N/A'}</div>`;
            html += '<div class="mt-4"><strong>Données soumises:</strong></div>';
            html += '<div class="bg-gray-50 rounded-lg p-4">';
            for (let key in data.form_data) {
                html += `<div class="mb-2"><strong>${key}:</strong> ${data.form_data[key]}</div>`;
            }
            html += '</div>';
            if (data.admin_notes) {
                html += `<div class="mt-4"><strong>Notes admin:</strong> ${data.admin_notes}</div>`;
            }
            html += '</div>';
            document.getElementById('submissionContent').innerHTML = html;
            document.getElementById('submissionModal').classList.remove('hidden');
        })
        .catch(error => {
            console.error('Erreur:', error);
            alert('Erreur lors du chargement de la soumission');
        });
}

function closeSubmission() {
    document.getElementById('submissionModal').classList.add('hidden');
}
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\adoun\Music\Tikehub\resources\views/dashboard/organizer/crm/forms/submissions.blade.php ENDPATH**/ ?>