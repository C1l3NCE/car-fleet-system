

<?php ($title = 'Административная панель'); ?>

<?php $__env->startSection('content'); ?>

<div class="container-fluid">

    <!-- Приветствие -->
    <div class="card card-modern p-4 mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h3 class="mb-1 fw-semibold">
                    👋 Добро пожаловать, <?php echo e(auth()->user()->name); ?>

                </h3>
                <p class="text-muted mb-0">
                    Управление автопарком и системой
                </p>
            </div>

            <div class="text-end small text-muted">
                <div>Сегодня: <?php echo e(now()->format('d.m.Y')); ?></div>
                <div><?php echo e(now()->format('H:i')); ?></div>
            </div>
        </div>
    </div>

    <!-- KPI блоки -->
    <div class="row g-4 mb-4">

        <div class="col-md-6 col-xl-3">
            <div class="card card-modern p-4 h-100">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small">Пользователи</div>
                        <h4 class="fw-bold mb-0"><?php echo e($usersCount ?? '—'); ?></h4>
                    </div>
                    <i class="bi bi-people fs-2 text-primary"></i>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card card-modern p-4 h-100">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small">Машины</div>
                        <h4 class="fw-bold mb-0"><?php echo e($vehiclesCount ?? '—'); ?></h4>
                    </div>
                    <i class="bi bi-truck fs-2 text-success"></i>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card card-modern p-4 h-100">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small">Требуют ТО</div>
                        <h4 class="fw-bold mb-0"><?php echo e($maintenanceCount ?? '—'); ?></h4>
                    </div>
                    <i class="bi bi-wrench-adjustable-circle fs-2 text-danger"></i>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card card-modern p-4 h-100">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small">Активные водители</div>
                        <h4 class="fw-bold mb-0"><?php echo e($driversCount ?? '—'); ?></h4>
                    </div>
                    <i class="bi bi-person-badge fs-2 text-warning"></i>
                </div>
            </div>
        </div>

    </div>

    <!-- Основные разделы -->
    <div class="row g-4">

        <div class="col-md-6 col-xl-4">
            <div class="card card-modern h-100 p-4">
                <h5 class="fw-semibold mb-2">
                    <i class="bi bi-people text-primary"></i>
                    Пользователи
                </h5>
                <p class="text-muted small">
                    Управление ролями и доступом
                </p>
                <a href="/users" class="btn btn-sm btn-primary mt-2">
                    Открыть →
                </a>
            </div>
        </div>

        <div class="col-md-6 col-xl-4">
            <div class="card card-modern h-100 p-4">
                <h5 class="fw-semibold mb-2">
                    <i class="bi bi-truck text-success"></i>
                    Автопарк
                </h5>
                <p class="text-muted small">
                    Управление транспортными средствами
                </p>
                <a href="/vehicles" class="btn btn-sm btn-success mt-2">
                    Открыть →
                </a>
            </div>
        </div>

        <div class="col-md-6 col-xl-4">
            <div class="card card-modern h-100 p-4">
                <h5 class="fw-semibold mb-2">
                    <i class="bi bi-shield-check text-dark"></i>
                    Система
                </h5>

                <ul class="list-unstyled small text-muted mb-3">
                    <li>Роль: <strong><?php echo e(ucfirst(auth()->user()->role)); ?></strong></li>
                    <li>Среда: <strong><?php echo e(app()->environment()); ?></strong></li>
                    <li>Laravel: <strong><?php echo e(app()->version()); ?></strong></li>
                </ul>
            </div>
        </div>

    </div>

    <!-- Последние действия -->
    <?php if(isset($lastLogs)): ?>
        <div class="card card-modern mt-5 p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-semibold mb-0">
                    <i class="bi bi-clock-history"></i>
                    Последние действия
                </h5>
                <a href="<?php echo e(route('admin.logs')); ?>" class="btn btn-sm btn-outline-dark">
                    Журнал →
                </a>
            </div>

            <?php if($lastLogs->isEmpty()): ?>
                <p class="text-muted mb-0">Действий пока нет</p>
            <?php else: ?>
                <div class="list-group list-group-flush">
                    <?php $__currentLoopData = $lastLogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="list-group-item border-0 px-0 py-3">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <strong><?php echo e($log->user->name ?? 'Система'); ?></strong>
                                    —
                                    <code><?php echo e($log->action); ?></code>
                                </div>
                                <small class="text-muted">
                                    <?php echo e($log->created_at->diffForHumans()); ?>

                                </small>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>

</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\210kab\Documents\Tarabanov\autopark\resources\views/dashboard/admin.blade.php ENDPATH**/ ?>