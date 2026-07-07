# HƯỚNG DẪN CÀI ĐẶT & CHẠY HỆ THỐNG TUTOR-WEB

> Hệ thống **Tìm gia sư / Đăng lớp học** xây dựng trên **Laravel 12 (PHP 8.2)**.
> Tài liệu này hướng dẫn cài đặt, cấu hình và chạy project trên môi trường **Windows + XAMPP**.

---

## 1. Giới thiệu nhanh

Tutor-Web là nền tảng kết nối **Học viên (Student)** và **Gia sư (Tutor)**, có **Quản trị viên (Admin)** điều phối:

- **Học viên**: tạo lớp học (quy trình 5 bước), duyệt đơn nhận lớp của gia sư, đánh giá gia sư, liên hệ.
- **Gia sư**: đăng ký hồ sơ + tài liệu, nhận lớp (ứng tuyển), quản lý lớp được giao, thanh toán phí.
- **Admin**: duyệt gia sư, duyệt/quản lý đơn đăng lớp, quản lý môn học – khối/ngành học – người dùng, trả lời liên hệ.

| Thành phần | Công nghệ |
|---|---|
| Framework | Laravel 12 |
| Ngôn ngữ | PHP ^8.2 |
| CSDL | MySQL / MariaDB (prefix bảng `0206_`) |
| Frontend build | Vite + npm |
| Thư viện | blade-ui-kit/blade-heroicons |
| Xác thực | Session, 2 guard: `web` và `admin` |

---

## 2. Yêu cầu môi trường

| Phần mềm | Phiên bản tối thiểu | Ghi chú |
|---|---|---|
| PHP | 8.2+ | Bật extension `pdo_mysql`, `mbstring`, `openssl`, `fileinfo`, `gd` |
| Composer | 2.x | Quản lý gói PHP |
| Node.js | 18+ (khuyến nghị 20) | Kèm npm 10+ |
| MySQL / MariaDB | 10.4+ | Có sẵn trong **XAMPP** |

> Máy đã cài **XAMPP** (PHP 8.2.12 + MariaDB) là đủ điều kiện chạy. Bật **Apache** (tùy chọn) và **MySQL** trong XAMPP Control Panel.

---

## 3. Các bước cài đặt

### Bước 1 — Lấy mã nguồn

Giải nén / clone project vào thư mục (ví dụ): `C:\Users\<user>\Downloads\Tutor-Web`.
Mở **PowerShell / CMD** tại thư mục gốc của project.

### Bước 2 — Cài đặt thư viện PHP

```powershell
composer install
```

### Bước 3 — Tạo file cấu hình `.env`

```powershell
copy .env.example .env
php artisan key:generate
```

### Bước 4 — Tạo database và import dữ liệu mẫu

1. Mở **phpMyAdmin** (`http://localhost/phpmyadmin`).
2. Tạo database mới, ví dụ tên: **`dothanhthuong_ltw2`** (charset `utf8mb4_unicode_ci`).
3. Chọn database → tab **Import** → chọn file `dothanhthuong_ltw2.sql` → **Go**.

> File `.sql` đã chứa sẵn **cấu trúc bảng + dữ liệu mẫu** (tên bảng đã có tiền tố `0206_` khớp với cấu hình project). Sau khi import xong **không cần** chạy `php artisan migrate`.

### Bước 5 — Cấu hình kết nối CSDL trong `.env`

Mở file `.env` và sửa các dòng sau (đây là bước **quan trọng nhất**, tham số mặc định trỏ tới SQLite nên phải đổi):

```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=dothanhthuong_ltw2
DB_USERNAME=root
DB_PASSWORD=

# Bắt buộc đổi 2 dòng dưới (xem mục Lỗi thường gặp #1)
SESSION_DRIVER=file
QUEUE_CONNECTION=sync
```

> ⚠️ Mặc định `.env.example` để `SESSION_DRIVER=database` và `QUEUE_CONNECTION=database`, **nhưng bộ dump không có bảng `sessions` và `jobs`** ⇒ sẽ lỗi ngay khi mở trang. Hãy đổi sang `file` / `sync` như trên (hoặc đọc mục [Lỗi thường gặp](#7-lỗi-thường-gặp--cách-khắc-phục)).

### Bước 6 — Cài đặt & build frontend

```powershell
npm install
npm run build
```

> Hoặc dùng chế độ phát triển (hot-reload, chạy song song với `php artisan serve`):
> ```powershell
> npm run dev
> ```

### Bước 7 — Tạo symbolic link cho thư mục storage

Ảnh đại diện và tài liệu gia sư được lưu trong `storage/app/public`. Cần link ra `public/storage`:

```powershell
php artisan storage:link
```

### Bước 8 — Xóa cache cấu hình & chạy server

```powershell
php artisan config:clear
php artisan serve
```

Mở trình duyệt: **http://127.0.0.1:8000**

---

## 4. Tài khoản đăng nhập mẫu

Dữ liệu mẫu trong file `.sql` có sẵn các tài khoản sau (mật khẩu đã được **mã hóa bcrypt**, không đọc được trực tiếp):

| Vai trò | Email | Trang đăng nhập |
|---|---|---|
| Admin | `ad@gmail.com` | `http://127.0.0.1:8000/admin/login` |
| Học viên (Student) | `hv1@gmail.com` | `http://127.0.0.1:8000/login` |
| Gia sư (Tutor) | `gs1@gmail.com` | `http://127.0.0.1:8000/login` |
| Gia sư (Tutor) | `gs2@gmail.com` | `http://127.0.0.1:8000/login` |

> **Không biết mật khẩu gốc?** Đặt lại nhanh bằng Tinker (ví dụ đổi tất cả về `123456`):
>
> ```powershell
> php artisan tinker
> ```
> ```php
> \App\Models\User::query()->update(['password' => bcrypt('123456')]);
> ```
> Sau đó đăng nhập bằng email ở trên với mật khẩu `123456`.

---

## 5. Sơ đồ luồng sử dụng (tóm tắt)

```
Khách → /role → Đăng ký (Student | Tutor) → Đăng nhập
   │
   ├── Student → /student → Tạo lớp (/create-class step1..4 → confirm → store)
   │                     → Xem đơn nhận lớp → Chấp nhận/Từ chối gia sư
   │                     → Đánh giá gia sư, Liên hệ
   │
   ├── Tutor   → /tutor → Cập nhật hồ sơ + tài liệu → Tìm & nhận lớp
   │                    → Quản lý lớp được giao → Thanh toán
   │
   └── Admin   → /admin → Duyệt gia sư, duyệt đơn lớp, quản lý môn/khối/người dùng,
                          trả lời liên hệ
```

---

## 6. Lệnh hữu ích

| Mục đích | Lệnh |
|---|---|
| Chạy server | `php artisan serve` |
| Build frontend | `npm run build` |
| Dev mode (server + vite + queue + log) | `composer run dev` |
| Xóa toàn bộ cache | `php artisan optimize:clear` |
| Xem danh sách route | `php artisan route:list` |
| Chạy migration (DB rỗng, không import dump) | `php artisan migrate` |
| Chạy test | `php artisan test` |

---

## 7. Lỗi thường gặp & cách khắc phục

**1) `SQLSTATE... Table '...0206_sessions' doesn't exist` hoặc lỗi liên quan `jobs`**
→ Bộ dump không có bảng `sessions`/`jobs`. Trong `.env` đặt:
```dotenv
SESSION_DRIVER=file
QUEUE_CONNECTION=sync
```
rồi chạy `php artisan config:clear`.
*(Cách khác: tạo bảng bằng `php artisan session:table` và `php artisan queue:table` rồi `php artisan migrate`.)*

**2) Trang trắng / lỗi `vite manifest not found`**
→ Chưa build frontend. Chạy `npm install` rồi `npm run build` (hoặc `npm run dev`).

**3) Ảnh đại diện / tài liệu gia sư không hiển thị (404)**
→ Chưa tạo storage link. Chạy `php artisan storage:link`.

**4) `could not find driver` khi kết nối DB**
→ Chưa bật extension `pdo_mysql`. Mở `php.ini` (của XAMPP), bỏ `;` ở dòng `extension=pdo_mysql`, khởi động lại.

**5) Kết nối nhầm SQLite / `database.sqlite not found`**
→ Quên đổi `DB_CONNECTION=mysql` trong `.env`. Sửa lại rồi `php artisan config:clear`.

**6) `Application key ... not set`**
→ Chạy `php artisan key:generate`.

**7) Đổi `.env` nhưng không có tác dụng**
→ Laravel cache config. Chạy `php artisan config:clear` (và `php artisan optimize:clear`).

---

## 8. Checklist cài đặt nhanh

```text
[ ] composer install
[ ] copy .env.example .env  &&  php artisan key:generate
[ ] Tạo DB + Import dothanhthuong_ltw2.sql qua phpMyAdmin
[ ] Sửa .env: DB_CONNECTION=mysql, DB_DATABASE, SESSION_DRIVER=file, QUEUE_CONNECTION=sync
[ ] npm install  &&  npm run build
[ ] php artisan storage:link
[ ] php artisan config:clear
[ ] php artisan serve  →  http://127.0.0.1:8000
[ ] (tuỳ chọn) Reset mật khẩu mẫu qua tinker
```

---

*Cập nhật: 16/06/2026*
