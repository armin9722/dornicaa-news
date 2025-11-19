@extends("layout.app")
@section("content")

<!-- **************** MAIN CONTENT START **************** -->
<main>

    @if(session('success_favorite'))
        <div class="container mt-3">
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                {{ session('success_favorite') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif
    @php
        $favoritePostIds = $favoritePostIds ?? [];
    @endphp

    <!-- Success Message -->
    @if(session('success'))
        <div class="container mt-3">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif

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

                               @forelse($posts as $post)
                                    <div> {{$post->title}}</div>
                                @empty
                               @endforelse
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
                        @forelse($posts as $post)
                        <!-- Card item START -->
                        <div class="col-sm-6">
                            <div class="card">
                                <!-- Card img -->
                                <div class="position-relative">
                                    <img class="card-img"
                                         src="{{ $post->file ? asset('storage/' . $post->file->path) : asset('assets/images/placeholders/post-placeholder.svg') }}"
                                         alt="{{ $post->title }}">
                                    <div class="card-img-overlay d-flex align-items-start flex-column p-3">
                                        <!-- Card overlay bottom -->
                                        <div class="w-100 mt-auto">
                                            <!-- Card category -->
                                            @if($post->category)

                                                    <i class="fas fa-circle me-2 small fw-bold "></i>{{ $post->category->name }}

                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body px-0 pt-3">
                                    <h4 class="card-title">
                                        <a href="{{route("blog-detail.index", $post->id)}}" class="btn-link text-reset">{{ $post->title }}</a>
                                    </h4>
                                    <p class="card-text">{{ $post->summary  }}</p>
                                    <!-- Card info -->
                                    <ul class="nav nav-divider align-items-center d-none d-sm-inline-block">
                                        <li class="nav-item">
                                            <div class="nav-link">
                                                <div class="d-flex align-items-center position-relative">
                                                    <div class="avatar avatar-xs">
                                                        @php
                                                            $author = $post->admin ?? $post->legacyAdmin;
                                                        @endphp
                                                        <img class="avatar-img rounded-circle"
                                                             src="{{ $post->admin && $post->admin->file ? asset('storage/' . $post->admin->file->path) : asset('assets/images/avatar/default.svg') }}"
                                                             alt="avatar">
                                                    </div>
                                                    <span class="ms-3">

                                                        <span class="text-reset">
                                                            {{ $author ? full_name($author->first_name ?? null, $author->last_name ?? null) : 'نویسنده' }}
                                                        </span>
                                                    </span>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="nav-item">
                                            {{ \Hekmatinasser\Verta\Verta::instance($post->created_at)->format('d F، Y') }}
                                        </li>
                                        @auth
                                            <li class="nav-item">
                                                <form action="{{ route('favorites.toggle', $post->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm {{ in_array($post->id, $favoritePostIds) ? 'btn-danger' : 'btn-outline-danger' }}">
                                                        <i class="{{ in_array($post->id, $favoritePostIds) ? 'bi bi-heart-fill' : 'bi bi-heart' }}"></i>
                                                        {{ in_array($post->id, $favoritePostIds) ? 'حذف علاقه‌مندی' : 'افزودن به علاقه‌مندی' }}
                                                    </button>
                                                </form>
                                            </li>
                                        @endauth
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- Card item END -->
                        @empty
                            <div class="col-12">
                                <div class="alert alert-info text-center">
                                    مقاله ای موجود نیست
                                </div>
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination START -->
                    @if($posts->hasPages())
                        <div class="col-12 mt-5">
                            <nav aria-label="Page navigation">
                                <ul class="pagination justify-content-center">
                                    {{-- Previous Page Link --}}
                                    @if ($posts->onFirstPage())
                                        <li class="page-item disabled">
                                            <span class="page-link">قبلی</span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $posts->previousPageUrl() }}" rel="prev">قبلی</a>
                                        </li>
                                    @endif

                                    {{-- Pagination Elements --}}
                                    @foreach ($posts->getUrlRange(1, $posts->lastPage()) as $page => $url)
                                        @if ($page == $posts->currentPage())
                                            <li class="page-item active">
                                                <span class="page-link">{{ $page }}</span>
                                            </li>
                                        @else
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                            </li>
                                        @endif
                                    @endforeach

                                    {{-- Next Page Link --}}
                                    @if ($posts->hasMorePages())
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $posts->nextPageUrl() }}" rel="next">بعدی</a>
                                        </li>
                                    @else
                                        <li class="page-item disabled">
                                            <span class="page-link">بعدی</span>
                                        </li>
                                    @endif
                                </ul>
                            </nav>
                        </div>
                    @endif
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
@endsection
