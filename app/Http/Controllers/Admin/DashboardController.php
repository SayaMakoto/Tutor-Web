<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        //Đếm số lượng học viên đang hoạt động
        $countStudents = \App\Models\User::where('role', 'student')->count();

        //Đếm số lượng lớp đang hoạt động
        $countActiveClasses = \App\Models\ClassRequest::where('status', 'assigned')
            ->whereNotNull('tutor_id')
            ->count();

        //Đếm số lượng gia sư đang hoạt động
        $countTutors = \App\Models\User::where('role', 'tutor')->count();
        return view('admin.home', compact('countStudents', 'countActiveClasses', 'countTutors'));
    }
}