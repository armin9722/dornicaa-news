<?php $__env->startSection("content"); ?>

<!-- **************** MAIN CONTENT START **************** -->
<main>

    <?php if(session('success_favorite')): ?>
        <div class="container mt-3">
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <?php echo e(session('success_favorite')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    <?php endif; ?>
    <?php
        $favoritePostIds = $favoritePostIds ?? [];
    ?>

    <!-- Success Message -->
    <?php if(session('success')): ?>
        <div class="container mt-3">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>
                <?php echo e(session('success')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    <?php endif; ?>

    <!-- =======================
    Trending START -->
    <section class="py-2">
        <div class="container">
            <div class="row g-0">
                <div class="col-12 bg-primary bg-opacity-10 p-2 rounded">
                    <div class="d-sm-flex align-items-center text-center text-sm-start">
                        <!-- Title -->
                        <div class="me-3">
                            <span class="badge bg-primary p-2 px-3">اخبار امروز:</span>
                        </div>
                        <!-- Slider -->
                        <div class="tiny-slider arrow-end arrow-xs arrow-white arrow-round arrow-md-none">
                            <div class="tiny-slider-inner"
                                 data-autoplay="true"
                                 data-hoverpause="true"
                                 data-gutter="0"
                                 data-arrow="true"
                                 data-dots="false"
                                 data-items="1">
                                <!-- Slider items -->

                               <?php $__empty_1 = true; $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <div> <?php echo e($post->title); ?></div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                               <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- Row END -->
        </div>
    </section>
    <!-- =======================
    Trending END -->


    <!-- =======================
    Main content START -->
    <section class="position-relative">
        <div class="container" data-sticky-container>
            <div class="row">
                <!-- Main Post START -->
                <div class="col-lg-9">
                    <!-- Title -->
                    <div class="mb-4">
                        <h2 class="m-0"><i class="bi bi-hourglass-top me-2"></i>آخرین اخبار، تصاویر، فیلم ها و گزارش های ویژه</h2>

                    </div>
                    <div class="row gy-4">
                        <?php $__empty_1 = true; $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <!-- Card item START -->
                        <div class="col-sm-6">
                            <div class="card">
                                <!-- Card img -->
                                <div class="position-relative">
                                    <img class="card-img"
                                         src="<?php echo e($post->file ? asset('storage/' . $post->file->path) : asset('assets/images/placeholders/post-placeholder.svg')); ?>"
                                         alt="<?php echo e($post->title); ?>">
                                    <div class="card-img-overlay d-flex align-items-start flex-column p-3">
                                        <!-- Card overlay bottom -->
                                        <div class="w-100 mt-auto">
                                            <!-- Card category -->
                                            <?php if($post->category): ?>

                                                    <i class="fas fa-circle me-2 small fw-bold "></i><?php echo e($post->category->name); ?>


                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body px-0 pt-3">
                                    <h4 class="card-title">
                                        <a href="<?php echo e(route("blog-detail.index", $post->id)); ?>" class="btn-link text-reset"><?php echo e($post->title); ?></a>
                                    </h4>
                                    <p class="card-text"><?php echo e($post->summary); ?></p>
                                    <!-- Card info -->
                                    <ul class="nav nav-divider align-items-center d-none d-sm-inline-block">
                                        <li class="nav-item">
                                            <div class="nav-link">
                                                <div class="d-flex align-items-center position-relative">
                                                    <div class="avatar avatar-xs">
                                                        <?php
                                                            $author = $post->admin ?? $post->legacyAdmin;
                                                        ?>
                                                        <img class="avatar-img rounded-circle"
                                                             src="<?php echo e($post->admin && $post->admin->file ? asset('storage/' . $post->admin->file->path) : asset('assets/images/avatar/default.svg')); ?>"
                                                             alt="avatar">
                                                    </div>
                                                    <span class="ms-3">

                                                        <span class="text-reset">
                                                            <?php echo e($author ? full_name($author->first_name ?? null, $author->last_name ?? null) : 'نویسنده'); ?>

                                                        </span>
                                                    </span>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="nav-item">
                                            <?php echo e(\Hekmatinasser\Verta\Verta::instance($post->created_at)->format('d F، Y')); ?>

                                        </li>
                                        <?php if(auth()->guard()->check()): ?>
                                            <li class="nav-item">
                                                <form action="<?php echo e(route('favorites.toggle', $post->id)); ?>" method="POST">
                                                    <?php echo csrf_field(); ?>
                                                    <button type="submit" class="btn btn-sm <?php echo e(in_array($post->id, $favoritePostIds) ? 'btn-danger' : 'btn-outline-danger'); ?>">
                                                        <i class="<?php echo e(in_array($post->id, $favoritePostIds) ? 'bi bi-heart-fill' : 'bi bi-heart'); ?>"></i>
                                                        <?php echo e(in_array($post->id, $favoritePostIds) ? 'حذف علاقه‌مندی' : 'افزودن به علاقه‌مندی'); ?>

                                                    </button>
                                                </form>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- Card item END -->
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="col-12">
                                <div class="alert alert-info text-center">
                                    مقاله ای موجود نیست
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Pagination START -->
                    <?php if($posts->hasPages()): ?>
                        <div class="col-12 mt-5">
                            <nav aria-label="Page navigation">
                                <ul class="pagination justify-content-center">
                                    
                                    <?php if($posts->onFirstPage()): ?>
                                        <li class="page-item disabled">
                                            <span class="page-link">قبلی</span>
                                        </li>
                                    <?php else: ?>
                                        <li class="page-item">
                                            <a class="page-link" href="<?php echo e($posts->previousPageUrl()); ?>" rel="prev">قبلی</a>
                                        </li>
                                    <?php endif; ?>

                                    
                                    <?php $__currentLoopData = $posts->getUrlRange(1, $posts->lastPage()); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($page == $posts->currentPage()): ?>
                                            <li class="page-item active">
                                                <span class="page-link"><?php echo e($page); ?></span>
                                            </li>
                                        <?php else: ?>
                                            <li class="page-item">
                                                <a class="page-link" href="<?php echo e($url); ?>"><?php echo e($page); ?></a>
                                            </li>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                    
                                    <?php if($posts->hasMorePages()): ?>
                                        <li class="page-item">
                                            <a class="page-link" href="<?php echo e($posts->nextPageUrl()); ?>" rel="next">بعدی</a>
                                        </li>
                                    <?php else: ?>
                                        <li class="page-item disabled">
                                            <span class="page-link">بعدی</span>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </nav>
                        </div>
                    <?php endif; ?>
                    <!-- Pagination END -->
                </div>
                <!-- Main Post END -->

            </div> <!-- Row end -->
        </div>
    </section>
    <!-- =======================
    Main content END -->

    <!-- Divider -->
    <div class="container"><div class="border-bottom border-primary border-2 opacity-1"></div></div>


</main>
<!-- **************** MAIN CONTENT END **************** -->
<?php $__env->stopSection(); ?>

<?php echo $__env->make("layout.app", array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\D.H.ERAM\PhpstormProjects\dornica-news\resources\views/index.blade.php ENDPATH**/ ?>