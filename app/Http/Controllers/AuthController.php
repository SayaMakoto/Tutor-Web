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
            return redirect()->route('student.home')
                ->with('success', 'Đăng ký gia sư thành công! Vui lòng chờ admin duyệt.');
        }

        return redirect()->route('login')
            ->with('success', 'Đăng ký gia sư thành công! Vui lòng đăng nhập.');
    }

    /**
     * Học viên đã đăng nhập đăng ký thêm vai trò gia sư.
     * Route: POST /become-tutor (middleware: auth, not.tutor)
     */
    public function becomeTutor(RegisterTutorRequest $request)
    {
        $user = auth()->user();

        // Tạo hồ sơ gia sư và nâng role lên 'both'
        Tutor::create([
            'user_id'    => $user->id,
            'bio'        => $request->bio,
            'education'  => $request->education,
            'experience' => $request->experience,
        ]);

        $user->update(['role' => 'both']);

        return redirect()->route('student.home')
            ->with('success', 'Đăng ký gia sư thành công! Vui lòng chờ admin duyệt hồ sơ của bạn.');
    }


    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            $deletedUser = User::onlyTrashed()->where('email', $request->email)->first();
            if ($deletedUser && Hash::check($request->password, $deletedUser->password)) {
                
                // Xóa cứng (force delete) sau khi họ đã thấy thông báo
                $tutor = Tutor::withTrashed()->where('user_id', $deletedUser->id)->first();
                if ($tutor) {
                    $tutor->forceDelete();
                }
                $deletedUser->forceDelete();

                return back()->withErrors([
                    'email' => 'Tài khoản của bạn đã bị xoá do hồ sơ gia sư không đạt yêu cầu.'
                ])->withInput();
            }

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

        if ($user->role === 'tutor' && $user->tutor && $user->tutor->status === 'rejected') {
            Auth::guard('web')->logout();
            return redirect()->route('login')->with('rejected', true);
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

    public function forgotPasswordStore(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return back()->withErrors(['email' => 'Không tìm thấy tài khoản với email này.']);
        }

        // Mock xác thực: Bỏ qua bước gửi email, chuyển thẳng đến trang đặt lại mật khẩu
        return redirect()->route('reset-password')->with('reset_email', $request->email);
    }

    public function resetPassword()
    {
        if (!session('reset_email') && !session('_old_input')) {
            return redirect()->route('forgot-password');
        }
        return view('auth.reset-password');
    }

    public function resetPasswordStore(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);
        
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return back()->withErrors(['email' => 'Không tìm thấy tài khoản.']);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('login')->with('success', 'Mật khẩu đã được đặt lại thành công. Vui lòng đăng nhập.');
    }

    public function adminLogout(Request $request)
    {
        // Chỉ logout guard 'admin' — KHÔNG invalidate() toàn bộ session
        // vì invalidate() sẽ xóa cả session của guard 'web' (student/tutor/both).
        Auth::guard('admin')->logout();

        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}