<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Disable foreign key checks for clean truncation
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('reviews')->truncate();
        DB::table('payments')->truncate();
        DB::table('applications')->truncate();
        DB::table('class_requests')->truncate();
        DB::table('tutor_subjects')->truncate();
        DB::table('grade_subject')->truncate();
        DB::table('tutor_documents')->truncate();
        DB::table('tutors')->truncate();
        DB::table('students')->truncate();
        DB::table('contacts')->truncate();
        DB::table('users')->truncate();
        DB::table('subjects')->truncate();
        DB::table('grades')->truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 1. Seed Grades
        $grades = [
            ['name' => 'Tiểu học', 'sort_order' => '1', 'status' => true],
            ['name' => 'Trung học cơ sở', 'sort_order' => '2', 'status' => true],
            ['name' => 'Trung học phổ thông', 'sort_order' => '3', 'status' => true],
            ['name' => 'Luyện thi Đại học', 'sort_order' => '4', 'status' => true],
            ['name' => 'Ngoại ngữ', 'sort_order' => '5', 'status' => true],
        ];
        foreach ($grades as $g) {
            DB::table('grades')->insert(array_merge($g, ['created_at' => now(), 'updated_at' => now()]));
        }

        // 2. Seed Subjects
        $subjects = [
            ['name' => 'Toán học', 'status' => true],
            ['name' => 'Ngữ văn', 'status' => true],
            ['name' => 'Tiếng Anh', 'status' => true],
            ['name' => 'Vật lý', 'status' => true],
            ['name' => 'Hóa học', 'status' => true],
            ['name' => 'Sinh học', 'status' => true],
            ['name' => 'Tin học', 'status' => true],
        ];
        foreach ($subjects as $s) {
            DB::table('subjects')->insert(array_merge($s, ['created_at' => now(), 'updated_at' => now()]));
        }

        // 3. Seed Grade_Subject Mappings
        // Get inserted Grade and Subject IDs
        $gradeIds = DB::table('grades')->pluck('id', 'name');
        $subjectIds = DB::table('subjects')->pluck('id', 'name');

        $gradeSubjectMappings = [
            'Tiểu học' => ['Toán học', 'Ngữ văn', 'Tiếng Anh'],
            'Trung học cơ sở' => ['Toán học', 'Ngữ văn', 'Tiếng Anh', 'Vật lý', 'Hóa học', 'Sinh học', 'Tin học'],
            'Trung học phổ thông' => ['Toán học', 'Ngữ văn', 'Tiếng Anh', 'Vật lý', 'Hóa học', 'Sinh học', 'Tin học'],
            'Luyện thi Đại học' => ['Toán học', 'Ngữ văn', 'Tiếng Anh', 'Vật lý', 'Hóa học', 'Sinh học'],
            'Ngoại ngữ' => ['Tiếng Anh'],
        ];

        foreach ($gradeSubjectMappings as $gradeName => $subNames) {
            $gId = $gradeIds[$gradeName];
            foreach ($subNames as $subName) {
                $sId = $subjectIds[$subName];
                DB::table('grade_subject')->insert([
                    'grade_id' => $gId,
                    'subject_id' => $sId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        // 4. Seed Users
        $users = [
            [
                'name' => 'Hệ thống Quản trị',
                'gender' => 'male',
                'email' => 'admin@example.com',
                'phone' => '0987654321',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'date_of_birth' => '1990-01-01',
                'avatar' => null,
            ],
            [
                'name' => 'Nguyễn Văn Học',
                'gender' => 'male',
                'email' => 'student1@example.com',
                'phone' => '0912345678',
                'password' => Hash::make('password'),
                'role' => 'student',
                'date_of_birth' => '2008-05-15',
                'avatar' => null,
            ],
            [
                'name' => 'Trần Thị Học',
                'gender' => 'female',
                'email' => 'student2@example.com',
                'phone' => '0912345679',
                'password' => Hash::make('password'),
                'role' => 'student',
                'date_of_birth' => '2010-10-20',
                'avatar' => null,
            ],
            [
                'name' => 'Lê Gia Sư',
                'gender' => 'male',
                'email' => 'tutor1@example.com',
                'phone' => '0901234567',
                'password' => Hash::make('password'),
                'role' => 'tutor',
                'date_of_birth' => '1998-02-12',
                'avatar' => null,
            ],
            [
                'name' => 'Phạm Minh Tú',
                'gender' => 'male',
                'email' => 'tutor2@example.com',
                'phone' => '0907654321',
                'password' => Hash::make('password'),
                'role' => 'tutor',
                'date_of_birth' => '1995-07-22',
                'avatar' => null,
            ],
            [
                'name' => 'Hoàng Thanh Mai',
                'gender' => 'female',
                'email' => 'tutor3@example.com',
                'phone' => '0901122334',
                'password' => Hash::make('password'),
                'role' => 'tutor',
                'date_of_birth' => '2001-09-05',
                'avatar' => null,
            ],
            [
                'name' => 'Vũ Hữu Dũng',
                'gender' => 'male',
                'email' => 'user_both@example.com',
                'phone' => '0909988776',
                'password' => Hash::make('password'),
                'role' => 'both',
                'date_of_birth' => '1999-11-30',
                'avatar' => null,
            ],
        ];

        foreach ($users as $u) {
            DB::table('users')->insert(array_merge($u, ['created_at' => now(), 'updated_at' => now()]));
        }

        // Get inserted User IDs
        $userIds = DB::table('users')->pluck('id', 'email');

        // 5. Seed Students
        DB::table('students')->insert([
            ['user_id' => $userIds['student1@example.com'], 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => $userIds['student2@example.com'], 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => $userIds['user_both@example.com'], 'created_at' => now(), 'updated_at' => now()],
        ]);

        // 6. Seed Tutors
        $tutorsData = [
            [
                'user_id' => $userIds['tutor1@example.com'],
                'bio' => 'Tôi có hơn 5 năm kinh nghiệm dạy kèm Toán và Vật lý cấp 3, hỗ trợ nhiều học sinh đạt điểm cao trong kỳ thi THPT Quốc gia.',
                'education' => 'Cử nhân Sư phạm Toán - Đại học Sư phạm TP.HCM',
                'experience' => 5,
                'status' => 'approved',
            ],
            [
                'user_id' => $userIds['tutor2@example.com'],
                'bio' => 'Từng là cựu học sinh chuyên Hóa và có 7 năm đứng lớp gia sư các cấp từ THCS đến THPT.',
                'education' => 'Thạc sĩ Hóa học - Đại học Bách Khoa',
                'experience' => 7,
                'status' => 'approved',
            ],
            [
                'user_id' => $userIds['tutor3@example.com'],
                'bio' => 'Sinh viên năm cuối ngành Ngôn ngữ Anh. Nhiệt huyết, thân thiện, có phương pháp dạy tiếng Anh sinh động qua hình ảnh.',
                'education' => 'Sinh viên năm 4 - Đại học Ngoại ngữ',
                'experience' => 2,
                'status' => 'approved',
            ],
            [
                'user_id' => $userIds['user_both@example.com'],
                'bio' => 'Giảng dạy Tin học văn phòng và Lập trình cơ bản cho mọi lứa tuổi.',
                'education' => 'Cử nhân Công nghệ thông tin - Đại học Khoa học Tự nhiên',
                'experience' => 3,
                'status' => 'pending',
            ],
        ];

        foreach ($tutorsData as $t) {
            DB::table('tutors')->insert(array_merge($t, ['created_at' => now(), 'updated_at' => now()]));
        }

        // Get inserted Student & Tutor IDs
        $studentIds = DB::table('students')->pluck('id', 'user_id');
        $tutorIds = DB::table('tutors')->pluck('id', 'user_id');

        // 7. Seed Tutor_Subjects Mappings
        $tutorSubjects = [
            [
                'tutor_id' => $tutorIds[$userIds['tutor1@example.com']],
                'subject_id' => $subjectIds['Toán học'],
            ],
            [
                'tutor_id' => $tutorIds[$userIds['tutor1@example.com']],
                'subject_id' => $subjectIds['Vật lý'],
            ],
            [
                'tutor_id' => $tutorIds[$userIds['tutor2@example.com']],
                'subject_id' => $subjectIds['Hóa học'],
            ],
            [
                'tutor_id' => $tutorIds[$userIds['tutor2@example.com']],
                'subject_id' => $subjectIds['Sinh học'],
            ],
            [
                'tutor_id' => $tutorIds[$userIds['tutor3@example.com']],
                'subject_id' => $subjectIds['Tiếng Anh'],
            ],
            [
                'tutor_id' => $tutorIds[$userIds['user_both@example.com']],
                'subject_id' => $subjectIds['Tin học'],
            ],
        ];

        foreach ($tutorSubjects as $ts) {
            DB::table('tutor_subjects')->insert(array_merge($ts, ['created_at' => now(), 'updated_at' => now()]));
        }

        // 8. Seed Tutor Documents
        $tutorDocs = [
            [
                'tutor_id' => $tutorIds[$userIds['tutor1@example.com']],
                'file_path' => 'uploads/documents/tutor1_degree.pdf',
                'type' => 'Bằng tốt nghiệp Đại học',
            ],
            [
                'tutor_id' => $tutorIds[$userIds['tutor3@example.com']],
                'file_path' => 'uploads/documents/tutor3_ielts.pdf',
                'type' => 'Chứng chỉ IELTS 8.0',
            ],
        ];
        foreach ($tutorDocs as $td) {
            DB::table('tutor_documents')->insert(array_merge($td, ['created_at' => now(), 'updated_at' => now()]));
        }

        // 9. Seed Class Requests
        $classRequests = [
            [
                'student_id' => $studentIds[$userIds['student1@example.com']],
                'tutor_id' => null,
                'subject_id' => $subjectIds['Toán học'],
                'grade_id' => $gradeIds['Trung học phổ thông'],
                'degree' => 'Giáo viên',
                'experience' => 'Trên 3 năm',
                'gender' => 'no_need',
                'age_range' => 'Không yêu cầu',
                'fee' => 250000.00,
                'description' => 'Cần tìm giáo viên dạy kèm Toán lớp 11 để ôn tập kiến thức chuẩn bị thi học kỳ.',
                'study_type' => 'offline',
                'location' => 'Quận 1, TP. Hồ Chí Minh',
                'weeks' => '10 tuần',
                'schedule' => 'Thứ 3, Thứ 5',
                'time' => '18:30 - 20:30',
                'status' => 'approved',
            ],
            [
                'student_id' => $studentIds[$userIds['student2@example.com']],
                'tutor_id' => $tutorIds[$userIds['tutor3@example.com']],
                'subject_id' => $subjectIds['Tiếng Anh'],
                'grade_id' => $gradeIds['Ngoại ngữ'],
                'degree' => 'Sinh viên',
                'experience' => '1 năm',
                'gender' => 'female',
                'age_range' => '18-25',
                'fee' => 150000.00,
                'description' => 'Cần tìm gia sư nữ dạy giao tiếp tiếng Anh cơ bản.',
                'study_type' => 'online',
                'location' => null,
                'weeks' => '12 tuần',
                'schedule' => 'Thứ 7, Chủ Nhật',
                'time' => '09:00 - 11:00',
                'status' => 'assigned',
            ],
            [
                'student_id' => $studentIds[$userIds['student1@example.com']],
                'tutor_id' => null,
                'subject_id' => $subjectIds['Vật lý'],
                'grade_id' => $gradeIds['Luyện thi Đại học'],
                'degree' => 'Giáo viên hoặc Sinh viên giỏi',
                'experience' => '2 năm',
                'gender' => 'male',
                'age_range' => 'Không yêu cầu',
                'fee' => 300000.00,
                'description' => 'Luyện thi THPT Quốc gia môn Vật lý cấp tốc.',
                'study_type' => 'offline',
                'location' => 'Quận Cầu Giấy, Hà Nội',
                'weeks' => '16 tuần',
                'schedule' => 'Thứ 2, Thứ 4, Thứ 6',
                'time' => '19:00 - 21:00',
                'status' => 'pending',
            ],
        ];

        foreach ($classRequests as $cr) {
            DB::table('class_requests')->insert(array_merge($cr, ['created_at' => now(), 'updated_at' => now()]));
        }

        // Get inserted Class Requests
        $classRequestIds = DB::table('class_requests')->pluck('id', 'description');

        // 10. Seed Applications
        $applications = [
            [
                'tutor_id' => $tutorIds[$userIds['tutor1@example.com']],
                'class_request_id' => $classRequestIds['Cần tìm giáo viên dạy kèm Toán lớp 11 để ôn tập kiến thức chuẩn bị thi học kỳ.'],
                'message' => 'Chào bạn, tôi rất hứng thú với lớp học này và tin rằng kinh nghiệm sư phạm Toán của mình sẽ hỗ trợ tốt cho học sinh.',
                'status' => 'pending',
            ],
            [
                'tutor_id' => $tutorIds[$userIds['tutor3@example.com']],
                'class_request_id' => $classRequestIds['Cần tìm gia sư nữ dạy giao tiếp tiếng Anh cơ bản.'],
                'message' => 'Em đã dạy giao tiếp cho nhiều bạn học sinh mất gốc và tự tin giúp bạn tiến bộ nhanh chóng.',
                'status' => 'accepted',
            ],
        ];

        foreach ($applications as $app) {
            DB::table('applications')->insert(array_merge($app, ['created_at' => now(), 'updated_at' => now()]));
        }

        // 11. Seed Payments
        $payments = [
            [
                'tutor_id' => $tutorIds[$userIds['tutor3@example.com']],
                'class_request_id' => $classRequestIds['Cần tìm gia sư nữ dạy giao tiếp tiếng Anh cơ bản.'],
                'amount' => 1800000.00, // 150k * 12 tuần * 2 buổi = 3.6m? Ví dụ đặt cọc hoặc trả trước một phần
                'payment_type' => 'receive_class',
                'status' => 'completed',
                'payment_method' => 'Chuyển khoản Ngân hàng',
            ]
        ];

        foreach ($payments as $pay) {
            DB::table('payments')->insert(array_merge($pay, ['created_at' => now(), 'updated_at' => now()]));
        }

        // 12. Seed Reviews
        $reviews = [
            [
                'student_id' => $studentIds[$userIds['student2@example.com']],
                'tutor_id' => $tutorIds[$userIds['tutor3@example.com']],
                'rating' => 5,
                'comment' => 'Gia sư dạy rất nhiệt tình, bài giảng dễ hiểu và phát âm chuẩn.',
            ]
        ];

        foreach ($reviews as $rev) {
            DB::table('reviews')->insert(array_merge($rev, ['created_at' => now(), 'updated_at' => now()]));
        }

        // 13. Seed Contacts
        $contacts = [
            [
                'name' => 'Khách hàng Quan tâm',
                'email' => 'guest_contact1@example.com',
                'phone' => '0933344455',
                'message' => 'Tôi muốn hỏi phí dịch vụ đăng tin tìm gia sư có mất phí không ạ?',
                'admin_reply' => 'Chào bạn, việc đăng tin tìm gia sư hoàn toàn miễn phí đối với phụ huynh và học sinh.',
                'status' => 'replied',
            ],
            [
                'name' => 'Lê Quang Huy',
                'email' => 'guest_contact2@example.com',
                'phone' => '0944455566',
                'message' => 'Làm sao để tôi cập nhật lại bằng cấp giảng dạy của mình?',
                'admin_reply' => null,
                'status' => 'pending',
            ]
        ];

        foreach ($contacts as $con) {
            DB::table('contacts')->insert(array_merge($con, ['created_at' => now(), 'updated_at' => now()]));
        }
    }
}
