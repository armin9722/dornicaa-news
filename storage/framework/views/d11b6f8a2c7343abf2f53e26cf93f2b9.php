<?php $__env->startSection('content'); ?>
    <main>
        <section class="py-4">
            <div class="container">
                <div class="row g-4 align-items-stretch">

                    <!-- Profile & Password Section (Left) -->
                    <div class="col-lg-7 d-flex flex-column h-100">

                        <!-- Profile Edit Card -->
                        <div class="card border mb-4 flex-grow-1 d-flex flex-column h-100">
                            <div class="card-header border-bottom p-3">
                                <h4 class="card-header-title mb-0">حساب کاربری</h4>
                            </div>
                            <div class="card-body flex-grow-1">
                                <?php if(session('success_profile')): ?>
                                    <div class="alert alert-success"><?php echo e(session('success_profile')); ?></div>
                                <?php endif; ?>
                                <form action="<?php echo e(route('dashboard.profile.update')); ?>" method="POST" enctype="multipart/form-data">
                                    <?php echo csrf_field(); ?>
                                    <!-- Full name -->
                                    <div class="mb-3">
                                        <label class="form-label">نام کامل</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control <?php $__errorArgs = ['first_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                   name="first_name" value="<?php echo e(old('first_name', $user->first_name)); ?>" placeholder="نام">
                                            <input type="text" class="form-control <?php $__errorArgs = ['last_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                   name="last_name" value="<?php echo e(old('last_name', $user->last_name)); ?>" placeholder="نام خانوادگی">
                                        </div>
                                        <?php $__errorArgs = ['first_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="text-danger mt-1"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        <?php $__errorArgs = ['last_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="text-danger mt-1"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>

                                    <!-- Username -->
                                    <div class="mb-3">
                                        <label class="form-label">نام کاربری</label>
                                        <input type="text" class="form-control <?php $__errorArgs = ['username'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                               name="username" value="<?php echo e(old('username', $user->username)); ?>">
                                        <?php $__errorArgs = ['username'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="text-danger mt-1"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>

                                    <!-- Email -->
                                    <div class="mb-3">
                                        <label class="form-label">پست الکترونیکی</label>
                                        <input class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" type="email"
                                               name="email" value="<?php echo e(old('email', $user->email)); ?>">
                                        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="text-danger mt-1"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>

                                    <!-- Profile picture -->
                                    <div class="mb-3">
                                        <label class="form-label">تصویر پروفایل</label>
                                        <div class="d-flex align-items-center mb-2">
                                            <div class="position-relative me-3">
                                                <div class="avatar avatar-xl">
                                                    <img class="avatar-img rounded-circle border border-white border-3 shadow"
                                                         src="<?php echo e($user->file ? asset('storage/' . $user->file->path) : asset('assets/images/avatar/default.svg')); ?>"
                                                         alt="avatar">
                                                </div>
                                            </div>
                                            <div>
                                                <input type="file" class="form-control <?php $__errorArgs = ['avatar'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                       name="avatar" accept="image/*">
                                                <?php $__errorArgs = ['avatar'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="text-danger mt-1"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>
                                        </div>
                                        <?php if($user->file): ?>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="remove_avatar" value="1" id="remove_avatar">
                                                <label class="form-check-label" for="remove_avatar">حذف تصویر پروفایل فعلی</label>
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                    <div class="d-flex justify-content-end mt-4">
                                        <button type="submit" class="btn btn-primary">ذخیره</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Change Password Card -->
                        <div class="card border flex-grow-1 d-flex flex-column h-100">
                            <div class="card-header border-bottom p-3">
                                <h4 class="card-header-title mb-0">تغییر رمز عبور</h4>
                            </div>
                            <div class="card-body flex-grow-1">
                                <?php if(session('success_password')): ?>
                                    <div class="alert alert-success"><?php echo e(session('success_password')); ?></div>
                                <?php endif; ?>
                                <form action="<?php echo e(route('dashboard.password.update')); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <div class="mb-3">
                                        <label class="form-label">رمز عبور فعلی</label>
                                        <input class="form-control <?php $__errorArgs = ['current_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                               name="current_password" type="password" placeholder="*********">
                                        <?php $__errorArgs = ['current_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="text-danger mt-1"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">رمز عبور جدید</label>
                                        <input class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                               name="password" type="password" placeholder="*********">
                                        <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="text-danger mt-1"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">تکرار رمز عبور جدید</label>
                                        <input class="form-control" name="password_confirmation" type="password" placeholder="*********">
                                    </div>
                                    <div class="d-flex justify-content-end mt-4">
                                        <button type="submit" class="btn btn-primary">ذخیره</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Favorite News and Recent Comments Section (Right) -->
                    <div class="col-lg-5 d-flex flex-column h-100">

                        <!-- Favorite News Card -->
                        <div class="card border flex-grow-1 d-flex flex-column h-100 mb-4">
                            <div class="card-header border-bottom p-3 d-flex justify-content-between align-items-center">
                                <h5 class="card-header-title mb-0">اخبار مورد علاقه من</h5>
                                <span class="badge bg-primary"><?php echo e($favorites->total()); ?></span>
                            </div>
                            <div class="card-body flex-grow-1 overflow-auto">
                                <?php $__empty_1 = true; $__currentLoopData = $favorites; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $favorite): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <div class="d-flex mb-3 pb-3 border-bottom">
                                        <div class="flex-shrink-0 rounded me-3" style="width: 72px;">
                                            <img class="img-fluid rounded"
                                                 src="<?php echo e($favorite->file ? asset('storage/' . $favorite->file->path) : asset('assets/images/placeholders/post-placeholder.svg')); ?>"
                                                 alt="<?php echo e($favorite->title); ?>">
                                        </div>
                                        <div class="flex-grow-1">
                                        <span class="fw-semibold text-dark">
                                            <a href="<?php echo e(route('blog-detail.index', $favorite->id)); ?>" class="text-decoration-none text-primary">
                                                <?php echo e($favorite->title); ?>

                                            </a>
                                        </span>
                                            <div class="small text-muted mt-1">
                                                <?php echo e($favorite->category?->name ?? 'بدون دسته‌بندی'); ?>

                                            </div>
                                            <div class="d-flex justify-content-between text-muted small mt-2">
                                                <span><?php echo e(\Hekmatinasser\Verta\Verta::instance($favorite->pivot->created_at)->format('Y/m/d')); ?></span>
                                                <span><i class="far fa-eye me-1"></i><?php echo e($favorite->views ?? 0); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <p class="text-muted mb-0">هنوز خبری را به علاقه‌مندی اضافه نکرده‌اید.</p>
                                <?php endif; ?>
                            </div>

                            <!-- Favorites Pagination -->
                            <?php if($favorites->hasPages()): ?>
                                <div class="card-footer border-0 pt-1 pb-2">
                                    <nav aria-label="Page navigation">
                                        <?php echo e($favorites->appends(request()->except('favorites_page'))->links('pagination::bootstrap-5')); ?>

                                    </nav>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Recent Comments Card -->
                        <div class="card border h-100 d-flex flex-column">
                            <div class="card-header border-bottom p-3 d-flex justify-content-between align-items-center">
                                <h5 class="card-header-title mb-0">آخرین نظرات</h5>
                                <span class="badge bg-primary"><?php echo e($recentComments->total()); ?></span>
                            </div>
                            <div class="card-body p-3 flex-grow-1 overflow-auto">
                                <div class="row">
                                    <?php $__empty_1 = true; $__currentLoopData = $recentComments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <div class="col-12 mb-3">
                                            <div class="d-flex align-items-center position-relative">
                                                <div class="avatar avatar-lg flex-shrink-0">
                                                    <img class="avatar-img rounded-2"
                                                         src="<?php echo e($comment->post->file ? asset('storage/' . $comment->post->file->path) : asset('assets/images/placeholders/post-placeholder.svg')); ?>"
                                                         alt="<?php echo e($comment->post->title); ?>">
                                                </div>
                                                <div class="ms-3">
                                                    <p class="mb-1">
                                                        <a class="h6 fw-normal stretched-link"
                                                           href="<?php echo e(route('blog-detail.index', $comment->post_id)); ?>#comment-<?php echo e($comment->id); ?>">
                                                            <?php echo e(Str::limit($comment->content, 60)); ?>

                                                        </a>
                                                    </p>
                                                    <div class="d-flex justify-content-between">
                                                        <p class="small mb-0"><?php echo e(Str::limit($comment->post->title, 40)); ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <div class="col-12">
                                            <p class="text-muted mb-0">هنوز نظری ثبت نشده است.</p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Comments Pagination -->
                            <?php if($recentComments->hasPages()): ?>
                                <div class="card-footer border-0 pt-1 pb-2">
                                    <nav aria-label="Page navigation">
                                        <?php echo e($recentComments->appends(request()->except('comments_page'))->links('pagination::bootstrap-5')); ?>

                                    </nav>
                                </div>
                            <?php endif; ?>
                        </div>

                    </div>
                </div>
            </div>
        </section>
    </main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\D.H.ERAM\PhpstormProjects\dornica-news\resources\views/account/dashboard.blade.php ENDPATH**/ ?>