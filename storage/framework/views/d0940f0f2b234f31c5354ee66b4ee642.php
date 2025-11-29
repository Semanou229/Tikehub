

<?php $__env->startSection('title', 'Contacts CRM'); ?>

<?php $__env->startSection('content'); ?>
<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Contacts CRM</h1>
            <p class="text-gray-600 mt-1">Gérez tous vos contacts et relations</p>
        </div>
        <div class="flex gap-3">
            <button onclick="document.getElementById('importModal').classList.remove('hidden')" class="bg-gray-600 text-white px-6 py-3 rounded-lg hover:bg-gray-700 transition">
                <i class="fas fa-file-import mr-2"></i>Importer CSV/Excel
            </button>
            <a href="<?php echo e(route('organizer.crm.contacts.create')); ?>" class="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition">
                <i class="fas fa-plus mr-2"></i>Nouveau contact
            </a>
        </div>
    </div>

    <!-- Statistiques -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="text-sm text-gray-600 mb-1">Total contacts</div>
            <div class="text-3xl font-bold text-indigo-600"><?php echo e($stats['total']); ?></div>
        </div>
        <?php $__currentLoopData = ['participant', 'sponsor', 'vip', 'staff']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="text-sm text-gray-600 mb-1"><?php echo e(ucfirst($cat)); ?>s</div>
                <div class="text-3xl font-bold text-purple-600"><?php echo e($stats['by_category'][$cat] ?? 0); ?></div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <!-- Filtres -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <form method="GET" action="<?php echo e(route('organizer.crm.contacts.index')); ?>" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Recherche</label>
                <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Nom, email, téléphone..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Catégorie</label>
                <select name="category" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                    <option value="">Toutes</option>
                    <?php $__currentLoopData = ['participant', 'sponsor', 'staff', 'press', 'vip', 'partner', 'prospect']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($cat); ?>" <?php echo e(request('category') == $cat ? 'selected' : ''); ?>><?php echo e(ucfirst($cat)); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Pipeline</label>
                <select name="pipeline_stage" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                    <option value="">Tous</option>
                    <?php $__currentLoopData = ['prospect', 'confirmed', 'partner', 'closed']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($stage); ?>" <?php echo e(request('pipeline_stage') == $stage ? 'selected' : ''); ?>><?php echo e(ucfirst($stage)); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="flex items-end gap-2">
                <button type="submit" class="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition w-full">
                    <i class="fas fa-search mr-2"></i>Filtrer
                </button>
                <a href="<?php echo e(route('organizer.crm.contacts.index')); ?>" class="bg-gray-200 text-gray-700 px-4 py-3 rounded-lg hover:bg-gray-300 transition">
                    <i class="fas fa-times"></i>
                </a>
            </div>
        </form>
    </div>

    <!-- Liste des contacts -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Contact</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Catégorie</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pipeline</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Assigné à</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php $__empty_1 = true; $__currentLoopData = $contacts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $contact): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <div class="font-semibold text-gray-900"><?php echo e($contact->full_name); ?></div>
                            <div class="text-sm text-gray-500">
                                <?php if($contact->email): ?>
                                    <i class="fas fa-envelope mr-1"></i><?php echo e($contact->email); ?>

                                <?php endif; ?>
                                <?php if($contact->phone): ?>
                                    <span class="ml-3"><i class="fas fa-phone mr-1"></i><?php echo e($contact->phone); ?></span>
                                <?php endif; ?>
                            </div>
                            <?php if($contact->company): ?>
                                <div class="text-xs text-gray-400 mt-1"><?php echo e($contact->company); ?></div>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                <?php echo e(ucfirst($contact->category)); ?>

                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                <?php echo e($contact->pipeline_stage === 'prospect' ? 'bg-yellow-100 text-yellow-800' : ''); ?>

                                <?php echo e($contact->pipeline_stage === 'confirmed' ? 'bg-green-100 text-green-800' : ''); ?>

                                <?php echo e($contact->pipeline_stage === 'partner' ? 'bg-purple-100 text-purple-800' : ''); ?>

                                <?php echo e($contact->pipeline_stage === 'closed' ? 'bg-gray-100 text-gray-800' : ''); ?>">
                                <?php echo e(ucfirst($contact->pipeline_stage)); ?>

                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            <?php echo e($contact->assignedUser->name ?? 'Non assigné'); ?>

                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <a href="<?php echo e(route('organizer.crm.contacts.show', $contact)); ?>" class="text-indigo-600 hover:text-indigo-900" title="Voir">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="<?php echo e(route('organizer.crm.contacts.edit', $contact)); ?>" class="text-gray-600 hover:text-gray-900" title="Modifier">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                            <i class="fas fa-address-book text-4xl mb-3 text-gray-300"></i>
                            <p>Aucun contact trouvé</p>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php if($contacts->hasPages()): ?>
        <div class="mt-4">
            <?php echo e($contacts->links()); ?>

        </div>
    <?php endif; ?>
</div>

<!-- Modal Import -->
<div id="importModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-xl font-bold text-gray-800">Importer des contacts</h3>
            <button onclick="document.getElementById('importModal').classList.add('hidden')" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form action="<?php echo e(route('organizer.crm.contacts.import')); ?>" method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Fichier CSV/Excel</label>
                <input type="file" name="file" accept=".csv,.xlsx,.xls" required class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                <p class="text-xs text-gray-500 mt-1">Colonnes attendues: Prénom, Nom, Email, Téléphone, Entreprise</p>
            </div>
            <div class="flex gap-3">
                <button type="submit" class="flex-1 bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition">
                    <i class="fas fa-upload mr-2"></i>Importer
                </button>
                <button type="button" onclick="document.getElementById('importModal').classList.add('hidden')" class="bg-gray-200 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-300 transition">
                    Annuler
                </button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\adoun\Music\Tikehub\resources\views/dashboard/organizer/crm/contacts/index.blade.php ENDPATH**/ ?>