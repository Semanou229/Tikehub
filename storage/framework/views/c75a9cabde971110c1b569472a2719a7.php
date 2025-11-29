<?php $__env->startSection('title', 'Acheter des billets - Tikehub'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold mb-6">Acheter des billets - <?php echo e($event->title); ?></h1>

    <?php if(isset($selectedTickets) && !empty($selectedTickets)): ?>
        <!-- Afficher les tickets sélectionnés -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <h2 class="text-xl font-bold mb-4">Récapitulatif de votre commande</h2>
            <div class="space-y-3 mb-4">
                <?php $__currentLoopData = $selectedTickets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ticketData): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $ticketType = $ticketTypes->find($ticketData['ticket_type_id']);
                    ?>
                    <?php if($ticketType): ?>
                        <div class="flex justify-between items-center border-b pb-2">
                            <div>
                                <span class="font-semibold"><?php echo e($ticketType->name); ?></span>
                                <span class="text-gray-600">x <?php echo e($ticketData['quantity']); ?></span>
                            </div>
                            <span class="font-bold"><?php echo e(number_format($ticketType->price * $ticketData['quantity'], 0, ',', ' ')); ?> XOF</span>
                        </div>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <?php
                $total = 0;
                foreach($selectedTickets as $ticketData) {
                    $ticketType = $ticketTypes->find($ticketData['ticket_type_id']);
                    if($ticketType) {
                        $total += $ticketType->price * $ticketData['quantity'];
                    }
                }
            ?>
            <!-- Code promo -->
            <div class="mb-4 pt-3 border-t border-gray-200">
                <div class="flex items-center gap-2">
                    <input type="text" id="promo_code" name="promo_code" placeholder="Code promo (optionnel)" 
                           class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                           value="<?php echo e(old('promo_code')); ?>">
                    <button type="button" id="apply_promo" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
                        Appliquer
                    </button>
                </div>
                <div id="promo_message" class="mt-2 text-sm"></div>
            </div>
            <div class="flex justify-between items-center pt-3 border-t-2 border-gray-300">
                <span class="text-xl font-bold">Total</span>
                <div class="text-right">
                    <div id="discount_display" class="text-sm text-green-600 hidden mb-1"></div>
                    <span class="text-2xl font-bold text-red-600" id="total_amount"><?php echo e(number_format($total, 0, ',', ' ')); ?> XOF</span>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <form method="POST" action="<?php echo e(route('tickets.purchase')); ?>" class="bg-white rounded-lg shadow-lg p-6">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="event_id" value="<?php echo e($event->id); ?>">
        
        <?php if(isset($selectedTickets) && !empty($selectedTickets)): ?>
            <!-- Mode multi-tickets depuis la sélection -->
            <?php $__currentLoopData = $selectedTickets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ticketData): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <input type="hidden" name="tickets[<?php echo e($ticketData['ticket_type_id']); ?>]" value="<?php echo e($ticketData['quantity']); ?>">
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php else: ?>
            <!-- Mode simple (ancien système) -->
            <div class="mb-6">
                <label class="block text-gray-700 font-bold mb-2">Type de billet</label>
                <select name="ticket_type_id" id="ticket_type_id" required class="w-full border rounded px-4 py-2">
                    <?php $__currentLoopData = $ticketTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ticketType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($ticketType->id); ?>" data-price="<?php echo e($ticketType->price); ?>">
                            <?php echo e($ticketType->name); ?> - <?php echo e(number_format($ticketType->price, 0, ',', ' ')); ?> XOF
                            (<?php echo e($ticketType->available_quantity); ?> disponible(s))
                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-bold mb-2">Quantité</label>
                <input type="number" name="quantity" id="quantity" min="1" max="10" value="1" required
                    class="w-full border rounded px-4 py-2">
            </div>
        <?php endif; ?>

        <div class="mb-6">
            <label class="block text-gray-700 font-bold mb-2">Nom complet</label>
            <input type="text" name="buyer_name" value="<?php echo e(auth()->user()->name); ?>" required
                class="w-full border rounded px-4 py-2">
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 font-bold mb-2">Email</label>
            <input type="email" name="buyer_email" value="<?php echo e(auth()->user()->email); ?>" required
                class="w-full border rounded px-4 py-2">
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 font-bold mb-2">Téléphone</label>
            <input type="text" name="buyer_phone" value="<?php echo e(auth()->user()->phone); ?>"
                class="w-full border rounded px-4 py-2">
        </div>

        <!-- Code promo (pour mode simple aussi) -->
        <div class="mb-6">
            <label class="block text-gray-700 font-bold mb-2">Code promo (optionnel)</label>
            <div class="flex items-center gap-2">
                <input type="text" id="promo_code_simple" name="promo_code" placeholder="Entrez votre code promo" 
                       class="flex-1 border rounded px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                       value="<?php echo e(old('promo_code')); ?>">
                <button type="button" id="apply_promo_simple" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
                    Appliquer
                </button>
            </div>
            <div id="promo_message_simple" class="mt-2 text-sm"></div>
            <div id="discount_display_simple" class="mt-2 text-sm text-green-600 hidden"></div>
        </div>

        <input type="hidden" id="promo_code_id" name="promo_code_id" value="">
        <input type="hidden" id="discount_amount" name="discount_amount" value="0">

        <button type="submit" class="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 w-full">
            Procéder au paiement
        </button>
    </form>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
let originalTotal = parseFloat(document.getElementById('original_total')?.value || <?php echo e($total ?? 0); ?>);
let currentDiscount = 0;
let promoCodeId = null;

function applyPromoCode(code, isSimple = false) {
    if (!code) {
        showMessage(isSimple ? 'promo_message_simple' : 'promo_message', 'Veuillez entrer un code promo', 'error');
        return;
    }

    fetch('<?php echo e(route("tickets.validate-promo")); ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
        },
        body: JSON.stringify({
            code: code,
            event_id: <?php echo e($event->id); ?>,
            amount: originalTotal
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.valid) {
            currentDiscount = data.discount_amount;
            promoCodeId = data.promo_code_id;
            updateTotal();
            showMessage(isSimple ? 'promo_message_simple' : 'promo_message', data.message, 'success');
            showDiscount(isSimple ? 'discount_display_simple' : 'discount_display', currentDiscount);
            document.getElementById('promo_code_id').value = promoCodeId;
            document.getElementById('discount_amount').value = currentDiscount;
        } else {
            currentDiscount = 0;
            promoCodeId = null;
            updateTotal();
            showMessage(isSimple ? 'promo_message_simple' : 'promo_message', data.message, 'error');
            hideDiscount(isSimple ? 'discount_display_simple' : 'discount_display');
            document.getElementById('promo_code_id').value = '';
            document.getElementById('discount_amount').value = 0;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showMessage(isSimple ? 'promo_message_simple' : 'promo_message', 'Une erreur est survenue', 'error');
    });
}

function updateTotal() {
    const newTotal = Math.max(0, originalTotal - currentDiscount);
    const totalElement = document.getElementById('total_amount');
    if (totalElement) {
        totalElement.textContent = newTotal.toLocaleString('fr-FR', {minimumFractionDigits: 0, maximumFractionDigits: 0}) + ' XOF';
    }
}

function showMessage(elementId, message, type) {
    const element = document.getElementById(elementId);
    if (element) {
        element.textContent = message;
        element.className = 'mt-2 text-sm ' + (type === 'success' ? 'text-green-600' : 'text-red-600');
    }
}

function showDiscount(elementId, discount) {
    const element = document.getElementById(elementId);
    if (element) {
        element.textContent = 'Réduction: -' + discount.toLocaleString('fr-FR', {minimumFractionDigits: 0, maximumFractionDigits: 0}) + ' XOF';
        element.classList.remove('hidden');
    }
}

function hideDiscount(elementId) {
    const element = document.getElementById(elementId);
    if (element) {
        element.classList.add('hidden');
    }
}

document.getElementById('apply_promo')?.addEventListener('click', function() {
    const code = document.getElementById('promo_code').value.trim();
    applyPromoCode(code, false);
});

document.getElementById('apply_promo_simple')?.addEventListener('click', function() {
    const code = document.getElementById('promo_code_simple').value.trim();
    applyPromoCode(code, true);
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\adoun\Music\Tikehub\resources\views/tickets/index.blade.php ENDPATH**/ ?>