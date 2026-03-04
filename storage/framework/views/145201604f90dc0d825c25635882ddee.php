

<?php ($title = 'Пользователи'); ?>
<?php $__env->startSection('title', 'Пользователи'); ?>

<?php $__env->startSection('content'); ?>

    <div class="container-fluid">

        
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
            <div>
                <h2 class="mb-1">👥 Пользователи</h2>
                <p class="text-muted mb-0">
                    Всего пользователей: <strong><?php echo e($users->count()); ?></strong>
                </p>
            </div>

            <a href="<?php echo e(route('users.create')); ?>" class="btn btn-primary">
                ➕ Добавить пользователя
            </a>
        </div>

        <?php if(session('success')): ?>
            <div class="alert alert-success shadow-sm">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        
        
        <div class="card shadow-sm border-0 d-none d-md-block">
            <div class="card-body p-0">

                <div class="table-responsive">
                    <table class="table align-middle mb-0 table-hover">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 60px;">#</th>
                                <th>Пользователь</th>
                                <th>Email</th>
                                <th style="width: 220px;">Роль</th>
                                <th style="width: 150px;">Действие</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <span class="badge bg-secondary">
                                            <?php echo e($u->id); ?>

                                        </span>
                                    </td>

                                    <td class="fw-semibold">
                                        <?php echo e($u->name); ?>

                                    </td>

                                    <td>
                                        <small class="text-muted">
                                            <?php echo e($u->email); ?>

                                        </small>
                                    </td>

                                    <td>
                                        <form action="<?php echo e(route('users.updateRole', $u)); ?>" method="POST" class="d-flex gap-2">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('PATCH'); ?>

                                            <select name="role" class="form-select form-select-sm">
                                                <option value="admin" <?php echo e($u->role === 'admin' ? 'selected' : ''); ?>>🛡
                                                    Администратор</option>
                                                <option value="operator" <?php echo e($u->role === 'operator' ? 'selected' : ''); ?>>📊
                                                    Оператор</option>
                                                <option value="driver" <?php echo e($u->role === 'driver' ? 'selected' : ''); ?>>🚗 Водитель
                                                </option>
                                                <option value="mechanic" <?php echo e($u->role === 'mechanic' ? 'selected' : ''); ?>>🔧
                                                    Механик</option>
                                            </select>
                                    </td>

                                    <td>
                                        <button class="btn btn-success btn-sm w-100">
                                            💾 Сохранить
                                        </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
        
        <div class="d-md-none">

            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="card shadow-sm border-0 mb-3">
                    <div class="card-body">

                        <div class="d-flex justify-content-between mb-2">
                            <strong><?php echo e($u->name); ?></strong>
                            <span class="badge bg-secondary">
                                #<?php echo e($u->id); ?>

                            </span>
                        </div>

                        <div class="small text-muted mb-3">
                            <?php echo e($u->email); ?>

                        </div>

                        <form action="<?php echo e(route('users.updateRole', $u)); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PATCH'); ?>

                            <select name="role" class="form-select mb-2">
                                <option value="admin" <?php echo e($u->role === 'admin' ? 'selected' : ''); ?>>🛡 Администратор</option>
                                <option value="operator" <?php echo e($u->role === 'operator' ? 'selected' : ''); ?>>📊 Оператор</option>
                                <option value="driver" <?php echo e($u->role === 'driver' ? 'selected' : ''); ?>>🚗 Водитель</option>
                                <option value="mechanic" <?php echo e($u->role === 'mechanic' ? 'selected' : ''); ?>>🔧 Механик</option>
                            </select>

                            <button class="btn btn-success w-100">
                                💾 Сохранить
                            </button>
                        </form>

                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        </div>

    </div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\210kab\Documents\Tarabanov\autopark\resources\views/users/index.blade.php ENDPATH**/ ?>