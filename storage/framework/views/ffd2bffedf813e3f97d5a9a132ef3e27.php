
<?php ($title = 'Автопарк'); ?>
<?php $__env->startSection('title', 'Автопарк'); ?>

<?php $__env->startSection('content'); ?>

<div class="container-fluid">

    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-semibold mb-0">Автопарк</h4>

        <div class="d-flex gap-2">

            <div class="btn-group">
                <button class="btn btn-outline-secondary btn-sm" onclick="setView('cards')">
                    🧩
                </button>
                <button class="btn btn-outline-secondary btn-sm" onclick="setView('table')">
                    📋
                </button>
            </div>

            <a href="<?php echo e(route('vehicles.create')); ?>"
               class="btn btn-primary btn-sm">
                ➕ Добавить машину
            </a>
        </div>
    </div>


    
    <div id="cardsView" class="row g-4">

        <?php $__currentLoopData = $vehicles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vehicle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

            <div class="col-md-6 col-xl-4">

                <div class="card card-modern h-100 overflow-hidden">

                    
                    <div style="height:160px; background:#f8f9fa;">
                        <?php if($vehicle->photo): ?>
                            <img src="<?php echo e(asset('storage/' . $vehicle->photo)); ?>"
                                 class="w-100 h-100"
                                 style="object-fit:cover;">
                        <?php else: ?>
                            <div class="d-flex h-100 align-items-center justify-content-center text-muted small">
                                Нет фото
                            </div>
                        <?php endif; ?>
                    </div>

                    
                    <div class="p-3">

                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <h6 class="fw-bold mb-0">
                                    <?php echo e($vehicle->brand); ?> <?php echo e($vehicle->model); ?>

                                </h6>
                                <div class="text-muted small">
                                    <?php echo e($vehicle->reg_number); ?>

                                </div>
                            </div>

                            
                            <?php if($vehicle->current_driver_id): ?>
                                <span class="badge bg-success-subtle text-success">
                                    В эксплуатации
                                </span>
                            <?php else: ?>
                                <span class="badge bg-secondary-subtle text-secondary">
                                    Свободна
                                </span>
                            <?php endif; ?>
                        </div>

                        <div class="small text-muted mb-2">
                            Тип: <strong class="text-dark"><?php echo e($vehicle->type); ?></strong>
                            • Пробег:
                            <strong class="text-dark">
                                <?php echo e(number_format($vehicle->mileage, 0, ',', ' ')); ?> км
                            </strong>
                        </div>

                        <div class="small text-muted mb-3">
                            Водитель:
                            <strong class="text-dark">
                                <?php echo e($vehicle->driver->name ?? '—'); ?>

                            </strong>
                        </div>

                        <div class="d-flex flex-wrap gap-2">
                            <a href="<?php echo e(route('vehicles.show', $vehicle)); ?>"
                               class="btn btn-outline-primary btn-sm">
                                Открыть
                            </a>

                            <a href="<?php echo e(route('vehicles.edit', $vehicle)); ?>"
                               class="btn btn-outline-secondary btn-sm">
                                ✏️
                            </a>

                            <a href="<?php echo e(route('fuel.index', $vehicle)); ?>"
                               class="btn btn-outline-secondary btn-sm">
                                ⛽
                            </a>

                            <a href="<?php echo e(route('maintenance.index', $vehicle)); ?>"
                               class="btn btn-outline-secondary btn-sm">
                                🛠
                            </a>
                        </div>

                    </div>

                </div>

            </div>

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    </div>


    
    <div id="tableView" class="d-none">

        <div class="card card-modern p-3">

            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Авто</th>
                        <th>Номер</th>
                        <th>Тип</th>
                        <th>Пробег</th>
                        <th>Водитель</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    <?php $__currentLoopData = $vehicles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vehicle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td class="fw-semibold">
                                <?php echo e($vehicle->brand); ?> <?php echo e($vehicle->model); ?>

                            </td>
                            <td><?php echo e($vehicle->reg_number); ?></td>
                            <td><?php echo e($vehicle->type); ?></td>
                            <td>
                                <?php echo e(number_format($vehicle->mileage, 0, ',', ' ')); ?> км
                            </td>
                            <td><?php echo e($vehicle->driver->name ?? '—'); ?></td>
                            <td class="text-end">
                                <a href="<?php echo e(route('vehicles.show', $vehicle)); ?>"
                                   class="btn btn-sm btn-outline-primary">
                                    Открыть →
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>

            </table>

        </div>

    </div>

</div>



<script>
function setView(view) {
    localStorage.setItem('vehicleView', view);
    applyView();
}

function applyView() {
    const view = localStorage.getItem('vehicleView') || 'cards';
    document.getElementById('cardsView').classList.toggle('d-none', view !== 'cards');
    document.getElementById('tableView').classList.toggle('d-none', view !== 'table');
}

document.addEventListener('DOMContentLoaded', applyView);
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\210kab\Documents\Tarabanov\autopark\resources\views/vehicles/index.blade.php ENDPATH**/ ?>