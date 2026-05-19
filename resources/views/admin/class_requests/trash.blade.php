@extends('layouts.admin')
@section('title', 'Thùng rác yêu cầu đăng lớp')
@section('content')
    <div class="bg-white p-6 rounded-2xl shadow-md">

        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold text-gray-800">
                Danh sách yêu cầu mở lớp đã xóa
            </h2>
        </div>

        <!-- TABLE -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">

                <thead>
                    <tr class="bg-gray-100 text-gray-600 uppercase text-sm">
                        <th class="p-3">Mã yêu cầu</th>
                        <th class="p-3">Tên người yêu cầu</th>
                        <th class="p-3 text-center">Xem chi tiết</th>
                        <th class="p-3 text-center">Hành động</th>
                    </tr>
                </thead>

                <tbody class="divide-y">
                    @forelse ($classRequests as $request)
                        <tr class="hover:bg-gray-50">

                            <td class="p-3 font-medium text-gray-700">
                                #{{ $request->id }}
                            </td>

                            <td class="p-3">
                                {{ $request->student_name }}
                            </td>

                            <!-- VIEW DETAIL -->
                            <td class="p-3 text-center">
                                <a href="{{ route('admin.class-requests.show', $request->id) }}"
                                    class="text-blue-600 hover:text-blue-800 transition">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                            </td>

                            <!-- FORCE DELETE -->
                            <td class="p-3 text-center">
                                <form action="{{ route('admin.class-requests.forceDelete', $request->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')

                                    <button onclick="return confirm('Xóa vĩnh viễn yêu cầu này?')"
                                        class="text-red-600 hover:text-red-800 transition">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-6 text-center text-gray-500">
                                <div class="flex flex-col items-center gap-2">
                                    <i class="fa-solid fa-box-open text-3xl text-gray-400"></i>
                                    <span class="text-sm">
                                        Hiện tại chưa có yêu cầu nào trong thùng rác.
                                    </span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

        <!-- FOOTER -->
        <div class="flex justify-between items-center mt-6">

            <a href="{{ route('admin.class-requests.index') }}"
                class="text-blue-600 hover:text-blue-800 flex items-center gap-2">
                <i class="fa-solid fa-arrow-left"></i>
                Quay lại
            </a>

            <div>
                {{ $classRequests->links() }}
            </div>

        </div>

    </div>
@endsection
