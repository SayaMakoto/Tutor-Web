<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Tutor;

class TutorController extends Controller
{
    public function show($id)
    {
        $tutor = Tutor::with('user', 'subjects')->findOrFail($id);

        return view('student.tutor.show', compact('tutor'));
    }
}