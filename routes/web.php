<?php

//ADMIN
use App\Http\Controllers\AboutController;
use App\Http\Controllers\Admin\AdminApplicationController;
use App\Http\Controllers\Admin\AdminClassRequestController;
use App\Http\Controllers\Admin\AdminContactController;
use App\Http\Controllers\Admin\AdminGradeController;
use App\Http\Controllers\Admin\AdminSubjectController;
use App\Http\Controllers\Admin\AdminTutorController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\StudentController as AdminStudentController;

// STUDENT
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Student\StudentApplicationController;
use App\Http\Controllers\Student\StudentHomeController;
use App\Http\Controllers\Student\CreateClassController;
use App\Http\Controllers\Student\ClassRequestController;
use App\Http\Controllers\Student\TutorController;

// TUTOR
use App\Http\Controllers\Tutor\TutorClassController;
use App\Http\Controllers\Tutor\TutorHomeController;
use App\Http\Controllers\Tutor\TutorProfileController;

// AUTH
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;

use Illuminate\Support\Facades\Route;

// =======================
// STUDENT
// =======================

Route::get('/', function () {
    return redirect()->route('student.home');
});

Route::prefix('student')->name('student.')->group(function () {

    // PUBLIC - guest xem được
    Route::get('/', [StudentHomeController::class, 'index'])
        ->name('home');

    // PRIVATE - cần login
    Route::middleware(['auth', 'role:student,both'])->group(function () {

        Route::get('/applications', [StudentApplicationController::class, 'index'])
            ->name('applications.index');

        Route::post('/applications/{application}/accept', [StudentApplicationController::class, 'accept'])
            ->name('applications.accept');

        Route::post('/applications/{application}/reject', [StudentApplicationController::class, 'reject'])
            ->name('applications.reject');

        Route::get('/tutor/{id}', [TutorController::class, 'show'])
            ->name('tutor.show');
    });

});
// =========================
// AUTH - Trang đăng ký
// =========================
Route::middleware('guest')->group(function () {

    Route::prefix('register')->name('register.')->group(function () {

        // Trang đăng ký học viên
        Route::view('/student', 'auth.student_register')
            ->name('student');

        // Trang đăng ký gia sư
        Route::view('/tutor', 'auth.tutor_register')
            ->name('tutor');

        // Xử lý đăng ký
        Route::post('/student', [AuthController::class, 'registerStudent'])
            ->name('student.store');

        Route::post('/tutor', [AuthController::class, 'registerTutor'])
            ->name('tutor.store');
    });

    // Trang chọn vai trò
    Route::view('/role', 'auth.role')->name('role');

    // Login
    Route::view('/login', 'auth.login')->name('login');
    Route::post('/login', [AuthController::class, 'login'])
        ->name('login.store');
});

// =========================
// AUTH - User đã login
// =========================
Route::middleware(['auth', 'not.tutor'])->group(function () {

    Route::get('/become-tutor', function () {
        return view('auth.tutor_register');
    })->name('become-tutor');
});

// Đăng xuất
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// Trang lớp học
Route::prefix('classes')->name('classes.')->group(function () {

    Route::get('/', [ClassRequestController::class, 'index'])->name('index');

    Route::middleware(['auth', 'role:student,both'])->group(function () {
        Route::get('/{id}/edit', [ClassRequestController::class, 'edit'])->name('edit');
        Route::put('/{id}', [ClassRequestController::class, 'update'])->name('update');
        Route::delete('/{class_request}', [ClassRequestController::class, 'destroy'])->name('destroy');
    });

    Route::get('/{class_request}', [ClassRequestController::class, 'show'])->name('show');
});

// Trang tạo lớp học
Route::middleware(['auth', 'role:student,both'])
    ->prefix('create-class')
    ->name('create-class.')
    ->group(function () {

        // Bước 1: Chọn ngành học và môn học
        Route::get('/step-1', [CreateClassController::class, 'step1'])->name('step1');
        Route::post('/step-1', [CreateClassController::class, 'postStep1'])->name('post.step1');

        // Bước 2: Nhập yêu cầu chi tiết về gia sư
        Route::get('/step-2', [CreateClassController::class, 'step2'])->name('step2');
        Route::post('/step-2', [CreateClassController::class, 'postStep2'])->name('post.step2');

        // Bước 3: Chọn hình thức và địa chỉ học
        Route::get('/step-3', [CreateClassController::class, 'step3'])->name('step3');
        Route::post('/step-3', [CreateClassController::class, 'postStep3'])->name('post.step3');

        // Bước 4: Chọn thời gian học
        Route::get('/step-4', [CreateClassController::class, 'step4'])->name('step4');
        Route::post('/step-4', [CreateClassController::class, 'postStep4'])->name('post.step4');

        // Bước 5: Xác nhận và tạo lớp học
        Route::get('/confirm', [CreateClassController::class, 'confirm'])->name('confirm');
        Route::post('/store', [CreateClassController::class, 'store'])->name('store');
    });


// =======================
// TUTOR
// =======================

Route::prefix('tutor')
    ->middleware(['auth', 'role:tutor,both'])
    ->name('tutor.')
    ->group(function () {

        Route::get('/', [TutorHomeController::class, 'index'])
            ->name('home');

        Route::get('/profile/edit', [TutorProfileController::class, 'edit'])
            ->name('profile.edit');

        Route::put('/profile/update', [TutorProfileController::class, 'update'])
            ->name('profile.update');

        Route::get('/classes', [TutorClassController::class, 'index'])
            ->name('classes.index');
        Route::get('/classes/{class}', [TutorClassController::class, 'show'])
            ->name('classes.show');
        Route::post('/classes/{class}/invite', [TutorClassController::class, 'invite'])
            ->name('classes.invite');
        Route::get('/assigned-classes', [TutorClassController::class, 'assigned'])
            ->name('classes.assigned');
    });

// =======================
// USER PROFILE
// =======================

Route::middleware(['auth'])->group(function () {

    Route::get('/profile/edit', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::put('/profile/update', [ProfileController::class, 'update'])
        ->name('profile.update');
});

Route::middleware('auth')->group(function () {

    Route::get('/contact', [ContactController::class, 'index'])
        ->name('contact');

    Route::post('/contact', [ContactController::class, 'store'])
        ->name('contact.store');
});

Route::get('/about', [AboutController::class, 'index'])
    ->name('about');






// =======================
// ADMIN
// =======================
Route::prefix('admin')->name('admin.')->group(function () {

    // Trang login admin
    Route::middleware('guest')->group(function () {
        Route::view('/login', 'auth.admin_login')->name('login');
        Route::post('/login', [AuthController::class, 'adminLogin'])
            ->name('login.store');
    });

});

Route::prefix('admin')
    ->middleware(['auth:admin'])
    ->name('admin.')
    ->group(function () {

        Route::get('/', [DashboardController::class, 'index'])
            ->name('home');

        Route::post('/admin/logout', [AuthController::class, 'adminLogout'])
            ->middleware('auth:admin')
            ->name('logout');

        // Quản lý đơn đăng lớp học
        Route::get(
            'class-requests/trash',
            [AdminClassRequestController::class, 'trash']
        )->name('class-requests.trash');
        Route::delete('class-requests/{id}/force-delete', [AdminClassRequestController::class, 'forceDelete'])
            ->name('class-requests.forceDelete');
        Route::resource('class-requests', AdminClassRequestController::class);

        // Quản lý đơn nhận lớp học
        Route::get('applications', [AdminApplicationController::class, 'index'])
            ->name('applications.index');

        // Tạo môn học mới từ đơn đăng lớp học
        Route::post(
            'class-requests/{id}/create-subject',
            [AdminClassRequestController::class, 'createSubject']
        )->name('class-requests.create-subject');

        // Tạo khối học mới từ đơn đăng lớp học
        Route::post(
            'class-requests/{id}/create-grade',
            [AdminClassRequestController::class, 'createGrade']
        )->name('class-requests.create-grade');

        // Quản lý gia sư
        Route::resource('tutors', AdminTutorController::class);

        // Quản lý người dùng
        Route::get('users', [AdminUserController::class, 'index'])
            ->name('users.index');

        // Quản lý học viên
        Route::resource('students', AdminStudentController::class);

        // Quản lý môn học
        Route::patch(
            'subjects/{subject}/toggle-status',
            [AdminSubjectController::class, 'toggleStatus']
        )->name('subjects.toggleStatus');
        Route::get('subjects/trash', [AdminSubjectController::class, 'trash'])
            ->name('subjects.trash');
        Route::post('subjects/{id}/restore', [AdminSubjectController::class, 'restore'])
            ->name('subjects.restore');
        Route::delete('subjects/{id}/force-delete', [AdminSubjectController::class, 'forceDelete'])
            ->name('subjects.forceDelete');
        Route::resource('subjects', AdminSubjectController::class);

        // Quản lý ngành học
        Route::patch(
            'grades/{grade}/toggle-status',
            [AdminGradeController::class, 'toggleStatus']
        )->name('grades.toggleStatus');
        Route::get('grades/trash', [AdminGradeController::class, 'trash'])
            ->name('grades.trash');
        Route::post('grades/{id}/restore', [AdminGradeController::class, 'restore'])
            ->name('grades.restore');
        Route::delete('grades/{id}/force-delete', [AdminGradeController::class, 'forceDelete'])
            ->name('grades.forceDelete');
        Route::resource('grades', AdminGradeController::class);

        Route::get('contacts', [AdminContactController::class, 'index'])
            ->name('contacts.index');
        Route::post('contacts/{id}/reply', [AdminContactController::class, 'reply'])
            ->name('contacts.reply');
    });