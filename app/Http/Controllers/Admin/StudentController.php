<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::latest()->paginate(6);

        return view('admin.students.index', compact('students'));
    }

    public function show(Student $student)
    {
        $student->load('user');

        return view('admin.students.show', compact('student'));
    }
}