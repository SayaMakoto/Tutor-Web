<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        //Đếm số lượng học viên đang hoạt động (user có role là student và both)
        $countStudents = \App\Models\User::where('role', 'student')->count();
        $countStudents += \App\Models\User::where('role', 'both')->count();

        //Đếm số lượng lớp đang hoạt động
        $countActiveClasses = \App\Models\ClassRequest::where('status', 'assigned')
            ->whereHas('tutorClass')
            ->count();


        //Đếm số lượng gia sư đang hoạt động (user có role là tutor và both)
        $countTutors = \App\Models\User::where('role', 'tutor')->count();
        $countTutors += \App\Models\User::where('role', 'both')->count();
        return view('admin.home', compact('countStudents', 'countActiveClasses', 'countTutors'));
    }
}