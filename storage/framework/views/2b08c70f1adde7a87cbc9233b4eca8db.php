<?php $__env->startSection('title', 'Créer un Concours'); ?>

<?php $__env->startSection('content'); ?>
<div class="p-3 sm:p-4 lg:p-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 sm:gap-0 mb-4 sm:mb-6">
        <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-800">Créer un Concours</h1>
        <a href="<?php echo e(route('dashboard')); ?>" class="text-indigo-600 hover:text-indigo-800 active:text-indigo-900 min-h-[44px] flex items-center justify-center sm:justify-start">
            <i class="fas fa-arrow-left mr-2"></i>Retour
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md p-4 sm:p-6">
        <form action="<?php echo e(route('contests.store')); ?>" method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            
            <div class="space-y-6">
                <!-- Informations de base -->
                <div>
                    <h2 class="text-lg sm:text-xl font-bold text-gray-800 mb-3 sm:mb-4">Informations de base</h2>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nom du concours *</label>
                            <input type="text" name="name" value="<?php echo e(old('name')); ?>" required class="w-full px-3 sm:px-4 py-2.5 sm:py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 text-sm sm:text-base min-h-[44px]" placeholder="Ex: Miss Bénin 2025">
                            <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Description *</label>
                            <textarea name="description" rows="5" required class="w-full px-3 sm:px-4 py-2.5 sm:py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 text-sm sm:text-base min-h-[120px]" placeholder="Décrivez votre concours..."><?php echo e(old('description')); ?></textarea>
                            <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Règles du concours</label>
                            <textarea name="rules" rows="4" class="w-full px-3 sm:px-4 py-2.5 sm:py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 text-sm sm:text-base min-h-[96px]" placeholder="Règles et conditions de participation..."><?php echo e(old('rules')); ?></textarea>
                            <?php $__errorArgs = ['rules'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Image de couverture</label>
                            <input type="file" name="cover_image" accept="image/*" class="w-full px-3 sm:px-4 py-2.5 sm:py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 text-sm min-h-[44px]">
                            <?php $__errorArgs = ['cover_image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            <p class="text-sm text-gray-500 mt-1">Format: JPG, PNG (max 2MB)</p>
                        </div>
                    </div>
                </div>

                <!-- Paramètres de vote -->
                <div>
                    <h2 class="text-lg sm:text-xl font-bold text-gray-800 mb-3 sm:mb-4">Paramètres de vote</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 sm:gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Prix par vote (XOF) *</label>
                            <input type="number" name="price_per_vote" value="<?php echo e(old('price_per_vote')); ?>" min="0" step="0.01" required class="w-full px-3 sm:px-4 py-2.5 sm:py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 text-sm sm:text-base min-h-[44px]" placeholder="100">
                            <?php $__errorArgs = ['price_per_vote'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Points par vote *</label>
                            <input type="number" name="points_per_vote" value="<?php echo e(old('points_per_vote', 1)); ?>" min="1" required class="w-full px-3 sm:px-4 py-2.5 sm:py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 text-sm sm:text-base min-h-[44px]" placeholder="1">
                            <?php $__errorArgs = ['points_per_vote'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            <p class="text-sm text-gray-500 mt-1">Nombre de points attribués par vote</p>
                        </div>
                    </div>
                </div>

                <!-- Dates -->
                <div>
                    <h2 class="text-lg sm:text-xl font-bold text-gray-800 mb-3 sm:mb-4">Dates</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 sm:gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Date de début *</label>
                            <input type="datetime-local" name="start_date" value="<?php echo e(old('start_date')); ?>" required class="w-full px-3 sm:px-4 py-2.5 sm:py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 text-sm sm:text-base min-h-[44px]">
                            <?php $__errorArgs = ['start_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Date de fin *</label>
                            <input type="datetime-local" name="end_date" value="<?php echo e(old('end_date')); ?>" required class="w-full px-3 sm:px-4 py-2.5 sm:py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 text-sm sm:text-base min-h-[44px]">
                            <?php $__errorArgs = ['end_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                </div>

                <!-- Événement associé (optionnel) -->
                <div>
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Événement associé (optionnel)</h2>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Lier à un événement</label>
                        <select name="event_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                            <option value="">Aucun événement</option>
                            <?php $__currentLoopData = \App\Models\Event::where('organizer_id', auth()->id())->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($event->id); ?>" <?php echo e(old('event_id') == $event->id ? 'selected' : ''); ?>>
                                    <?php echo e($event->title); ?> (<?php echo e($event->start_date->format('d/m/Y')); ?>)
                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php $__errorArgs = ['event_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        <p class="text-sm text-gray-500 mt-1">Vous pouvez associer ce concours à un événement existant</p>
                    </div>
                </div>

                <!-- Candidats -->
                <div class="bg-purple-50 border-2 border-purple-200 rounded-lg p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h2 class="text-xl font-bold text-gray-800 flex items-center">
                                <i class="fas fa-users text-purple-600 mr-2"></i>
                                Candidats / Candidates
                            </h2>
                            <p class="text-sm text-gray-600 mt-1">Ajoutez les candidats qui participeront à ce concours</p>
                        </div>
                        <button type="button" id="addCandidateBtn" class="bg-purple-600 text-white px-3 sm:px-5 lg:px-6 py-2 sm:py-2.5 lg:py-3 rounded-lg hover:bg-purple-700 active:bg-purple-800 transition font-semibold shadow-md hover:shadow-lg text-xs sm:text-sm lg:text-base min-h-[40px] sm:min-h-[44px] flex items-center justify-center w-full sm:w-auto">
                            <i class="fas fa-plus text-xs sm:text-sm mr-1.5 sm:mr-2"></i><span class="hidden sm:inline">Ajouter un candidat</span><span class="sm:hidden">Ajouter</span>
                        </button>
                    </div>
                    
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3 mb-4">
                        <div class="flex items-start">
                            <i class="fas fa-exclamation-triangle text-yellow-600 mt-1 mr-2"></i>
                            <p class="text-sm text-yellow-800">
                                <strong>Important :</strong> Vous devez ajouter au moins un candidat pour pouvoir publier le concours. 
                                Les candidats peuvent être ajoutés maintenant ou plus tard depuis la page de modification.
                            </p>
                        </div>
                    </div>
                    
                    <div id="candidatesContainer" class="space-y-4">
                        <!-- Les candidats seront ajoutés ici dynamiquement -->
                    </div>
                    
                    <div id="noCandidatesMessage" class="text-center py-8 text-gray-500">
                        <i class="fas fa-user-plus text-4xl mb-3 text-gray-300"></i>
                        <p class="text-sm">Aucun candidat ajouté pour le moment. Cliquez sur "Ajouter un candidat" pour commencer.</p>
                    </div>
                    
                    <?php $__errorArgs = ['candidates'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-red-500 text-sm mt-2"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    <?php $__errorArgs = ['candidates.*'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-red-500 text-sm mt-2"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            <div class="mt-6 sm:mt-8 flex flex-col sm:flex-row items-stretch sm:items-center gap-2.5 sm:gap-4">
                <button type="submit" class="bg-purple-600 text-white px-4 sm:px-6 lg:px-8 py-2.5 sm:py-3 rounded-lg hover:bg-purple-700 active:bg-purple-800 transition font-semibold text-xs sm:text-sm lg:text-base min-h-[40px] sm:min-h-[44px] flex items-center justify-center shadow-md hover:shadow-lg">
                    <i class="fas fa-save text-xs sm:text-sm mr-1.5 sm:mr-2"></i>Créer le concours
                </button>
                <a href="<?php echo e(route('dashboard')); ?>" class="text-gray-600 hover:text-gray-800 active:text-gray-900 text-center sm:text-left py-2.5 sm:py-0 text-xs sm:text-sm min-h-[40px] sm:min-h-[44px] flex items-center justify-center sm:justify-start">
                    Annuler
                </a>
            </div>
        </form>
    </div>

    <!-- Note importante -->
    <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
        <div class="flex items-start">
            <i class="fas fa-info-circle text-blue-600 mt-1 mr-3"></i>
            <div class="text-sm text-blue-800">
                <p class="font-semibold mb-1">Note importante :</p>
                <ul class="list-disc list-inside space-y-1">
                    <li>Le concours sera créé en mode "Brouillon" et ne sera pas visible publiquement</li>
                    <li>Vous devez ajouter au moins un candidat pour pouvoir publier le concours</li>
                    <li>Vous pouvez ajouter des candidats maintenant ou plus tard depuis la page de modification</li>
                    <li>Après publication, les utilisateurs pourront voter pour les candidats</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
let candidateIndex = 0;

document.getElementById('addCandidateBtn').addEventListener('click', function() {
    const container = document.getElementById('candidatesContainer');
    const noCandidatesMessage = document.getElementById('noCandidatesMessage');
    
    // Masquer le message "aucun candidat"
    if (noCandidatesMessage) {
        noCandidatesMessage.style.display = 'none';
    }
    
    const candidateHtml = `
        <div class="candidate-item border-2 border-purple-200 rounded-lg p-5 bg-white shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-base font-bold text-purple-700 flex items-center">
                    <i class="fas fa-user-circle mr-2"></i>
                    Candidat #<span class="candidate-number">${candidateIndex + 1}</span>
                </h3>
                <button type="button" class="removeCandidateBtn text-red-600 hover:text-red-800 active:text-red-900 hover:bg-red-50 active:bg-red-100 px-3 sm:px-4 py-2 rounded-lg transition text-sm font-medium min-h-[44px] flex items-center justify-center">
                    <i class="fas fa-trash mr-1"></i><span class="hidden sm:inline">Supprimer</span><span class="sm:hidden">Suppr.</span>
                </button>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nom complet *</label>
                    <input type="text" name="candidates[${candidateIndex}][name]" required class="w-full px-3 sm:px-4 py-2.5 sm:py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 text-sm sm:text-base min-h-[44px]" placeholder="Ex: Amina Diallo">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Numéro *</label>
                    <input type="number" name="candidates[${candidateIndex}][number]" value="${candidateIndex + 1}" min="1" required class="w-full px-3 sm:px-4 py-2.5 sm:py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 text-sm sm:text-base min-h-[44px]">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Photo (optionnel)</label>
                    <input type="file" name="candidates[${candidateIndex}][photo]" accept="image/*" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 text-sm">
                    <p class="text-xs text-gray-500 mt-1">JPG, PNG (max 2MB)</p>
                </div>
            </div>
            <div class="mt-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Description / Biographie</label>
                <textarea name="candidates[${candidateIndex}][description]" rows="3" class="w-full px-3 sm:px-4 py-2.5 sm:py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 text-sm sm:text-base min-h-[90px]" placeholder="Courte description ou biographie du candidat..."></textarea>
                <p class="text-xs text-gray-500 mt-1">Cette description sera visible sur la page publique du concours</p>
            </div>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', candidateHtml);
    candidateIndex++;
    updateCandidateNumbers();
    updateNoCandidatesMessage();
    
    // Ajouter l'événement de suppression
    const newItem = container.lastElementChild;
    const removeBtn = newItem.querySelector('.removeCandidateBtn');
    if (removeBtn) {
        removeBtn.addEventListener('click', function() {
            this.closest('.candidate-item').remove();
            updateCandidateNumbers();
            updateNoCandidatesMessage();
        });
    }
});

function updateCandidateNumbers() {
    const items = document.querySelectorAll('.candidate-item');
    items.forEach((item, index) => {
        const numberSpan = item.querySelector('.candidate-number');
        if (numberSpan) {
            numberSpan.textContent = index + 1;
        }
        const numberInput = item.querySelector('input[name*="[number]"]');
        if (numberInput) {
            numberInput.value = index + 1;
        }
    });
}

function updateNoCandidatesMessage() {
    const container = document.getElementById('candidatesContainer');
    const noCandidatesMessage = document.getElementById('noCandidatesMessage');
    const items = container.querySelectorAll('.candidate-item');
    
    if (items.length === 0 && noCandidatesMessage) {
        noCandidatesMessage.style.display = 'block';
    } else if (noCandidatesMessage) {
        noCandidatesMessage.style.display = 'none';
    }
}

// Permettre la suppression des candidats
document.addEventListener('click', function(e) {
    if (e.target.closest('.removeCandidateBtn')) {
        e.target.closest('.candidate-item').remove();
        updateCandidateNumbers();
        updateNoCandidatesMessage();
    }
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\adoun\Music\Tikehub\resources\views/contests/create.blade.php ENDPATH**/ ?>