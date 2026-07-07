# ĐÁNH GIÁ HỆ THỐNG TUTOR-WEB THEO CHUẨN TÀI LIỆU PHÂN TÍCH & THIẾT KẾ HỆ THỐNG

> Tài liệu này rà soát hiện trạng project **Tutor-Web (Laravel 12)** và đối chiếu với **bố cục chuẩn của một báo cáo Phân tích – Thiết kế hệ thống (PTTKHT)**, từ đó chỉ ra:
> - **Phần đã có** (có thể đưa thẳng vào báo cáo).
> - **Phần cần BỔ SUNG** (tài liệu/sơ đồ còn thiếu).
> - **Phần cần FIX** (lỗi kỹ thuật/thiết kế phải sửa trước khi viết báo cáo).
>
> *Phạm vi đánh giá dựa trên mã nguồn thực tế và file dump `dothanhthuong_ltw2.sql`.*

---

## A. BỐ CỤC CHUẨN CỦA BÁO CÁO PTTKHT & MỨC ĐỘ ĐÁP ỨNG

| # | Chương / Mục của báo cáo PTTKHT | Hiện trạng project | Mức độ |
|---|---|---|---|
| 1 | **Tổng quan đề tài** (lý do, mục tiêu, phạm vi, đối tượng sử dụng) | Suy ra được từ code, **chưa có tài liệu** | ⚠️ Thiếu văn bản |
| 2 | **Khảo sát hiện trạng** (bài toán nghiệp vụ, quy trình thực tế) | Chưa có | ❌ Thiếu |
| 3 | **Yêu cầu chức năng** (danh sách chức năng theo tác nhân) | Đã hiện thực bằng code, **chưa liệt kê thành bảng** | ⚠️ Cần viết lại |
| 4 | **Yêu cầu phi chức năng** (bảo mật, hiệu năng, khả dụng…) | Chưa có | ❌ Thiếu |
| 5 | **Sơ đồ Use Case** (tổng quát + đặc tả từng use case) | Chưa có | ❌ Thiếu |
| 6 | **Sơ đồ phân rã chức năng (BFD)** | Chưa có | ❌ Thiếu |
| 7 | **Sơ đồ luồng dữ liệu (DFD) / Activity / BPMN** | Chưa có | ❌ Thiếu |
| 8 | **Mô hình dữ liệu mức quan niệm (ERD)** | **Suy ra đầy đủ từ DB** (xem mục C) | ✅ Có dữ liệu, cần vẽ |
| 9 | **Mô hình dữ liệu mức vật lý + Từ điển dữ liệu** | **Có schema đầy đủ** (xem mục D) | ✅ Có dữ liệu, cần trình bày |
| 10 | **Sơ đồ lớp (Class Diagram)** | Có Models Eloquent, **chưa vẽ** | ⚠️ Có dữ liệu, cần vẽ |
| 11 | **Sơ đồ tuần tự (Sequence)** cho luồng chính | Chưa có | ❌ Thiếu |
| 12 | **Thiết kế kiến trúc hệ thống** | MVC Laravel rõ ràng, **chưa mô tả** | ⚠️ Cần viết |
| 13 | **Thiết kế giao diện** (sơ đồ màn hình, mô tả) | 66 file Blade đã có, **chưa chụp/mô tả** | ⚠️ Cần chụp ảnh |
| 14 | **Cài đặt & Kiểm thử** (môi trường, test case) | Có `HUONG_DAN_SU_DUNG.md`; **không có test case** | ⚠️ Thiếu kiểm thử |
| 15 | **Kết luận & hướng phát triển** | Chưa có | ❌ Thiếu |

**Tổng kết:** Phần **thiết kế dữ liệu (8, 9)** gần như hoàn chỉnh và là điểm mạnh nhất để đưa vào báo cáo. Phần **phân tích (2–7)** và **thiết kế hành vi (10–13)** gần như phải làm mới hoàn toàn ở dạng tài liệu/sơ đồ.

---

## B. CẦN BỔ SUNG (Tài liệu & Sơ đồ còn thiếu)

### B1. Tác nhân (Actors) — đã xác định được từ code, cần đưa vào báo cáo
- **Khách (Guest)** – xem trang chủ, danh sách lớp, đăng ký, đăng nhập.
- **Học viên (Student)** – `role = student | both`.
- **Gia sư (Tutor)** – `role = tutor | both`.
- **Quản trị viên (Admin)** – `role = admin`, guard riêng `admin`.

### B2. Bảng yêu cầu chức năng (cần lập theo tác nhân)
Dựa trên `routes/web.php` và các Controller, đề xuất liệt kê tối thiểu:

| Tác nhân | Chức năng chính |
|---|---|
| Guest | Đăng ký HV/GS, đăng nhập, xem lớp công khai, trang giới thiệu |
| Student | Tạo lớp (5 bước), sửa/xóa lớp, duyệt đơn nhận lớp (accept/reject), xem hồ sơ gia sư, đánh giá gia sư, liên hệ, cập nhật hồ sơ |
| Tutor | Đăng ký hồ sơ + tải tài liệu, tìm & ứng tuyển nhận lớp, quản lý lớp được giao, thanh toán phí, cập nhật hồ sơ |
| Admin | Duyệt gia sư, quản lý đơn lớp (+ thùng rác/force delete), tạo môn/khối từ đơn, quản lý môn học, khối/ngành học, người dùng, học viên, đơn nhận lớp, trả lời liên hệ |

### B3. Các sơ đồ UML/cấu trúc cần vẽ bổ sung
1. **Use Case Diagram** tổng quát + **đặc tả** ≥ 5 use case quan trọng (Đăng ký gia sư, Tạo lớp học, Nhận lớp, Duyệt đơn, Thanh toán).
2. **Sơ đồ phân rã chức năng (BFD)** 3 nhánh: Student / Tutor / Admin.
3. **Activity / BPMN** cho **2 quy trình lõi**:
   - *Vòng đời đơn lớp*: `pending → approved → assigned → payment_pending → completed` (và nhánh `rejected/cancelled`).
   - *Vòng đời hồ sơ gia sư*: `draft → pending → approved/rejected`.
4. **ERD** (vẽ lại từ mục C) ở mức quan niệm.
5. **Class Diagram** từ 12 Model Eloquent.
6. **Sequence Diagram** cho luồng “Tạo lớp 5 bước” và “Gia sư nhận lớp → Học viên duyệt”.

### B4. Yêu cầu phi chức năng (cần viết)
Bảo mật (băm mật khẩu bcrypt – đã có; phân quyền middleware – đã có), hiệu năng, khả năng mở rộng, tính khả dụng, đa nền tảng trình duyệt, sao lưu dữ liệu, hỗ trợ tiếng Việt (UTF-8 – đã có).

### B5. Kịch bản kiểm thử (Test cases)
Hiện **chưa có test** (`tests/` chỉ có khung mặc định). Cần bổ sung bảng test case (mã TC, mô tả, dữ liệu vào, kết quả mong đợi, kết quả thực tế) cho các luồng chính.

---

## C. MÔ HÌNH DỮ LIỆU (ERD) — TRÍCH XUẤT TỪ DATABASE

### C1. Các thực thể (15 bảng nghiệp vụ, prefix `0206_`)

```
users (1) ──< students (1) ──< class_requests >── (n) tutors
   │            
   ├──< tutors ──< tutor_documents
   │       └──< tutor_subjects >── subjects
   │
class_requests ──< applications >── tutors
class_requests ──< payments     >── tutors
                  reviews: students >──< tutors
subjects >──< grades   (qua grade_subject)
class_requests ── subjects, grades (FK trực tiếp)
contacts (độc lập)
```

### C2. Quan hệ chính (theo FOREIGN KEY trong dump)

| Quan hệ | Kiểu | Ràng buộc |
|---|---|---|
| users → students | 1–1 | `students.user_id` ON DELETE CASCADE |
| users → tutors | 1–1 | `tutors.user_id` ON DELETE CASCADE |
| students → class_requests | 1–n | ON DELETE CASCADE |
| tutors → class_requests | 1–n | `tutor_id` ON DELETE SET NULL |
| subjects/grades → class_requests | 1–n | FK trực tiếp |
| tutors ↔ subjects | n–n | qua `tutor_subjects` |
| grades ↔ subjects | n–n | qua `grade_subject` |
| tutors → tutor_documents | 1–n | ON DELETE CASCADE |
| class_requests → applications | 1–n | ON DELETE CASCADE |
| class_requests → payments | 1–n | ON DELETE CASCADE |
| students/tutors → reviews | 1–n | ON DELETE CASCADE |

> **Lưu ý xây ERD:** thực thể trung tâm là **`class_requests`** (đơn lớp học) liên kết Student–Tutor–Subject–Grade và sinh ra Application/Payment/Review.

---

## D. TỪ ĐIỂN DỮ LIỆU RÚT GỌN (các trạng thái quan trọng)

| Bảng | Trường ENUM/quan trọng | Giá trị |
|---|---|---|
| `users` | `role` | student, tutor, admin, **both** |
| `users` | `gender` | male, female |
| `tutors` | `status` | draft, pending, approved, rejected |
| `class_requests` | `status` | pending, approved, rejected, assigned, payment_pending, completed, cancelled |
| `class_requests` | `study_type` | online, offline |
| `class_requests` | `gender` | male, female, no_need |
| `applications` | `status` | pending, accepted, rejected |
| `payments` | `payment_type` | receive_class, subscription, refund |
| `payments` | `status` | pending, completed, failed, refunded |
| `contacts` | `status` | pending, replied |

> Đây là dữ liệu **vàng** cho phần “Từ điển dữ liệu” và “Sơ đồ trạng thái (State Machine)” của báo cáo.

---

## E. CẦN FIX (Lỗi kỹ thuật / thiết kế phải sửa)

### E1. Lỗi chặn chạy / cấu hình (ưu tiên cao)
| # | Vấn đề | Bằng chứng | Cách sửa |
|---|---|---|---|
| 1 | **Thiếu bảng `sessions` & `jobs`** nhưng `.env.example` đặt driver `database` | Không có migration `create_sessions_table`/`create_jobs_table`; dump không có 2 bảng này | Đổi `SESSION_DRIVER=file`, `QUEUE_CONNECTION=sync`, **hoặc** tạo migration `session:table` + `queue:table` |
| 2 | **`DB_CONNECTION` mặc định là `sqlite`** trong khi dữ liệu chạy MySQL prefix `0206_` | `config/database.php` default = sqlite; `.env.example` `DB_CONNECTION=sqlite` | Đặt `.env.example` mặc định `mysql` + điền sẵn các biến `DB_*` |
| 3 | **Tiền tố bảng `0206_` hard-code** trong `config/database.php` | `'prefix' => '0206_'` cố định | Đưa ra biến môi trường `DB_PREFIX` để tái sử dụng/triển khai nơi khác |

### E2. Thiếu công cụ tái tạo dữ liệu (ảnh hưởng tính tái lập)
| # | Vấn đề | Cách sửa |
|---|---|---|
| 4 | `DatabaseSeeder` chỉ tạo 1 user test, **không seed dữ liệu nghiệp vụ** | Viết Seeder/Factory cho users, subjects, grades, tutors… để dựng DB không cần file dump |
| 5 | Phụ thuộc hoàn toàn vào file `.sql` thủ công | Bổ sung seeder để chạy `php artisan migrate --seed` ra dữ liệu mẫu |

### E3. Bảng nghiệp vụ trống → quy trình chưa khép kín
| # | Quan sát từ dump | Khuyến nghị |
|---|---|---|
| 6 | `payments` **0 dòng**, `reviews` **0 dòng** | Kiểm tra luồng Thanh toán & Đánh giá có hoạt động end-to-end; bổ sung dữ liệu mẫu minh họa trong báo cáo |
| 7 | Chỉ có **1 học viên** trong `students` | Thêm dữ liệu để minh họa quan hệ n–n và thống kê |

### E4. Chất lượng dự án / tài liệu
| # | Vấn đề | Cách sửa |
|---|---|---|
| 8 | **`README.md` vẫn là README mặc định của Laravel** | Thay bằng nội dung mô tả Tutor-Web (đã có `HUONG_DAN_SU_DUNG.md`, nên link/gộp vào) |
| 9 | **Không có Unit/Feature test** | Viết tối thiểu vài Feature test cho đăng nhập, tạo lớp, phân quyền |
| 10 | Hai guard `web` và `admin` **dùng chung provider `users`** | Hợp lý nhưng nên ghi chú trong báo cáo; cân nhắc kiểm tra `role=admin` ngay khi login admin |
| 11 | Chưa thấy chức năng **quên/đặt lại mật khẩu**, xác thực email | Nêu trong “Hướng phát triển” hoặc bổ sung nếu yêu cầu |

### E5. Rà soát thiết kế dữ liệu (nên ghi nhận trong báo cáo)
- `class_requests` vừa có FK `subject_id`/`grade_id` **vừa có** `subject_request`/`grade_request` (text) → cho phép yêu cầu môn/khối **chưa tồn tại** (admin tạo sau). Cần giải thích thiết kế này trong báo cáo (tránh bị hiểu là dư thừa).
- Nhiều trường lưu chuỗi tự do (`weeks`, `schedule`, `time`, `age_range`) thay vì kiểu chuẩn hóa → ghi chú hạn chế & hướng cải tiến (tách bảng lịch học).
- Đã dùng **Soft Delete** (`deleted_at`) ở hầu hết bảng nghiệp vụ → nêu rõ trong từ điển dữ liệu.

---

## F. ĐỀ XUẤT BỐ CỤC BÁO CÁO HOÀN CHỈNH (CHECKLIST)

```text
Chương 1. TỔNG QUAN
  [ ] 1.1 Lý do chọn đề tài, mục tiêu, phạm vi
  [ ] 1.2 Đối tượng sử dụng & môi trường triển khai
Chương 2. KHẢO SÁT & PHÂN TÍCH YÊU CẦU
  [ ] 2.1 Khảo sát hiện trạng / bài toán
  [ ] 2.2 Yêu cầu chức năng (bảng theo tác nhân)   ← B2
  [ ] 2.3 Yêu cầu phi chức năng                     ← B4
  [ ] 2.4 Sơ đồ Use Case + đặc tả                   ← B3.1
  [ ] 2.5 Sơ đồ phân rã chức năng (BFD)             ← B3.2
Chương 3. PHÂN TÍCH HỆ THỐNG
  [ ] 3.1 Activity/BPMN quy trình lõi               ← B3.3
  [ ] 3.2 Sequence các luồng chính                  ← B3.6
  [ ] 3.3 Sơ đồ trạng thái (state) đơn lớp & gia sư ← mục D
Chương 4. THIẾT KẾ HỆ THỐNG
  [ ] 4.1 Kiến trúc MVC Laravel                     ← A.12
  [ ] 4.2 ERD mức quan niệm                         ← mục C  ✅ sẵn dữ liệu
  [ ] 4.3 Mô hình vật lý + Từ điển dữ liệu          ← mục C,D ✅ sẵn dữ liệu
  [ ] 4.4 Class Diagram (12 Model)                  ← B3.5
  [ ] 4.5 Thiết kế giao diện (ảnh 66 màn hình Blade)
Chương 5. CÀI ĐẶT & KIỂM THỬ
  [ ] 5.1 Môi trường & hướng dẫn cài đặt            ← HUONG_DAN_SU_DUNG.md ✅
  [ ] 5.2 Bảng test case                            ← B5
Chương 6. KẾT LUẬN & HƯỚNG PHÁT TRIỂN
  [ ] 6.1 Kết quả đạt được / hạn chế (mục E)
  [ ] 6.2 Hướng phát triển (E4#11)
```

---

## G. KẾT LUẬN ĐÁNH GIÁ

- **Điểm mạnh:** Hệ thống đã chạy được, kiến trúc MVC chuẩn Laravel 12, **mô hình dữ liệu thiết kế tốt** (khóa ngoại, ràng buộc, soft delete, n–n đầy đủ) → phần Thiết kế CSDL của báo cáo gần như hoàn chỉnh.
- **Cần bổ sung gấp (tài liệu):** toàn bộ sơ đồ phân tích (Use Case, BFD, Activity, Sequence, State) và bảng yêu cầu chức năng/phi chức năng — đây là phần trừ điểm nhiều nhất nếu thiếu.
- **Cần fix gấp (kỹ thuật):** cấu hình `session/queue/DB driver` (E1), seeder dữ liệu (E2), và làm rõ các điểm thiết kế dữ liệu tự do (E5) trước khi viết phần đánh giá.

> Sau khi xử lý các mục ở phần **E** và bổ sung các sơ đồ ở phần **B**, project đủ điều kiện để hoàn thiện một **Báo cáo Phân tích – Thiết kế hệ thống** đầy đủ.

---

*Người đánh giá: (tự điền) — Ngày: 16/06/2026*
