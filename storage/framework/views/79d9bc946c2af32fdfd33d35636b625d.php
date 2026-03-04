

<?php $__env->startSection('title', $vehicle->brand.' '.$vehicle->model); ?>

<?php $__env->startSection('content'); ?>

<div class="container-fluid">

    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-semibold mb-0">
                <?php echo e($vehicle->brand); ?> <?php echo e($vehicle->model); ?>

            </h4>
            <div class="text-muted small">
                <?php echo e($vehicle->reg_number); ?>

            </div>
        </div>

        <div class="d-flex gap-2">
            <a href="<?php echo e(route('fuel.index', $vehicle)); ?>"
               class="btn btn-outline-secondary btn-sm">
                ⛽ Заправки
            </a>

            <a href="<?php echo e(route('vehicles.edit', $vehicle)); ?>"
               class="btn btn-warning btn-sm">
                ✏️ Редактировать
            </a>
        </div>
    </div>


    
    <div class="card card-modern mb-4 overflow-hidden">

        <div class="row g-0">

            
            <div class="col-lg-4" style="min-height:220px;">
                <?php if($vehicle->photo): ?>
                    <img src="<?php echo e(asset('storage/'.$vehicle->photo)); ?>"
                         class="w-100 h-100"
                         style="object-fit: cover;">
                <?php else: ?>
                    <div class="h-100 d-flex align-items-center justify-content-center bg-light text-muted">
                        Нет фото
                    </div>
                <?php endif; ?>
            </div>

            
            <div class="col-lg-8 p-4">

                <div class="row small">

                    <div class="col-md-6 mb-3">
                        <span class="text-muted">Год выпуска</span><br>
                        <strong><?php echo e($vehicle->year); ?></strong>
                    </div>

                    <div class="col-md-6 mb-3">
                        <span class="text-muted">VIN</span><br>
                        <strong><?php echo e($vehicle->vin ?: '—'); ?></strong>
                    </div>

                    <div class="col-md-6 mb-3">
                        <span class="text-muted">Пробег</span><br>
                        <strong>
                            <?php echo e(number_format($vehicle->mileage, 0, ',', ' ')); ?> км
                        </strong>
                    </div>

                    <div class="col-md-6 mb-3">
                        <span class="text-muted">Тип топлива</span><br>
                        <strong><?php echo e($vehicle->fuel_type ?: '—'); ?></strong>
                    </div>

                </div>

            </div>

        </div>

    </div>


    
    <?php if(isset($aiAnalysis)): ?>

        <div class="card card-modern mb-4 p-4 border-start border-4 border-primary">

            <h5 class="fw-semibold mb-3">
                🤖 AI-анализ технического состояния
            </h5>

            <?php $__currentLoopData = explode("\n", $aiAnalysis); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $line): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="small text-muted mb-1">
                    <?php echo e($line); ?>

                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        </div>

    <?php endif; ?>

</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\210kab\Documents\Tarabanov\autopark\resources\views/vehicles/show.blade.php ENDPATH**/ ?>