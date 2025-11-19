@extends('layout.app')

@section('content')
    <div class="container-fluid p-4" dir="rtl">
        <h1 class="mb-4">پنل مدیریت کاربران</h1>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form method="GET" class="mb-3 d-flex gap-2">
            <input type="text" name="search" class="form-control" placeholder="جستجو..." value="{{ request('search') }}">
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
            @forelse($users as $user)
                <tr>
                    <td class="text-end">{{ $user->first_name }} {{ $user->last_name }}</td>
                    <td class="text-end">{{ $user->email }}</td>
                    <td class="text-end">{{ $user->mobile ?? '-' }}</td>
                    <td class="text-center">
                        <form action="{{ route('admin.toggle-admin', $user->id) }}" method="POST">
                            @csrf
                            <button class="btn btn-sm btn-info" type="submit">
                                {{ $user->admin ? 'مدیر' : 'کاربر' }}
                            </button>
                        </form>
                    </td>
                    <td class="text-center">
                        <a href="{{ route('admin.edit', $user->id) }}" class="btn btn-sm btn-primary">ویرایش</a>

                        <form action="{{ route('admin.destroy', $user->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('آیا مطمئن هستید؟')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" type="submit">حذف</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">کاربری یافت نشد</td>
                </tr>
            @endforelse
            </tbody>
        </table>

        <div class="mt-3">
            {{ $users->links() }}
        </div>
    </div>
@endsection
