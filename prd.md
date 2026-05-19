# Product Requirements Document
# Booku — Digital Library Management System

**Versi:** 1.0.0  
**Tanggal:** Mei 2026  
**Status:** Draft  
**Tim:** Solo Developer  
**Konteks:** Tugas Kuliah / Skripsi  
**Target Deploy:** 1–2 Minggu  

---

## 1. Ringkasan Produk

Booku adalah sistem manajemen perpustakaan digital berbasis web yang dirancang untuk perpustakaan sekolah dan kampus. Booku menggantikan sistem manual pencatatan peminjaman dengan antarmuka modern yang memungkinkan admin mengelola koleksi buku, memantau aktivitas peminjaman, dan menganalisis statistik — sementara anggota dapat menelusuri katalog, meminjam buku, melacak status peminjaman, dan memberikan ulasan.

**Stack Teknologi:**
- Backend: Laravel 11 (PHP)
- Frontend Build: Vite
- CSS Framework: Tailwind CSS v3
- Database: MySQL
- Auth: Laravel Breeze
- Chart: Chart.js
- QR Code: `simplesoftwareio/simple-qrcode`
- Icons: Heroicons / Tabler Icons

---

## 2. Tujuan Produk

| Tujuan | Indikator Keberhasilan |
|---|---|
| Mendigitalisasi proses peminjaman buku | Seluruh alur pinjam-kembali berjalan tanpa kertas |
| Memberi visibilitas kepada admin | Dashboard dengan statistik real-time |
| Meningkatkan pengalaman anggota | Anggota bisa menelusuri & meminjam mandiri |
| Nilai presentasi tinggi | QR code, dark mode, grafik, tracking status |

---

## 3. Pengguna & Role

### 3.1 Admin
Pengelola perpustakaan. Memiliki akses penuh ke seluruh sistem.

**Kemampuan:**
- Kelola data buku (CRUD)
- Kelola data anggota (CRUD)
- Approve / reject permintaan peminjaman
- Verifikasi pengembalian buku
- Lihat dan kelola denda
- Akses dashboard statistik dan laporan
- Generate QR code buku

### 3.2 Anggota (Member)
Pengguna terdaftar perpustakaan.

**Kemampuan:**
- Telusuri dan cari katalog buku
- Ajukan permintaan peminjaman
- Lihat status pinjaman (tracking)
- Ajukan pengembalian buku
- Simpan wishlist buku
- Beri rating & review buku
- Lihat riwayat peminjaman

### 3.3 Guest (Tidak Login)
Hanya bisa mengakses halaman publik: landing page, katalog (read-only), tentang perpustakaan.

---

## 4. Fitur & Prioritas (MoSCoW)

### Must Have
- [x] Autentikasi (login, logout, register, remember me, reset password via email)
- [x] Role-based access control (Admin / Anggota)
- [x] CRUD Buku (termasuk cover, ISBN, stok, kategori)
- [x] CRUD Anggota
- [x] Sistem peminjaman (request → approve/reject → borrowed → returned)
- [x] Sistem pengembalian (ajukan → verifikasi admin → stok update otomatis)
- [x] Dashboard Admin (statistik, grafik bulanan, aktivitas terbaru)
- [x] Riwayat peminjaman (per anggota & global admin)

### Should Have
- [x] Sistem denda otomatis (Rp1.000/hari keterlambatan)
- [x] Notifikasi overdue (dashboard badge + email H-2)
- [x] Review & rating buku
- [x] Wishlist / favorit buku
- [x] QR code per buku
- [x] Dark mode
- [x] Realtime search katalog

### Could Have
- [ ] Rekomendasi buku berbasis kategori / histori
- [ ] Export laporan PDF
- [ ] Upload foto kondisi buku saat pengembalian

### Won't Have (v1.0)
- [ ] Payment gateway denda
- [ ] Aplikasi mobile native
- [ ] Integrasi perpustakaan nasional

---

## 5. Alur Utama (User Flow)

### 5.1 Alur Peminjaman Buku
```
Anggota → Buka Katalog → Pilih Buku → Klik "Pinjam" 
  → Status: PENDING
  → Admin menerima notifikasi
  → Admin Approve → Status: APPROVED → BORROWED
  → Admin Reject → Status: REJECTED (stok tidak berubah)
  → Jatuh tempo H-2 → notifikasi email + badge overdue
  → Anggota klik "Kembalikan" → Status: RETURN_REQUESTED
  → Admin verifikasi → Status: RETURNED → stok +1
```

### 5.2 Status Peminjaman (State Machine)

```
PENDING → APPROVED → BORROWED → RETURN_REQUESTED → RETURNED
       ↘ REJECTED
BORROWED → OVERDUE (otomatis jika melewati due_date)
```

---

## 6. Halaman-Halaman Aplikasi

### 6.1 Halaman Publik (Guest)

| Halaman | URL | Deskripsi |
|---|---|---|
| Landing Page | `/` | Hero section, statistik perpustakaan, buku populer, fitur unggulan, CTA login/register |
| Katalog Publik | `/books` | Grid buku, search & filter (read-only) |
| Detail Buku | `/books/{slug}` | Info lengkap buku, rating, review (read-only) |
| Login | `/login` | Form login + remember me |
| Register | `/register` | Form daftar anggota |
| Lupa Password | `/forgot-password` | Form kirim email reset |
| Reset Password | `/reset-password/{token}` | Form password baru |

### 6.2 Halaman Anggota (Auth: role=member)

| Halaman | URL | Deskripsi |
|---|---|---|
| Dashboard Anggota | `/member/dashboard` | Ringkasan pinjaman aktif, buku overdue, notifikasi |
| Katalog Buku | `/member/books` | Grid buku dengan tombol "Pinjam", search realtime, filter |
| Detail Buku | `/member/books/{slug}` | Detail buku + form rating/review + tombol wishlist |
| Peminjaman Aktif | `/member/borrowings` | Daftar buku sedang dipinjam, status tracker |
| Riwayat Peminjaman | `/member/history` | Seluruh histori pinjam-kembali |
| Wishlist | `/member/wishlist` | Daftar buku favorit |
| Profil | `/member/profile` | Edit profil, ganti password |

### 6.3 Halaman Admin (Auth: role=admin)

| Halaman | URL | Deskripsi |
|---|---|---|
| Dashboard Admin | `/admin/dashboard` | Statistik card + grafik bulanan + aktivitas terbaru |
| Kelola Buku | `/admin/books` | DataTable buku + CRUD |
| Tambah/Edit Buku | `/admin/books/create`, `/admin/books/{id}/edit` | Form lengkap buku |
| Kelola Anggota | `/admin/members` | DataTable anggota + CRUD |
| Permintaan Peminjaman | `/admin/borrowings/requests` | List PENDING, aksi approve/reject |
| Kelola Peminjaman | `/admin/borrowings` | Semua transaksi, filter status |
| Pengembalian | `/admin/returns` | List RETURN_REQUESTED, verifikasi |
| Kelola Denda | `/admin/fines` | List denda aktif, tandai lunas |
| Statistik | `/admin/statistics` | Grafik lengkap: buku populer, anggota aktif, kategori |
| QR Code | `/admin/books/{id}/qr` | Preview + print QR code buku |

---

## 7. Database Schema (Laravel Migration Style)

### 7.1 `users`
```php
Schema::create('users', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('email')->unique();
    $table->string('phone')->nullable();
    $table->string('student_id')->nullable()->comment('NIM/NIP');
    $table->string('address')->nullable();
    $table->string('avatar')->nullable();
    $table->enum('role', ['admin', 'member'])->default('member');
    $table->enum('status', ['active', 'suspended'])->default('active');
    $table->timestamp('email_verified_at')->nullable();
    $table->string('password');
    $table->rememberToken();
    $table->timestamps();
});
```

### 7.2 `categories`
```php
Schema::create('categories', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('slug')->unique();
    $table->string('color', 7)->default('#3B82F6')->comment('Hex color untuk badge');
    $table->timestamps();
});
```

### 7.3 `books`
```php
Schema::create('books', function (Blueprint $table) {
    $table->id();
    $table->foreignId('category_id')->constrained()->onDelete('restrict');
    $table->string('title');
    $table->string('slug')->unique();
    $table->string('author');
    $table->string('publisher')->nullable();
    $table->string('isbn', 20)->unique()->nullable();
    $table->year('published_year')->nullable();
    $table->text('synopsis')->nullable();
    $table->string('cover_image')->nullable();
    $table->integer('total_stock')->default(1);
    $table->integer('available_stock')->default(1);
    $table->integer('borrow_count')->default(0)->comment('Total kali dipinjam, untuk popularitas');
    $table->string('qr_code_path')->nullable();
    $table->timestamps();
    $table->softDeletes();
});
```

### 7.4 `borrowings`
```php
Schema::create('borrowings', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->foreignId('book_id')->constrained()->onDelete('cascade');
    $table->date('borrowed_date')->nullable()->comment('Tanggal disetujui/dipinjam');
    $table->date('due_date')->nullable()->comment('Tanggal jatuh tempo, set saat approve');
    $table->date('returned_date')->nullable();
    $table->enum('status', [
        'pending',
        'approved',
        'borrowed',
        'overdue',
        'return_requested',
        'returned',
        'rejected'
    ])->default('pending');
    $table->text('admin_note')->nullable();
    $table->integer('duration_days')->default(7)->comment('Durasi pinjam dalam hari');
    $table->timestamps();
});
```

### 7.5 `fines`
```php
Schema::create('fines', function (Blueprint $table) {
    $table->id();
    $table->foreignId('borrowing_id')->constrained()->onDelete('cascade');
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->integer('overdue_days');
    $table->integer('amount_per_day')->default(1000);
    $table->integer('total_amount');
    $table->enum('status', ['unpaid', 'paid'])->default('unpaid');
    $table->timestamp('paid_at')->nullable();
    $table->text('note')->nullable();
    $table->timestamps();
});
```

### 7.6 `reviews`
```php
Schema::create('reviews', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->foreignId('book_id')->constrained()->onDelete('cascade');
    $table->tinyInteger('rating')->comment('1-5');
    $table->text('comment')->nullable();
    $table->unique(['user_id', 'book_id'])->comment('1 review per user per buku');
    $table->timestamps();
});
```

### 7.7 `wishlists`
```php
Schema::create('wishlists', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->foreignId('book_id')->constrained()->onDelete('cascade');
    $table->unique(['user_id', 'book_id']);
    $table->timestamps();
});
```

### 7.8 `notifications`
```php
Schema::create('notifications', function (Blueprint $table) {
    $table->uuid('id')->primary();
    $table->string('type');
    $table->morphs('notifiable');
    $table->text('data');
    $table->timestamp('read_at')->nullable();
    $table->timestamps();
    // Gunakan Laravel built-in notification table
    // php artisan notifications:table
});
```

### ERD Relasi Ringkas
```
users           →  borrowings    (1:N)
users           →  reviews       (1:N)
users           →  wishlists     (1:N)
users           →  fines         (1:N)
books           →  borrowings    (1:N)
books           →  reviews       (1:N)
books           →  wishlists     (1:N)
categories      →  books         (1:N)
borrowings      →  fines         (1:1)
```

---

## 8. Komponen UI & Desain

### 8.1 Design System
- **Warna Primer:** Navy / Dark Blue (`#1E3A5F` light, `#0F172A` dark)
- **Aksen:** Amber/Orange (`#F59E0B`) untuk CTA & highlight
- **Success:** Emerald (`#10B981`)
- **Danger:** Rose (`#F43F5E`)
- **Font:** Heading — `Sora` / `Plus Jakarta Sans`, Body — `Inter`
- **Dark Mode:** Class-based (`dark:`) via Tailwind, toggle tersimpan di `localStorage`

### 8.2 Layout Global
```
┌──────────────────────────────────────────────┐
│  Sidebar (240px fixed)  │  Main Content Area  │
│  ─ Logo Booku           │  ─ Topbar           │
│  ─ Nav Links            │  ─ Page Content     │
│  ─ User info (bottom)   │                     │
└──────────────────────────────────────────────┘
```

### 8.3 Status Badge Warna

| Status | Warna |
|---|---|
| Pending | Amber / Kuning |
| Approved | Blue |
| Borrowed | Indigo |
| Overdue | Rose / Merah |
| Return Requested | Orange |
| Returned | Emerald / Hijau |
| Rejected | Gray |

### 8.4 Halaman & Komponen Kunci

**Landing Page:**
- Hero: tagline + statistik angka perpustakaan + 2 CTA button
- Section: Buku populer (card grid horizontal)
- Section: Fitur unggulan (icon + deskripsi)
- Section: Cara kerja (3 langkah sederhana)
- Footer

**Katalog Buku:**
- Sidebar filter: kategori, status (tersedia/tidak), sort
- Grid card buku: cover, judul, penulis, rating bintang, badge status stok
- Search bar realtime (Alpine.js + Livewire atau debounce JS)

**Status Tracker Pinjaman (ala tracking paket):**
- Progress bar horizontal dengan 5 titik: Pending → Approved → Borrowed → Return Requested → Returned
- Titik aktif berwarna, titik lewat terisi, titik belum abu-abu

**Dashboard Admin:**
- 4 stat cards: Total Buku, Total Anggota, Sedang Dipinjam, Overdue
- Bar chart: peminjaman per bulan (Chart.js)
- Pie chart: distribusi kategori buku
- Tabel aktivitas terbaru (5 transaksi terakhir)
- List top 5 buku terpopuler

---

## 9. Logika Bisnis Penting

### 9.1 Perhitungan Denda
```
overdue_days = today - due_date  (jika > 0)
total_fine   = overdue_days × Rp1.000
```
Denda dibuat otomatis oleh scheduled command (`php artisan schedule:run`) setiap hari.

### 9.2 Update Status Overdue Otomatis
```php
// App\Console\Commands\UpdateOverdueStatus.php
// Jalankan setiap hari via schedule
Borrowing::where('status', 'borrowed')
    ->where('due_date', '<', now()->toDateString())
    ->update(['status' => 'overdue']);
```

### 9.3 Update Stok Buku
- Saat admin **approve** → `available_stock - 1`, `borrow_count + 1`
- Saat admin **verifikasi return** → `available_stock + 1`
- Saat admin **reject** → stok tidak berubah

### 9.4 QR Code
- Generate via `simplesoftwareio/simple-qrcode`
- QR berisi URL: `https://domain.com/books/{slug}`
- Disimpan di `storage/app/public/qrcodes/book-{id}.svg`
- Tampil di halaman admin `/admin/books/{id}/qr` + tombol print

### 9.5 Notifikasi Email (Laravel Notification)
Trigger email dikirim ke anggota:
| Event | Template |
|---|---|
| Peminjaman disetujui | `BorrowingApprovedNotification` |
| Peminjaman ditolak | `BorrowingRejectedNotification` |
| H-2 jatuh tempo | `DueSoonReminderNotification` (via scheduler) |
| Status overdue | `OverdueNotification` |

---

## 10. Struktur Folder Laravel (Ringkas)

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Admin/
│   │   │   ├── DashboardController.php
│   │   │   ├── BookController.php
│   │   │   ├── MemberController.php
│   │   │   ├── BorrowingController.php
│   │   │   ├── ReturnController.php
│   │   │   ├── FineController.php
│   │   │   └── StatisticsController.php
│   │   ├── Member/
│   │   │   ├── DashboardController.php
│   │   │   ├── CatalogController.php
│   │   │   ├── BorrowingController.php
│   │   │   ├── WishlistController.php
│   │   │   └── ProfileController.php
│   │   └── PublicController.php
│   └── Middleware/
│       ├── AdminMiddleware.php
│       └── MemberMiddleware.php
├── Models/
│   ├── User.php
│   ├── Book.php
│   ├── Category.php
│   ├── Borrowing.php
│   ├── Fine.php
│   ├── Review.php
│   └── Wishlist.php
├── Console/Commands/
│   ├── UpdateOverdueStatus.php
│   └── SendDueSoonReminders.php
└── Notifications/
    ├── BorrowingApprovedNotification.php
    ├── BorrowingRejectedNotification.php
    ├── DueSoonReminderNotification.php
    └── OverdueNotification.php

resources/views/
├── layouts/
│   ├── app.blade.php       (auth layout dengan sidebar)
│   └── guest.blade.php     (public layout)
├── public/
│   ├── landing.blade.php
│   ├── catalog.blade.php
│   └── book-detail.blade.php
├── admin/
│   ├── dashboard.blade.php
│   ├── books/
│   ├── members/
│   ├── borrowings/
│   ├── returns/
│   ├── fines/
│   └── statistics/
└── member/
    ├── dashboard.blade.php
    ├── catalog.blade.php
    ├── borrowings/
    ├── wishlist.blade.php
    └── profile.blade.php
```

---

## 11. Routes Utama

```php
// Public
Route::get('/', [PublicController::class, 'landing']);
Route::get('/books', [PublicController::class, 'catalog']);
Route::get('/books/{slug}', [PublicController::class, 'show']);

// Auth (Breeze)
Route::middleware('guest')->group(function () { ... });

// Admin
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [Admin\DashboardController::class, 'index']);
    Route::resource('/books', Admin\BookController::class);
    Route::get('/books/{book}/qr', [Admin\BookController::class, 'qrCode']);
    Route::resource('/members', Admin\MemberController::class);
    Route::get('/borrowings/requests', [Admin\BorrowingController::class, 'requests']);
    Route::patch('/borrowings/{borrowing}/approve', [Admin\BorrowingController::class, 'approve']);
    Route::patch('/borrowings/{borrowing}/reject', [Admin\BorrowingController::class, 'reject']);
    Route::resource('/borrowings', Admin\BorrowingController::class)->only(['index', 'show']);
    Route::get('/returns', [Admin\ReturnController::class, 'index']);
    Route::patch('/returns/{borrowing}/verify', [Admin\ReturnController::class, 'verify']);
    Route::resource('/fines', Admin\FineController::class)->only(['index', 'show']);
    Route::patch('/fines/{fine}/pay', [Admin\FineController::class, 'markPaid']);
    Route::get('/statistics', [Admin\StatisticsController::class, 'index']);
});

// Member
Route::prefix('member')->middleware(['auth', 'member'])->group(function () {
    Route::get('/dashboard', [Member\DashboardController::class, 'index']);
    Route::get('/books', [Member\CatalogController::class, 'index']);
    Route::get('/books/{slug}', [Member\CatalogController::class, 'show']);
    Route::post('/books/{book}/borrow', [Member\BorrowingController::class, 'store']);
    Route::patch('/borrowings/{borrowing}/return', [Member\BorrowingController::class, 'requestReturn']);
    Route::get('/borrowings', [Member\BorrowingController::class, 'index']);
    Route::get('/history', [Member\BorrowingController::class, 'history']);
    Route::post('/wishlist/{book}', [Member\WishlistController::class, 'toggle']);
    Route::get('/wishlist', [Member\WishlistController::class, 'index']);
    Route::post('/books/{book}/review', [Member\ReviewController::class, 'store']);
    Route::get('/profile', [Member\ProfileController::class, 'edit']);
    Route::patch('/profile', [Member\ProfileController::class, 'update']);
});
```

---

## 12. Seeder & Data Awal

```
DatabaseSeeder
├── CategorySeeder      (10 kategori: Fiksi, Non-fiksi, Sains, Teknologi, dll)
├── UserSeeder          (1 admin + 5 anggota sample)
├── BookSeeder          (20 buku sample dengan cover placeholder)
└── BorrowingSeeder     (10 data peminjaman dengan status bervariasi)
```

---

## 13. Perintah Artisan Penting

```bash
# Setup awal
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan storage:link

# Instalasi package QR
composer require simplesoftwareio/simple-qrcode

# Notifikasi table
php artisan notifications:table
php artisan migrate

# Scheduler (wajib aktif untuk fitur overdue & reminder)
php artisan schedule:work   # development
# Production: tambahkan cron job
# * * * * * cd /path && php artisan schedule:run >> /dev/null 2>&1

# Development
npm install && npm run dev
php artisan serve
```

---

## 14. Checklist Pengembangan

### Minggu 1 — Core
- [ ] Setup Laravel + Breeze + Tailwind + Vite
- [ ] Migration & seeder semua tabel
- [ ] Model + Relationship
- [ ] Middleware Admin & Member
- [ ] CRUD Buku (admin)
- [ ] CRUD Anggota (admin)
- [ ] Katalog publik & anggota
- [ ] Sistem peminjaman (request, approve, reject)
- [ ] Sistem pengembalian (request, verifikasi)
- [ ] Update stok otomatis

### Minggu 2 — Fitur Nilai Tambah
- [ ] Dashboard admin (stat cards + Chart.js)
- [ ] Sistem denda otomatis (scheduler)
- [ ] Notifikasi overdue (scheduler + email)
- [ ] Review & rating buku
- [ ] Wishlist anggota
- [ ] QR code buku
- [ ] Dark mode (Tailwind class-based)
- [ ] Status tracker peminjaman (UI tracking)
- [ ] Landing page publik
- [ ] Realtime search katalog (Alpine.js debounce)

---

*Dokumen ini dibuat sebagai panduan pengembangan Booku v1.0. Semua keputusan implementasi akhir disesuaikan dengan kondisi pengembangan aktual.*
