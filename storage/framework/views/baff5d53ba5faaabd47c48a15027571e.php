<?php $__env->startSection('content'); ?>
    <div class="container p-4" dir="rtl">
        <h2 class="mb-4">ویرایش کاربر</h2>

        <?php if($errors->any()): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="POST" action="<?php echo e(route('admin.update', $user->id)); ?>">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <div class="mb-3">
                <label class="form-label">نام</label>
                <input type="text" class="form-control" name="first_name" value="<?php echo e(old('first_name', $user->first_name)); ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">نام خانوادگی</label>
                <input type="text" class="form-control" name="last_name" value="<?php echo e(old('last_name', $user->last_name)); ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">ایمیل</label>
                <input type="email" class="form-control" name="email" value="<?php echo e(old('email', $user->email)); ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">موبایل</label>
                <input type="text" class="form-control" name="mobile" value="<?php echo e(old('mobile', $user->mobile)); ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">رمز عبور (اختیاری)</label>
                <input type="password" class="form-control" name="password">
            </div>

            <button class="btn btn-primary">ذخیره تغییرات</button>
            <a href="<?php echo e(route('admin.panel')); ?>" class="btn btn-secondary">بازگشت</a>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\D.H.ERAM\PhpstormProjects\dornica-news\resources\views/admin/edit.blade.php ENDPATH**/ ?>