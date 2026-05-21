# 🎓 SiMawa — Sistem Informasi Mahasiswa

<div align="center">

![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.5-777BB4?style=for-the-badge&logo=php&logoColor=white)
![SQLite](https://img.shields.io/badge/SQLite-003B57?style=for-the-badge&logo=sqlite&logoColor=white)
![License](https://img.shields.io/badge/License-MIT-blue?style=for-the-badge)

Aplikasi manajemen data mahasiswa berbasis web dengan tampilan admin modern, dibangun menggunakan **Laravel 12** dan desain tema **Denim Blue**.

</div>

---

## ✨ Fitur Utama

| Fitur | Keterangan |
|---|---|
| 📊 **Dashboard** | Statistik mahasiswa, sebaran status, top program studi, data terbaru |
| 👥 **CRUD Mahasiswa** | Tambah, lihat, edit, hapus data mahasiswa lengkap |
| 🔍 **Filter & Pencarian** | Cari berdasarkan nama/NPM/email, filter prodi, status, angkatan |
| 🏛️ **Program Studi** | Kelola data program studi (D3/S1/S2/S3) |
| 📥 **Export CSV** | Unduh data mahasiswa ke format CSV (bisa dibuka di Excel) |
| 📄 **Export PDF** | Cetak laporan data mahasiswa ke PDF |
| 🪪 **Kartu Mahasiswa** | Cetak kartu identitas mahasiswa per orang |
| 🌙 **Dark Mode** | Toggle tema gelap/terang, tersimpan otomatis |
| 🗑️ **Modal Konfirmasi** | Dialog hapus data yang lebih aman dan elegan |
| 🔔 **Toast Notifikasi** | Notifikasi aksi muncul di pojok layar |
| 📱 **Status Mahasiswa** | Aktif / Cuti / Lulus / Dropout dengan badge warna |

---

## 🖥️ Screenshot

```
<img width="1847" height="826" alt="image" src="https://github.com/user-attachments/assets/124ecc20-a769-435d-a4ea-954c2958a1d2" />
```

---

## 🛠️ Teknologi

- **Framework** — Laravel 12
- **Bahasa** — PHP 8.5+
- **Database** — SQLite (default) / MySQL
- **PDF** — barryvdh/laravel-dompdf
- **Font** — Plus Jakarta Sans, JetBrains Mono (Google Fonts)
- **Icon** — Font Awesome 6
- **Tema** — Denim Blue custom CSS Variables + Dark Mode

---

## ⚙️ Persyaratan Sistem

- PHP **>= 8.2**
- Composer
- Node.js (opsional, jika pakai Vite)
- Extension PHP: `pdo_sqlite`, `mbstring`, `openssl`, `zip`, `gd` (untuk PDF)

---

## 🚀 Instalasi

### 1. Clone Repository

```bash
git clone https://github.com/username/simawa.git
cd simawa
```

### 2. Install Dependencies

```bash
composer install
```

### 3. Konfigurasi Environment

```bash
cp .env.example .env
php artisan key:generate
```

### 4. Setup Database

Secara default menggunakan **SQLite**. Pastikan file database ada:

```bash
touch database/database.sqlite
```

Jika ingin menggunakan **MySQL**, edit `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=simawa
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Migrasi & Seeder

```bash
# Jalankan migrasi
php artisan migrate

# Isi data program studi (16 prodi siap pakai)
php artisan db:seed --class=ProdiSeeder

# Isi data mahasiswa contoh (35 mahasiswa)
php artisan db:seed --class=MahasiswaSeeder
```

### 6. Install Extension untuk PDF

```bash
sudo apt install php8.5-gd
sudo phpenmod gd
```

### 7. Jalankan Aplikasi

```bash
php artisan serve
```

Buka browser: **http://127.0.0.1:8000**

---

## 📁 Struktur Proyek

```
simawa/
├── app/
│   ├── Http/Controllers/
│   │   ├── DashboardController.php
│   │   ├── MahasiswaController.php
│   │   └── ProdiController.php
│   └── Models/
│       ├── Mahasiswa.php
│       └── Prodi.php
├── database/
│   ├── migrations/
│   │   ├── ..._create_mahasiswas_table.php
│   │   ├── ..._create_prodis_table.php
│   │   └── ..._add_fields_to_mahasiswas_table.php
│   └── seeders/
│       ├── ProdiSeeder.php
│       └── MahasiswaSeeder.php
├── resources/views/
│   ├── layouts/
│   │   └── app.blade.php          # Layout utama + sidebar
│   ├── dashboard/
│   │   └── index.blade.php
│   ├── mahasiswa/
│   │   ├── index.blade.php        # Daftar + filter + export
│   │   ├── create.blade.php
│   │   ├── edit.blade.php
│   │   ├── show.blade.php
│   │   └── kartu.blade.php        # Cetak kartu
│   ├── prodi/
│   │   └── index.blade.php
│   ├── exports/
│   │   └── mahasiswa-pdf.blade.php
│   └── about/
│       └── index.blade.php
└── routes/
    └── web.php
```

---

## 🗄️ Struktur Database

### Tabel `prodis`

| Kolom | Tipe | Keterangan |
|---|---|---|
| id | bigint PK | Primary key |
| kode | varchar(10) | Kode unik prodi (misal: S1-TI) |
| nama | varchar(100) | Nama program studi |
| jenjang | enum | D3 / S1 / S2 / S3 |

### Tabel `mahasiswas`

| Kolom | Tipe | Keterangan |
|---|---|---|
| id | bigint PK | Primary key |
| prodi_id | bigint FK | Relasi ke tabel prodis |
| npm | varchar(20) | Nomor Pokok Mahasiswa (unik) |
| nama_lengkap | varchar(100) | Nama lengkap mahasiswa |
| email | varchar | Email (unik) |
| telepon | varchar(20) | Nomor telepon |
| alamat | text | Alamat lengkap |
| status | enum | aktif / cuti / lulus / dropout |
| angkatan | smallint | Tahun angkatan |

---

## 🔗 Daftar Route

| Method | URL | Nama | Keterangan |
|---|---|---|---|
| GET | `/dashboard` | dashboard | Halaman dashboard |
| GET | `/mahasiswa` | mahasiswa.index | Daftar mahasiswa |
| GET | `/mahasiswa/create` | mahasiswa.create | Form tambah |
| POST | `/mahasiswa` | mahasiswa.store | Simpan data |
| GET | `/mahasiswa/{id}` | mahasiswa.show | Detail mahasiswa |
| GET | `/mahasiswa/{id}/edit` | mahasiswa.edit | Form edit |
| PUT | `/mahasiswa/{id}` | mahasiswa.update | Perbarui data |
| DELETE | `/mahasiswa/{id}` | mahasiswa.destroy | Hapus data |
| GET | `/mahasiswa/export/excel` | mahasiswa.export.excel | Export CSV |
| GET | `/mahasiswa/export/pdf` | mahasiswa.export.pdf | Export PDF |
| GET | `/mahasiswa/{id}/kartu` | mahasiswa.kartu | Cetak kartu |
| GET | `/prodi` | prodi.index | Kelola prodi |
| POST | `/prodi` | prodi.store | Tambah prodi |
| PUT | `/prodi/{id}` | prodi.update | Edit prodi |
| DELETE | `/prodi/{id}` | prodi.destroy | Hapus prodi |
| GET | `/about` | about | Halaman about |

---

## 📦 Package yang Digunakan

```json
{
    "require": {
        "php": "^8.2",
        "laravel/framework": "^12.0",
        "barryvdh/laravel-dompdf": "^3.0"
    }
}
```

---

## 🤝 Kontribusi

Pull request sangat disambut! Untuk perubahan besar, harap buka issue terlebih dahulu untuk mendiskusikan apa yang ingin diubah.

1. Fork repository ini
2. Buat branch fitur (`git checkout -b fitur/nama-fitur`)
3. Commit perubahan (`git commit -m 'Tambah fitur X'`)
4. Push ke branch (`git push origin fitur/nama-fitur`)
5. Buka Pull Request
