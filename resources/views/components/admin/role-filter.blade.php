<form method="GET" class="flex items-center gap-3">

    <select name="role" onchange="this.form.submit()"
        class="px-4 py-2 border rounded-lg text-sm focus:ring-2 focus:ring-blue-400">

        <option value="">Tất cả vai trò</option>

        <option value="student" {{ request('role') === 'student' ? 'selected' : '' }}>
            Học viên
        </option>

        <option value="tutor" {{ request('role') === 'tutor' ? 'selected' : '' }}>
            Gia sư
        </option>

        <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>
            Quản trị viên
        </option>

    </select>

    @if (request('role'))
        <a href="{{ route('admin.users.index') }}" class="px-3 py-2 text-sm bg-gray-200 rounded-lg hover:bg-gray-300">
            Xóa lọc
        </a>
    @endif

</form>
