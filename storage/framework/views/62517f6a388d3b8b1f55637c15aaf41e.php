<?php $__env->startSection('content'); ?>
    <div class="container-fluid p-4" dir="rtl">
        <h1 class="mb-4">پنل مدیریت کاربران</h1>

        <?php if(session('success')): ?>
            <div class="alert alert-success"><?php echo e(session('success')); ?></div>
        <?php endif; ?>

        <form method="GET" class="mb-3 d-flex gap-2">
            <input type="text" name="search" class="form-control" placeholder="جستجو..." value="<?php echo e(request('search')); ?>">
            <button class="btn btn-primary">جستجو</button>
        </form>

        <table class="table table-hover">
            <thead>
            <tr>
                <th class="text-end">نام کاربر</th>
                <th class="text-end">ایمیل</th>
                <th class="text-end">موبایل</th>
                <th class="text-center">وضعیت</th>
                <th class="text-center">عملیات</th>
            </tr>
            </thead>
            <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td class="text-end"><?php echo e($user->first_name); ?> <?php echo e($user->last_name); ?></td>
                    <td class="text-end"><?php echo e($user->email); ?></td>
                    <td class="text-end"><?php echo e($user->mobile ?? '-'); ?></td>
                    <td class="text-center">
                        <form action="<?php echo e(route('admin.toggle-admin', $user->id)); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <button class="btn btn-sm btn-info" type="submit">
                                <?php echo e($user->admin ? 'مدیر' : 'کاربر'); ?>

                            </button>
                        </form>
                    </td>
                    <td class="text-center">
                        <a href="<?php echo e(route('admin.edit', $user->id)); ?>" class="btn btn-sm btn-primary">ویرایش</a>

                        <form action="<?php echo e(route('admin.destroy', $user->id)); ?>" method="POST" style="display:inline-block;" onsubmit="return confirm('آیا مطمئن هستید؟')">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button class="btn btn-sm btn-danger" type="submit">حذف</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="5" class="text-center">کاربری یافت نشد</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>

        <div class="mt-3">
            <?php echo e($users->links()); ?>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\D.H.ERAM\PhpstormProjects\dornica-news\resources\views/admin/panel.blade.php ENDPATH**/ ?>