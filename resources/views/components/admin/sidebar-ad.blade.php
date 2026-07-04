@inject('tutorModel',       'App\Models\Tutor')
@inject('classReqModel',    'App\Models\ClassRequest')
@inject('contactModel',     'App\Models\Contact')

@php
    $pendingTutors      = $tutorModel::where('status', 'pending')->count();
    $pendingClassReqs   = $classReqModel::where('status', 'pending')->count();
    $pendingContacts    = $contactModel::where('status', 'pending')->count();
@endphp

<aside class="w-64 bg-white border-r border-gray-100 shadow-sm sticky top-14 h-[calc(100vh-56px)]
             hidden md:flex flex-col overflow-y-auto">

    {{-- Nav --}}
    <nav class="flex-1 p-4 space-y-0.5">

        {{-- Dashboard --}}
        <a href="{{ route('admin.home') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all
                  {{ request()->routeIs('admin.home')
                     ? 'bg-violet-600 text-white shadow-sm'
                     : 'text-gray-600 hover:bg-violet-50 hover:text-violet-700' }}">
            <i class="fas fa-gauge-high w-4 text-center"></i>
            <span>Dashboard</span>
        </a>

        {{-- ─── Người dùng ─────────────────────────── --}}
        <div class="pt-3 pb-1">
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest px-3">Người dùng</p>
        </div>

        <a href="{{ route('admin.users.index') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all
                  {{ request()->routeIs('admin.users.*')
                     ? 'bg-violet-600 text-white shadow-sm'
                     : 'text-gray-600 hover:bg-violet-50 hover:text-violet-700' }}">
            <i class="fas fa-users w-4 text-center"></i>
            <span>Tất cả người dùng</span>
        </a>

        <a href="{{ route('admin.students.index') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all
                  {{ request()->routeIs('admin.students.*')
                     ? 'bg-violet-600 text-white shadow-sm'
                     : 'text-gray-600 hover:bg-violet-50 hover:text-violet-700' }}">
            <i class="fas fa-user-graduate w-4 text-center"></i>
            <span>Học viên</span>
        </a>

        <a href="{{ route('admin.tutors.index') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all
                  {{ request()->routeIs('admin.tutors.*')
                     ? 'bg-violet-600 text-white shadow-sm'
                     : 'text-gray-600 hover:bg-violet-50 hover:text-violet-700' }}">
            <i class="fas fa-chalkboard-teacher w-4 text-center"></i>
            <span class="flex-1">Gia sư</span>
            @if($pendingTutors > 0)
                <span class="inline-flex items-center justify-center min-w-[18px] h-[18px] px-1 rounded-full
                             bg-red-500 text-white text-[10px] font-bold leading-none shadow-sm">
                    {{ $pendingTutors > 99 ? '99+' : $pendingTutors }}
                </span>
            @endif
        </a>

        {{-- ─── Quản lý lớp ───────────────────────── --}}
        <div class="pt-3 pb-1">
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest px-3">Quản lý lớp</p>
        </div>

        <a href="{{ route('admin.class-requests.index') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all
                  {{ request()->routeIs('admin.class-requests.*')
                     ? 'bg-violet-600 text-white shadow-sm'
                     : 'text-gray-600 hover:bg-violet-50 hover:text-violet-700' }}">
            <i class="fas fa-file-lines w-4 text-center"></i>
            <span class="flex-1">Đơn đăng lớp</span>
            @if($pendingClassReqs > 0)
                <span class="inline-flex items-center justify-center min-w-[18px] h-[18px] px-1 rounded-full
                             bg-red-500 text-white text-[10px] font-bold leading-none shadow-sm">
                    {{ $pendingClassReqs > 99 ? '99+' : $pendingClassReqs }}
                </span>
            @endif
        </a>

        <a href="{{ route('admin.applications.index') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all
                  {{ request()->routeIs('admin.applications.*')
                     ? 'bg-violet-600 text-white shadow-sm'
                     : 'text-gray-600 hover:bg-violet-50 hover:text-violet-700' }}">
            <i class="fas fa-handshake w-4 text-center"></i>
            <span>Đơn nhận lớp</span>
        </a>

        {{-- ─── Danh mục ──────────────────────────── --}}
        <div class="pt-3 pb-1">
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest px-3">Danh mục</p>
        </div>

        <a href="{{ route('admin.grades.index') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all
                  {{ request()->routeIs('admin.grades.*')
                     ? 'bg-violet-600 text-white shadow-sm'
                     : 'text-gray-600 hover:bg-violet-50 hover:text-violet-700' }}">
            <i class="fas fa-layer-group w-4 text-center"></i>
            <span>Ngành học</span>
        </a>

        <a href="{{ route('admin.subjects.index') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all
                  {{ request()->routeIs('admin.subjects.*')
                     ? 'bg-violet-600 text-white shadow-sm'
                     : 'text-gray-600 hover:bg-violet-50 hover:text-violet-700' }}">
            <i class="fas fa-book w-4 text-center"></i>
            <span>Môn học</span>
        </a>

        {{-- ─── Hỗ trợ ─────────────────────────────── --}}
        <div class="pt-3 pb-1">
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest px-3">Hỗ trợ</p>
        </div>

        <a href="{{ route('admin.contacts.index') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all
                  {{ request()->routeIs('admin.contacts.*')
                     ? 'bg-violet-600 text-white shadow-sm'
                     : 'text-gray-600 hover:bg-violet-50 hover:text-violet-700' }}">
            <i class="fas fa-envelope w-4 text-center"></i>
            <span class="flex-1">Liên hệ</span>
            @if($pendingContacts > 0)
                <span class="inline-flex items-center justify-center min-w-[18px] h-[18px] px-1 rounded-full
                             bg-red-500 text-white text-[10px] font-bold leading-none shadow-sm">
                    {{ $pendingContacts > 99 ? '99+' : $pendingContacts }}
                </span>
            @endif
        </a>

    </nav>

    {{-- Footer sidebar --}}
    <div class="p-4 border-t border-gray-100">
        <div class="flex items-center gap-2 px-3 py-2 bg-violet-50 rounded-xl">
            <div class="w-7 h-7 bg-violet-100 rounded-lg flex items-center justify-center flex-shrink-0">
                <i class="fas fa-shield-halved text-violet-600 text-xs"></i>
            </div>
            <div class="min-w-0">
                <p class="text-xs font-semibold text-violet-800 truncate">Quản trị viên</p>
                <p class="text-[10px] text-violet-500 truncate">{{ Auth::user()->email }}</p>
            </div>
        </div>
    </div>

</aside>

