@extends('layout.app')

@section('content')
    <div class="container p-4" dir="rtl">
        <h2 class="mb-4">ویرایش کاربر</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.update', $user->id) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">نام</label>
                <input type="text" class="form-control" name="first_name" value="{{ old('first_name', $user->first_name) }}" >
            </div>

            <div class="mb-3">
                <label class="form-label">نام خانوادگی</label>
                <input type="text" class="form-control" name="last_name" value="{{ old('last_name', $user->last_name) }}">
            </div>

            <div class="mb-3">
                <label class="form-label">ایمیل</label>
                <input type="email" class="form-control" name="email" value="{{ old('email', $user->email) }}" >
            </div>

            <div class="mb-3">
                <label class="form-label">موبایل</label>
                <input type="text" class="form-control" name="mobile" value="{{ old('mobile', $user->mobile) }}">
            </div>

            <div class="mb-3">
                <label class="form-label">رمز عبور </label>
                <input type="password" class="form-control" name="password">
            </div>

            <button class="btn btn-primary">ذخیره تغییرات</button>
            <a href="{{ route('admin.panel') }}" class="btn btn-secondary">بازگشت</a>
        </form>
    </div>
@endsection
