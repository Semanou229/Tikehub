

<?php $__env->startSection('title', 'Collaborateurs - ' . $event->title); ?>

<?php $__env->startSection('content'); ?>
<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Gestion des Collaborateurs</h1>
            <p class="text-gray-600 mt-1"><?php echo e($event->title); ?></p>
        </div>
        <a href="<?php echo e(route('organizer.events.index')); ?>" class="text-indigo-600 hover:text-indigo-800">
            <i class="fas fa-arrow-left mr-2"></i>Retour aux événements
        </a>
    </div>

    <!-- Collaborateurs assignés -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Collaborateurs assignés</h2>
        <?php if($assignedCollaborators->count() > 0): ?>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nom</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Équipe</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php $__currentLoopData = $assignedCollaborators; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $collaborator): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center">
                                            <span class="text-indigo-600 font-semibold"><?php echo e(substr($collaborator->name, 0, 1)); ?></span>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900"><?php echo e($collaborator->name); ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <?php echo e($collaborator->email); ?>

                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <?php if($collaborator->hasRole('agent')): ?>
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">Agent</span>
                                    <?php elseif($collaborator->team_id): ?>
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Membre d'équipe</span>
                                    <?php else: ?>
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">Collaborateur</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <?php echo e($collaborator->team->name ?? 'N/A'); ?>

                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <form action="<?php echo e(route('organizer.events.collaborators.destroy', [$event, $collaborator])); ?>" method="POST" onsubmit="return confirm('Retirer ce collaborateur de l\'événement ?');">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="text-red-600 hover:text-red-900">
                                            <i class="fas fa-trash"></i> Retirer
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="text-gray-500 text-center py-8">Aucun collaborateur assigné pour le moment</p>
        <?php endif; ?>
    </div>

    <!-- Ajouter un collaborateur -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Ajouter un collaborateur</h2>
        
        <form action="<?php echo e(route('organizer.events.collaborators.store', $event)); ?>" method="POST">
            <?php echo csrf_field(); ?>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                <!-- Membres d'équipe -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Membres d'équipe</label>
                    <?php if($teamMembers->count() > 0): ?>
                        <select id="team_member_select" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">Sélectionner un membre d'équipe</option>
                            <?php $__currentLoopData = $teamMembers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($member->id); ?>" data-type="team_member">
                                    <?php echo e($member->name); ?> (<?php echo e($member->email); ?>) - <?php echo e($member->team->name ?? 'N/A'); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    <?php else: ?>
                        <p class="text-sm text-gray-500">Aucun membre d'équipe disponible. Créez une équipe dans la section CRM.</p>
                    <?php endif; ?>
                </div>

                <!-- Agents -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Agents</label>
                    <?php if($availableAgents->count() > 0): ?>
                        <select id="agent_select" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">Sélectionner un agent</option>
                            <?php $__currentLoopData = $availableAgents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $agent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($agent->id); ?>" data-type="agent">
                                    <?php echo e($agent->name); ?> (<?php echo e($agent->email); ?>)
                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    <?php else: ?>
                        <p class="text-sm text-gray-500">Aucun agent disponible.</p>
                    <?php endif; ?>
                </div>
            </div>

            <input type="hidden" name="type" id="collaborator_type" value="team_member">
            <input type="hidden" name="collaborator_id" id="collaborator_id_input" required>

            <div class="mt-6">
                <button type="submit" class="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition">
                    <i class="fas fa-plus mr-2"></i>Ajouter le collaborateur
                </button>
            </div>
        </form>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const teamMemberSelect = document.getElementById('team_member_select');
    const agentSelect = document.getElementById('agent_select');
    const typeInput = document.getElementById('collaborator_type');
    const collaboratorIdInput = document.getElementById('collaborator_id_input');

    function updateForm() {
        if (teamMemberSelect && teamMemberSelect.value) {
            collaboratorIdInput.value = teamMemberSelect.value;
            typeInput.value = 'team_member';
            if (agentSelect) agentSelect.value = '';
        } else if (agentSelect && agentSelect.value) {
            collaboratorIdInput.value = agentSelect.value;
            typeInput.value = 'agent';
            if (teamMemberSelect) teamMemberSelect.value = '';
        } else {
            collaboratorIdInput.value = '';
        }
    }

    if (teamMemberSelect) {
        teamMemberSelect.addEventListener('change', updateForm);
    }
    if (agentSelect) {
        agentSelect.addEventListener('change', updateForm);
    }

    // Validation du formulaire
    document.querySelector('form').addEventListener('submit', function(e) {
        if (!collaboratorIdInput.value) {
            e.preventDefault();
            alert('Veuillez sélectionner un collaborateur.');
            return false;
        }
    });
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\adoun\Music\Tikehub\resources\views/dashboard/organizer/events/collaborators.blade.php ENDPATH**/ ?>