

<?php ($title = 'Вход'); ?>

<?php $__env->startSection('content'); ?>

<div class="login-card">

    <div class="text-center mb-4">
        <h4 class="fw-bold mb-1 text-primary">
            🚗 Автопарк
        </h4>
        <div class="text-muted small">
            Вход в систему управления
        </div>
    </div>

    <?php if($errors->any()): ?>
        <div class="alert alert-danger">
            <?php echo e($errors->first()); ?>

        </div>
    <?php endif; ?>

    <form action="<?php echo e(route('login.post')); ?>" method="POST">
        <?php echo csrf_field(); ?>

        <div class="mb-3">
            <label class="form-label small text-muted">Email</label>
            <div class="input-group">
                <span class="input-group-text bg-white">
                    <i class="bi bi-envelope"></i>
                </span>
                <input type="email"
                       name="email"
                       class="form-control"
                       required>
            </div>
        </div>

        <div class="mb-4">
            <label class="form-label small text-muted">Пароль</label>
            <div class="input-group">
                <span class="input-group-text bg-white">
                    <i class="bi bi-lock"></i>
                </span>
                <input type="password"
                       name="password"
                       class="form-control"
                       required>
            </div>
        </div>

        <button type="submit" class="btn btn-primary w-100">
            Войти
        </button>
    </form>

    <div class="text-center mt-4 small text-muted">
        © <?php echo e(date('Y')); ?> Fleet System
    </div>

</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.guest', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\210kab\Documents\Tarabanov\autopark\resources\views/auth/login.blade.php ENDPATH**/ ?>