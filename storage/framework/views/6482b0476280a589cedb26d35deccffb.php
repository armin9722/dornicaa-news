<?php $__env->startSection("content"); ?>

    <!-- =======================
Inner intro START -->
    <section class="pb-3 pb-lg-5">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <?php if($post->category): ?>

                            <i class=" fas fa-circle me-2 small fw-bold"></i><?php echo e($post->category->name); ?>


                    <?php endif; ?>
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                        <h1 class="mb-0"><?php echo e($post->title); ?></h1>
                        <?php if(auth()->guard()->check()): ?>
                            <form action="<?php echo e(route('favorites.toggle', $post->id)); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="btn <?php echo e($isFavorite ? 'btn-danger' : 'btn-outline-danger'); ?>">
                                    <i class="<?php echo e($isFavorite ? 'bi bi-heart-fill' : 'bi bi-heart'); ?> me-1"></i>
                                    <?php echo e($isFavorite ? 'حذف از علاقه‌مندی' : 'افزودن به علاقه‌مندی'); ?>

                                </button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
                <?php if($post->summary): ?>
                    <p class="lead"><?php echo e($post->summary); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <!-- =======================
    Inner intro END -->

    <section class="pt-0">
        <div class="container position-relative" data-sticky-container>
            <div class="row">
                <?php if(session('success_favorite')): ?>
                    <div class="col-12">
                        <div class="alert alert-info alert-dismissible fade show" role="alert">
                            <?php echo e(session('success_favorite')); ?>

                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                <?php endif; ?>
                <!-- Left sidebar START -->
                <div class="col-lg-2">
                    <div class="text-start text-lg-center mb-5" data-sticky data-margin-top="80" data-sticky-for="991">
                        <!-- Author info -->
                        <?php
                            $author = $post->admin ?? $post->legacyAdmin;
                        ?>
                        <?php if($author): ?>
                            <div class="position-relative">
                                <div class="avatar avatar-xl">
                                    <img class="avatar-img rounded-circle"
                                         src="<?php echo e($post->admin && $post->admin->file ? asset('storage/' . $post->admin->file->path) : asset('assets/images/avatar/default.svg')); ?>"
                                         alt="avatar">
                                </div>
                                <span class="h5 mt-2 mb-0 d-block text-reset"><?php echo e(full_name($author->first_name ?? null, $author->last_name ?? null)); ?></span>
                                <p>نویسنده</p>
                            </div>
                        <?php endif; ?>
                        <hr class="d-none d-lg-block">
                        <!-- Card info -->
                        <ul class="list-inline list-unstyled">
                            <li class="list-inline-item d-lg-block my-lg-2"><?php echo e(\Hekmatinasser\Verta\Verta::instance($post->created_at)->format('d F، Y')); ?></li>


                            <li class="list-inline-item d-lg-block my-lg-2"><i class="far fa-eye me-1"></i> <?php echo e($post->views ?? 0); ?> بازدید</li>
                        </ul>
                        <!-- Tags -->

                    </div>
                </div>
                <!-- Left sidebar END -->
                <!-- Main Content START -->
                <div class="col-lg-7 mb-5">

                    <!-- Image -->
                    <figure class="figure mt-2">
                        <a href="<?php echo e($post->file ? asset('storage/' . $post->file->path) : asset('assets/images/placeholders/post-placeholder.svg')); ?>"
                           data-glightbox data-gallery="image-popup">
                            <img class="rounded mb-5"
                                 src="<?php echo e($post->file ? asset('storage/' . $post->file->path) : asset('assets/images/placeholders/post-placeholder.svg')); ?>"
                                 alt="<?php echo e($post->title); ?>">
                        </a>
                    </figure>

                    <!-- Post Content -->
                    <div class="post-content">
                        <?php echo nl2br(e($post->content)); ?>

                    </div>






                    <hr>

                    <!-- Success Message -->
                    <?php if(session('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bi bi-check-circle me-2"></i>
                            <?php echo e(session('success')); ?>

                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <!-- Comments START -->
                    <div>
                        <h3><?php echo e($comments->count()); ?> دیدگاه</h3>

                        <?php $__empty_1 = true; $__currentLoopData = $comments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="my-4 d-flex">
                                <div class="avatar avatar-md rounded-circle float-start me-3">
                                    <img class="avatar-img rounded-circle"
                                         src="<?php echo e($comment->user && $comment->user->file ? asset('storage/' . $comment->user->file->path) : asset('assets/images/avatar/default.svg')); ?>"
                                         alt="avatar">
                                </div>
                                <div>
                                    <div class="mb-2">
                                        <h5 class="m-0">
                                            <?php if($comment->user): ?>
                                                <?php echo e(full_name($comment->user->first_name, $comment->user->last_name)); ?>

                                            <?php else: ?>
                                                <?php echo e($comment->guest_name); ?>

                                            <?php endif; ?>
                                        </h5>
                                        <span class="me-3 small">
                                            <?php if($comment->created_at): ?>
                                                <?php echo e(\Hekmatinasser\Verta\Verta::instance($comment->created_at)->format('d F، Y در H:i')); ?>

                                            <?php endif; ?>
                                        </span>
                                    </div>
                                    <p><?php echo e($comment->content); ?></p>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="alert alert-info">
                                هنوز دیدگاهی ثبت نشده است. اولین نفری باشید که دیدگاه می‌دهد!
                            </div>
                        <?php endif; ?>
                    </div>
                    <!-- Comments END -->
                    <!-- Reply START -->
                    <div>
                        <h3>ثبت دیدگاه</h3>
                        <small>آدرس ایمیل شما منتشر نخواهد شد. فیلدهای الزامی علامت گذاری شده اند *</small>
                        <form class="row g-3 mt-2" action="<?php echo e(route('blog-detail.comment')); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="post_id" value="<?php echo e($post->id); ?>">

                            <?php if(auth()->guard()->check()): ?>
                                
                                <div class="col-md-12">
                                    <div class="alert alert-info">
                                        <strong>شما به عنوان:</strong> <?php echo e(full_name(auth()->user()->first_name, auth()->user()->last_name)); ?> (<?php echo e(auth()->user()->email); ?>) دیدگاه می‌دهید.
                                    </div>
                                </div>
                            <?php else: ?>
                                
                                <div class="col-md-6">
                                    <label class="form-label">نام *</label>
                                    <input type="text" class="form-control <?php $__errorArgs = ['guest_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           name="guest_name" value="<?php echo e(old('guest_name')); ?>" required>
                                    <?php $__errorArgs = ['guest_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">ایمیل *</label>
                                    <input type="email" class="form-control <?php $__errorArgs = ['guest_email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           name="guest_email" value="<?php echo e(old('guest_email')); ?>" required>
                                    <?php $__errorArgs = ['guest_email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            <?php endif; ?>

                            <div class="col-12">
                                <label class="form-label">متن دیدگاه *</label>
                                <textarea class="form-control <?php $__errorArgs = ['content'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                          name="content" rows="3" required><?php echo e(old('content')); ?></textarea>
                                <?php $__errorArgs = ['content'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">ثبت دیدگاه</button>
                            </div>
                        </form>
                    </div>
                    <!-- Reply END -->



    </section>

<?php $__env->stopSection(); ?>

<?php echo $__env->make("layout.app", array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\D.H.ERAM\PhpstormProjects\dornica-news\resources\views/blog/blogDetail.blade.php ENDPATH**/ ?>