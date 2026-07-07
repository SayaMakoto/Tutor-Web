<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterStudentRequest;
use App\Http\Requests\RegisterTutorRequest;
use App\Models\Student;
use App\Models\Tutor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    public function registerStudent(RegisterStudentRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'gender' => $request->gender,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'student'
        ]);

        Student::create([
            'user_id' => $user->id
        ]);

        return redirect()->route('login')
            ->with('success', 'Đăng ký thành công');
    }

    public function registerTutor(RegisterTutorRequest $request)
    {
        if (auth()->check()) {

            $user = auth()->user();

            if (in_array($user->role, ['tutor', 'both'])) {
                return back()->with('error', 'Bạn đã đăng ký làm gia sư rồi.');
            }

            if ($user->role === 'student') {
                $user->update(['role' => 'both']);
            }

        } else {

            $user = User::create([
                'name' => $request->name,
                'gender' => $request->gender,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'role' => 'tutor'
            ]);
        }

        Tutor::create([
            'user_id' => $user->id,
            'bio' => $request->bio,
            'education' => $request->education,
            'experience' => $request->experience,
        ]);

        if (auth()->check()) {
            return redirect('/')
                ->with('success', 'Đăng ký gia sư thành công! Vui lòng chờ admin duyệt.');
        }

        return redirect()->route('login')
            ->with('success', 'Đăng ký gia sư thành công! Vui lòng đăng nhập.');
    }


    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            return back()->withErrors([
                'email' => 'Email hoặc mật khẩu không đúng.'
            ])->withInput();
        }

        $user = Auth::user();

        if ($user->role === 'admin') {
            Auth::guard('web')->logout();
            return back()->withErrors([
                'email' => 'Vui lòng sử dụng trang đăng nhập Admin dành riêng cho quản trị viên.'
            ])->withInput();
        }

        $request->session()->regenerate();

        return match ($user->role) {
            'tutor' => redirect()->route('tutor.home'),
            'student', 'both' => redirect()->route('student.home'),
            default => redirect('/')
        };
    }

    public function adminLogin(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (
            !Auth::guard('admin')->attempt(
                array_merge($credentials, ['role' => 'admin'])
            )
        ) {
            return back()->withErrors([
                'email' => 'Email, mật khẩu hoặc quyền admin không đúng.'
            ])->withInput();
        }

        $request->session()->regenerate();

        return redirect()->route('admin.home');
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    public function adminLogout(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}