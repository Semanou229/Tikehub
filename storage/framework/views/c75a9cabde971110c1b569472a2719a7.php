

<?php $__env->startSection('title', 'Acheter des billets - Tikehub'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold mb-6">Acheter des billets - <?php echo e($event->title); ?></h1>

    <form method="POST" action="<?php echo e(route('tickets.purchase')); ?>" class="bg-white rounded-lg shadow-lg p-6">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="event_id" value="<?php echo e($event->id); ?>">
        
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

        <button type="submit" class="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 w-full">
            Procéder au paiement
        </button>
    </form>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\adoun\Music\Tikehub\resources\views/tickets/index.blade.php ENDPATH**/ ?>