@extends('layout.app')

@section('content')
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
                                @if(session('success_profile'))
                                    <div class="alert alert-success">{{ session('success_profile') }}</div>
                                @endif
                                <form action="{{ route('dashboard.profile.update') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <!-- Full name -->
                                    <div class="mb-3">
                                        <label class="form-label">نام کامل</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control @error('first_name') is-invalid @enderror"
                                                   name="first_name" value="{{ old('first_name', $user->first_name) }}" placeholder="نام">
                                            <input type="text" class="form-control @error('last_name') is-invalid @enderror"
                                                   name="last_name" value="{{ old('last_name', $user->last_name) }}" placeholder="نام خانوادگی">
                                        </div>
                                        @error('first_name') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                                        @error('last_name') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                                    </div>

                                    <!-- Username -->
                                    <div class="mb-3">
                                        <label class="form-label">نام کاربری</label>
                                        <input type="text" class="form-control @error('username') is-invalid @enderror"
                                               name="username" value="{{ old('username', $user->username) }}">
                                        @error('username') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                                    </div>

                                    <!-- Email -->
                                    <div class="mb-3">
                                        <label class="form-label">پست الکترونیکی</label>
                                        <input class="form-control @error('email') is-invalid @enderror" type="email"
                                               name="email" value="{{ old('email', $user->email) }}">
                                        @error('email') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                                    </div>

                                    <!-- Profile picture -->
                                    <div class="mb-3">
                                        <label class="form-label">تصویر پروفایل</label>
                                        <div class="d-flex align-items-center mb-2">
                                            <div class="position-relative me-3">
                                                <div class="avatar avatar-xl">
                                                    <img class="avatar-img rounded-circle border border-white border-3 shadow"
                                                         src="{{ $user->file ? asset('storage/' . $user->file->path) : asset('assets/images/avatar/default.svg') }}"
                                                         alt="avatar">
                                                </div>
                                            </div>
                                            <div>
                                                <input type="file" class="form-control @error('avatar') is-invalid @enderror"
                                                       name="avatar" accept="image/*">
                                                @error('avatar') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                                            </div>
                                        </div>
                                        @if($user->file)
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="remove_avatar" value="1" id="remove_avatar">
                                                <label class="form-check-label" for="remove_avatar">حذف تصویر پروفایل فعلی</label>
                                            </div>
                                        @endif
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
                                @if(session('success_password'))
                                    <div class="alert alert-success">{{ session('success_password') }}</div>
                                @endif
                                <form action="{{ route('dashboard.password.update') }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label">رمز عبور فعلی</label>
                                        <input class="form-control @error('current_password') is-invalid @enderror"
                                               name="current_password" type="password" placeholder="*********">
                                        @error('current_password') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">رمز عبور جدید</label>
                                        <input class="form-control @error('password') is-invalid @enderror"
                                               name="password" type="password" placeholder="*********">
                                        @error('password') <div class="text-danger mt-1">{{ $message }}</div> @enderror
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
                                <span class="badge bg-primary">{{ $favorites->total() }}</span>
                            </div>
                            <div class="card-body flex-grow-1 overflow-auto">
                                @forelse($favorites as $favorite)
                                    <div class="d-flex mb-3 pb-3 border-bottom">
                                        <div class="flex-shrink-0 rounded me-3" style="width: 72px;">
                                            <img class="img-fluid rounded"
                                                 src="{{ $favorite->file ? asset('storage/' . $favorite->file->path) : asset('assets/images/placeholders/post-placeholder.svg') }}"
                                                 alt="{{ $favorite->title }}">
                                        </div>
                                        <div class="flex-grow-1">
                                        <span class="fw-semibold text-dark">
                                            <a href="{{ route('blog-detail.index', $favorite->id) }}" class="text-decoration-none text-primary">
                                                {{ $favorite->title }}
                                            </a>
                                        </span>
                                            <div class="small text-muted mt-1">
                                                {{ $favorite->category?->name ?? 'بدون دسته‌بندی' }}
                                            </div>
                                            <div class="d-flex justify-content-between text-muted small mt-2">
                                                <span>{{ \Hekmatinasser\Verta\Verta::instance($favorite->pivot->created_at)->format('Y/m/d') }}</span>
                                                <span><i class="far fa-eye me-1"></i>{{ $favorite->views ?? 0 }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-muted mb-0">هنوز خبری را به علاقه‌مندی اضافه نکرده‌اید.</p>
                                @endforelse
                            </div>

                            <!-- Favorites Pagination -->
                            @if($favorites->hasPages())
                                <div class="card-footer border-0 pt-1 pb-2">
                                    <nav aria-label="Page navigation">
                                        {{ $favorites->appends(request()->except('favorites_page'))->links('pagination::bootstrap-5') }}
                                    </nav>
                                </div>
                            @endif
                        </div>

                        <!-- Recent Comments Card -->
                        <div class="card border h-100 d-flex flex-column">
                            <div class="card-header border-bottom p-3 d-flex justify-content-between align-items-center">
                                <h5 class="card-header-title mb-0">آخرین نظرات</h5>
                                <span class="badge bg-primary">{{ $recentComments->total() }}</span>
                            </div>
                            <div class="card-body p-3 flex-grow-1 overflow-auto">
                                <div class="row">
                                    @forelse($recentComments as $comment)
                                        <div class="col-12 mb-3">
                                            <div class="d-flex align-items-center position-relative">
                                                <div class="avatar avatar-lg flex-shrink-0">
                                                    <img class="avatar-img rounded-2"
                                                         src="{{ $comment->post->file ? asset('storage/' . $comment->post->file->path) : asset('assets/images/placeholders/post-placeholder.svg') }}"
                                                         alt="{{ $comment->post->title }}">
                                                </div>
                                                <div class="ms-3">
                                                    <p class="mb-1">
                                                        <a class="h6 fw-normal stretched-link"
                                                           href="{{ route('blog-detail.index', $comment->post_id) }}#comment-{{ $comment->id }}">
                                                            {{ Str::limit($comment->content, 60) }}
                                                        </a>
                                                    </p>
                                                    <div class="d-flex justify-content-between">
                                                        <p class="small mb-0">{{ Str::limit($comment->post->title, 40) }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="col-12">
                                            <p class="text-muted mb-0">هنوز نظری ثبت نشده است.</p>
                                        </div>
                                    @endforelse
                                </div>
                            </div>

                            <!-- Comments Pagination -->
                            @if($recentComments->hasPages())
                                <div class="card-footer border-0 pt-1 pb-2">
                                    <nav aria-label="Page navigation">
                                        {{ $recentComments->appends(request()->except('comments_page'))->links('pagination::bootstrap-5') }}
                                    </nav>
                                </div>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
