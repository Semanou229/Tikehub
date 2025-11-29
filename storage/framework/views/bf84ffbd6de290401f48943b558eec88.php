

<?php $__env->startSection('title', $team->name); ?>

<?php $__env->startSection('content'); ?>
<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold text-gray-800"><?php echo e($team->name); ?></h1>
        <div class="flex gap-2">
            <a href="<?php echo e(route('organizer.crm.teams.edit', $team)); ?>" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
                <i class="fas fa-edit mr-2"></i>Modifier
            </a>
            <a href="<?php echo e(route('organizer.crm.teams.index')); ?>" class="text-gray-600 hover:text-gray-800 px-4 py-2">
                <i class="fas fa-arrow-left mr-2"></i>Retour
            </a>
        </div>
    </div>

    <?php if($team->description): ?>
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <p class="text-gray-700"><?php echo e($team->description); ?></p>
        </div>
    <?php endif; ?>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="text-3xl font-bold text-indigo-600"><?php echo e($stats['members_count']); ?></div>
            <div class="text-sm text-gray-600 mt-1">Membres</div>
        </div>
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="text-3xl font-bold text-yellow-600"><?php echo e($stats['tasks_todo'] + $stats['tasks_in_progress']); ?></div>
            <div class="text-sm text-gray-600 mt-1">Tâches en cours</div>
        </div>
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="text-3xl font-bold text-green-600"><?php echo e($stats['tasks_done']); ?></div>
            <div class="text-sm text-gray-600 mt-1">Tâches terminées</div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Membres -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold text-gray-800">Membres</h2>
                <button onclick="showAddMemberModal()" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition text-sm">
                    <i class="fas fa-plus mr-2"></i>Ajouter
                </button>
            </div>
            
            <?php if($team->members->count() > 0): ?>
                <div class="space-y-3">
                    <?php $__currentLoopData = $team->members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="flex items-center justify-between p-3 border border-gray-200 rounded-lg">
                            <div>
                                <div class="font-semibold text-gray-800"><?php echo e($member->name); ?></div>
                                <div class="text-sm text-gray-600"><?php echo e($member->email); ?></div>
                                <div class="text-xs text-indigo-600 mt-1"><?php echo e(ucfirst($member->team_role)); ?></div>
                            </div>
                            <form action="<?php echo e(route('organizer.crm.teams.removeMember', [$team, $member])); ?>" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir retirer ce membre ?')">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="text-red-600 hover:text-red-800">
                                    <i class="fas fa-times"></i>
                                </button>
                            </form>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php else: ?>
                <p class="text-gray-500 text-center py-8">Aucun membre dans cette équipe</p>
            <?php endif; ?>
        </div>

        <!-- Tâches -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold text-gray-800">Tâches</h2>
                <a href="<?php echo e(route('organizer.crm.teams.tasks.create', $team)); ?>" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition text-sm">
                    <i class="fas fa-plus mr-2"></i>Nouvelle tâche
                </a>
            </div>
            
            <?php if($team->tasks->count() > 0): ?>
                <div class="space-y-3">
                    <?php $__currentLoopData = $team->tasks->take(10); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="p-3 border border-gray-200 rounded-lg">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="font-semibold text-gray-800"><?php echo e($task->title); ?></div>
                                    <?php if($task->description): ?>
                                        <div class="text-sm text-gray-600 mt-1"><?php echo e(Str::limit($task->description, 50)); ?></div>
                                    <?php endif; ?>
                                    <div class="flex items-center gap-4 mt-2 text-xs text-gray-500">
                                        <?php if($task->assignee): ?>
                                            <span><i class="fas fa-user mr-1"></i><?php echo e($task->assignee->name); ?></span>
                                        <?php endif; ?>
                                        <?php if($task->due_date): ?>
                                            <span><i class="fas fa-calendar mr-1"></i><?php echo e($task->due_date->format('d/m/Y')); ?></span>
                                        <?php endif; ?>
                                        <span class="px-2 py-1 rounded <?php echo e($task->status === 'done' ? 'bg-green-100 text-green-800' : ($task->status === 'in_progress' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800')); ?>">
                                            <?php echo e(ucfirst($task->status)); ?>

                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php if($team->tasks->count() > 10): ?>
                    <div class="mt-4 text-center">
                        <a href="<?php echo e(route('organizer.crm.teams.tasks.index', $team)); ?>" class="text-indigo-600 hover:text-indigo-800">
                            Voir toutes les tâches (<?php echo e($team->tasks->count()); ?>)
                        </a>
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <p class="text-gray-500 text-center py-8">Aucune tâche assignée</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Modal pour ajouter un membre -->
<div id="addMemberModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
    <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-xl font-bold text-gray-800">Ajouter un membre</h3>
            <button onclick="hideAddMemberModal()" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <form action="<?php echo e(route('organizer.crm.teams.addMember', $team)); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Utilisateur *</label>
                    <select name="user_id" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                        <option value="">Sélectionner un utilisateur</option>
                        <?php $__currentLoopData = \App\Models\User::where('id', '!=', auth()->id())->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($user->id); ?>"><?php echo e($user->name); ?> (<?php echo e($user->email); ?>)</option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Rôle *</label>
                    <select name="team_role" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                        <option value="staff">Staff</option>
                        <option value="manager">Manager</option>
                        <option value="agent">Agent</option>
                        <option value="volunteer">Bénévole</option>
                    </select>
                </div>
            </div>
            
            <div class="mt-6 flex gap-4">
                <button type="submit" class="flex-1 bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
                    Ajouter
                </button>
                <button type="button" onclick="hideAddMemberModal()" class="flex-1 bg-gray-200 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-300 transition">
                    Annuler
                </button>
            </div>
        </form>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
function showAddMemberModal() {
    document.getElementById('addMemberModal').classList.remove('hidden');
}

function hideAddMemberModal() {
    document.getElementById('addMemberModal').classList.add('hidden');
}
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\adoun\Music\Tikehub\resources\views/dashboard/organizer/crm/teams/show.blade.php ENDPATH**/ ?>