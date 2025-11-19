@extends("layout.app")

@section("content")

    <!-- =======================
Inner intro START -->
    <section class="pb-3 pb-lg-5">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    @if($post->category)

                            <i class=" fas fa-circle me-2 small fw-bold"></i>{{ $post->category->name }}

                    @endif
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                        <h1 class="mb-0">{{ $post->title }}</h1>
                        @auth
                            <form action="{{ route('favorites.toggle', $post->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn {{ $isFavorite ? 'btn-danger' : 'btn-outline-danger' }}">
                                    <i class="{{ $isFavorite ? 'bi bi-heart-fill' : 'bi bi-heart' }} me-1"></i>
                                    {{ $isFavorite ? 'حذف از علاقه‌مندی' : 'افزودن به علاقه‌مندی' }}
                                </button>
                            </form>
                        @endauth
                    </div>
                </div>
                @if($post->summary)
                    <p class="lead">{{ $post->summary }}</p>
                @endif
            </div>
        </div>
    </section>
    <!-- =======================
    Inner intro END -->

    <section class="pt-0">
        <div class="container position-relative" data-sticky-container>
            <div class="row">
                @if(session('success_favorite'))
                    <div class="col-12">
                        <div class="alert alert-info alert-dismissible fade show" role="alert">
                            {{ session('success_favorite') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                @endif
                <!-- Left sidebar START -->
                <div class="col-lg-2">
                    <div class="text-start text-lg-center mb-5" data-sticky data-margin-top="80" data-sticky-for="991">
                        <!-- Author info -->
                        @php
                            $author = $post->admin ?? $post->legacyAdmin;
                        @endphp
                        @if($author)
                            <div class="position-relative">
                                <div class="avatar avatar-xl">
                                    <img class="avatar-img rounded-circle"
                                         src="{{ $post->admin && $post->admin->file ? asset('storage/' . $post->admin->file->path) : asset('assets/images/avatar/default.svg') }}"
                                         alt="avatar">
                                </div>
                                <span class="h5 mt-2 mb-0 d-block text-reset">{{ full_name($author->first_name ?? null, $author->last_name ?? null) }}</span>
                                <p>نویسنده</p>
                            </div>
                        @endif
                        <hr class="d-none d-lg-block">
                        <!-- Card info -->
                        <ul class="list-inline list-unstyled">
                            <li class="list-inline-item d-lg-block my-lg-2">{{ \Hekmatinasser\Verta\Verta::instance($post->created_at)->format('d F، Y') }}</li>


                            <li class="list-inline-item d-lg-block my-lg-2"><i class="far fa-eye me-1"></i> {{ $post->views ?? 0 }} بازدید</li>
                        </ul>
                        <!-- Tags -->

                    </div>
                </div>
                <!-- Left sidebar END -->
                <!-- Main Content START -->
                <div class="col-lg-7 mb-5">

                    <!-- Image -->
                    <figure class="figure mt-2">
                        <a href="{{ $post->file ? asset('storage/' . $post->file->path) : asset('assets/images/placeholders/post-placeholder.svg') }}"
                           data-glightbox data-gallery="image-popup">
                            <img class="rounded mb-5"
                                 src="{{ $post->file ? asset('storage/' . $post->file->path) : asset('assets/images/placeholders/post-placeholder.svg') }}"
                                 alt="{{ $post->title }}">
                        </a>
                    </figure>

                    <!-- Post Content -->
                    <div class="post-content">
                        {!! nl2br(e($post->content)) !!}
                    </div>






                    <hr>

                    <!-- Success Message -->
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bi bi-check-circle me-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- Comments START -->
                    <div>
                        <h3>{{ $comments->count() }} دیدگاه</h3>

                        @forelse($comments as $comment)
                            <div class="my-4 d-flex">
                                <div class="avatar avatar-md rounded-circle float-start me-3">
                                    <img class="avatar-img rounded-circle"
                                         src="{{ $comment->user && $comment->user->file ? asset('storage/' . $comment->user->file->path) : asset('assets/images/avatar/default.svg') }}"
                                         alt="avatar">
                                </div>
                                <div>
                                    <div class="mb-2">
                                        <h5 class="m-0">
                                            @if($comment->user)
                                                {{ full_name($comment->user->first_name, $comment->user->last_name) }}
                                            @else
                                                {{ $comment->guest_name }}
                                            @endif
                                        </h5>
                                        <span class="me-3 small">
                                            @if($comment->created_at)
                                                {{ \Hekmatinasser\Verta\Verta::instance($comment->created_at)->format('d F، Y در H:i') }}
                                            @endif
                                        </span>
                                    </div>
                                    <p>{{ $comment->content }}</p>
                                </div>
                            </div>
                        @empty
                            <div class="alert alert-info">
                                هنوز دیدگاهی ثبت نشده است. اولین نفری باشید که دیدگاه می‌دهد!
                            </div>
                        @endforelse
                    </div>
                    <!-- Comments END -->
                    <!-- Reply START -->
                    <div>
                        <h3>ثبت دیدگاه</h3>
                        <small>آدرس ایمیل شما منتشر نخواهد شد. فیلدهای الزامی علامت گذاری شده اند *</small>
                        <form class="row g-3 mt-2" action="{{ route('blog-detail.comment') }}" method="POST">
                            @csrf
                            <input type="hidden" name="post_id" value="{{ $post->id }}">

                            @auth
                                {{-- Logged in users - show their info --}}
                                <div class="col-md-12">
                                    <div class="alert alert-info">
                                        <strong>شما به عنوان:</strong> {{ full_name(auth()->user()->first_name, auth()->user()->last_name) }} ({{ auth()->user()->email }}) دیدگاه می‌دهید.
                                    </div>
                                </div>
                            @else
                                {{-- Guests - show name and email fields --}}
                                <div class="col-md-6">
                                    <label class="form-label">نام *</label>
                                    <input type="text" class="form-control @error('guest_name') is-invalid @enderror"
                                           name="guest_name" value="{{ old('guest_name') }}" required>
                                    @error('guest_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">ایمیل *</label>
                                    <input type="email" class="form-control @error('guest_email') is-invalid @enderror"
                                           name="guest_email" value="{{ old('guest_email') }}" required>
                                    @error('guest_email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            @endauth

                            <div class="col-12">
                                <label class="form-label">متن دیدگاه *</label>
                                <textarea class="form-control @error('content') is-invalid @enderror"
                                          name="content" rows="3" required>{{ old('content') }}</textarea>
                                @error('content')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">ثبت دیدگاه</button>
                            </div>
                        </form>
                    </div>
                    <!-- Reply END -->



    </section>

@endsection
