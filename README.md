<p align="center">
  <img src="https://img.shields.io/badge/Laravel-11-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel 11"/>
  <img src="https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP 8.2+"/>
  <img src="https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL"/>
  <img src="https://img.shields.io/badge/Leaflet.js-199900?style=for-the-badge&logo=leaflet&logoColor=white" alt="Leaflet.js"/>
  <img src="https://img.shields.io/badge/TailwindCSS-3-06B6D4?style=for-the-badge&logo=tailwindcss&logoColor=white" alt="TailwindCSS"/>
  <img src="https://img.shields.io/badge/License-MIT-green?style=for-the-badge" alt="MIT License"/>
</p>

# 🏛️ Sistem Informasi Pengaduan Masyarakat Berbasis Web

**Sistem Informasi Pengaduan Masyarakat dengan Integrasi Geographic Information System (GIS) untuk Peningkatan Layanan Publik di Bidang Infrastruktur di Kelurahan Meranti Pandak, Kecamatan Rumbai, Kota Pekanbaru.**

> 📝 Proyek Skripsi — Program Studi Teknik Informatika, Fakultas Ilmu Komputer, Universitas Lancang Kuning Pekanbaru (2026)

---

## 📋 Deskripsi

Sistem informasi berbasis web yang dirancang untuk memfasilitasi pelaporan kerusakan infrastruktur oleh warga secara daring (*online*) dengan integrasi peta interaktif GIS. Sistem ini memungkinkan masyarakat melaporkan permasalahan infrastruktur (jalan rusak, drainase tersumbat, PJU mati, dsb.) lengkap dengan koordinat lokasi yang presisi, serta membantu aparatur Kelurahan Meranti Pandak dalam mengelola, memverifikasi, dan melacak tindak lanjut pengaduan secara terstruktur dan transparan.

### 🎯 Permasalahan yang Diselesaikan

| Sebelum (Manual) | Sesudah (Sistem Web + GIS) |
| :--- | :--- |
| Pengaduan disampaikan lisan via RT/RW | Pelaporan daring 24/7 dengan foto bukti |
| Tidak ada pencatatan digital terpusat | Database MySQL terpusat & terstruktur |
| Lokasi kerusakan sulit dilacak | Titik koordinat GIS presisi (Leaflet.js) |
| Status tindak lanjut tidak transparan | Pelacakan status realtime (*Diajukan → Diproses → Selesai*) |
| Arsip fisik rawan hilang | Ekspor laporan PDF bulanan untuk Musrenbang |

---

## ✨ Fitur Utama

### 👥 Sisi Masyarakat (Pelapor)
- **🔐 Autentikasi Ganda** — Login konvensional (email/password) & Google OAuth Sign-In
- **📝 Formulir Pengaduan Interaktif** — Unggah foto bukti, pilih kategori infrastruktur, dan tentukan lokasi di peta
- **🗺️ Geotagging GIS Leaflet.js** — Penentuan titik koordinat (*latitude/longitude*) dengan drag-and-click marker pada peta interaktif
- **🚧 Boundary Check Otomatis** — Validasi bahwa lokasi yang dipilih berada di dalam batas administratif Kelurahan Meranti Pandak
- **📊 Pelacakan Status Realtime** — Pantau perkembangan laporan (*Diajukan → Diproses → Selesai*)
- **✏️ Edit/Hapus Pengaduan** — Modifikasi laporan selama status masih *Diajukan*

### 🛡️ Sisi Admin Kelurahan
- **📈 Dashboard Statistik** — Ringkasan total pengaduan, distribusi status, dan persentase penyelesaian
- **🗺️ Peta Sebaran GIS** — Visualisasi seluruh titik pengaduan warga pada peta admin dengan marker berwarna berdasarkan status
- **🔄 Verifikasi & Update Status** — Ubah status penanganan laporan secara berkala
- **📁 Manajemen Kategori** — Kelola data master jenis infrastruktur (CRUD)
- **📄 Ekspor Laporan PDF** — Cetak rekapitulasi bulanan berformat PDF resmi ber-kop surat kelurahan (filter periode bulan & tahun)

---

## 🛠️ Tech Stack

| Layer | Teknologi |
| :--- | :--- |
| **Backend Framework** | Laravel 11 (PHP 8.2+) |
| **Frontend** | Blade Templates, TailwindCSS 3, Alpine.js |
| **Database** | MySQL |
| **GIS / Pemetaan** | Leaflet.js + CARTO Basemap Tiles |
| **Autentikasi** | Laravel Breeze + Laravel Socialite (Google OAuth) |
| **Ekspor PDF** | Barryvdh Laravel-Dompdf |
| **Build Tool** | Vite 5 |
| **Web Server** | Laragon (Apache) |

---

## 📁 Struktur Proyek

```
PengaduanMasyarakat/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/
│   │   │   │   ├── DashboardController.php    # Dashboard statistik & ekspor PDF
│   │   │   │   ├── KategoriController.php     # CRUD kategori infrastruktur
│   │   │   │   └── PengaduanController.php    # Kelola & update status aduan
│   │   │   ├── Auth/
│   │   │   │   ├── GoogleAuthController.php   # Integrasi Google OAuth
│   │   │   │   └── ...                        # Breeze auth controllers
│   │   │   ├── PengaduanController.php        # CRUD pengaduan masyarakat
│   │   │   └── ProfileController.php          # Kelola profil pengguna
│   │   └── Middleware/
│   │       └── RoleMiddleware.php             # Proteksi role admin/masyarakat
│   └── Models/
│       ├── User.php                           # Model pengguna (role-based)
│       ├── Kategori.php                       # Model kategori infrastruktur
│       └── Pengaduan.php                      # Model pengaduan + GIS coords
├── database/
│   └── migrations/                            # 8 file migrasi skema database
├── public/
│   └── js/
│       └── meranti-pandak-boundary.js         # Data poligon batas wilayah GIS
├── resources/
│   └── views/
│       ├── admin/
│       │   ├── dashboard.blade.php            # Halaman dashboard admin
│       │   ├── dashboard-pdf.blade.php        # Template cetak PDF resmi
│       │   ├── kategori/                      # Views CRUD kategori
│       │   └── pengaduan/                     # Views kelola pengaduan admin
│       ├── pengaduan/
│       │   ├── create.blade.php               # Form buat pengaduan + peta GIS
│       │   ├── edit.blade.php                 # Form edit + boundary check
│       │   ├── index.blade.php                # Daftar riwayat pengaduan
│       │   └── show.blade.php                 # Detail pengaduan
│       ├── welcome.blade.php                  # Landing page publik
│       └── auth/                              # Views autentikasi Breeze
└── routes/
    ├── web.php                                # Routing utama aplikasi
    └── auth.php                               # Routing autentikasi
```

---

## ⚙️ Instalasi & Konfigurasi

### Prasyarat
- PHP ≥ 8.2
- Composer
- Node.js ≥ 18 & npm
- MySQL
- Laragon / XAMPP / Herd (opsional)

### Langkah Instalasi

```bash
# 1. Clone repository
git clone https://github.com/username/PengaduanMasyarakat.git
cd PengaduanMasyarakat

# 2. Install dependensi PHP
composer install

# 3. Install dependensi Node.js
npm install

# 4. Salin file environment
cp .env.example .env

# 5. Generate application key
php artisan key:generate

# 6. Konfigurasi database di file .env
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=pengaduan_masyarakat
# DB_USERNAME=root
# DB_PASSWORD=

# 7. Jalankan migrasi database
php artisan migrate

# 8. Buat symbolic link untuk storage
php artisan storage:link

# 9. Build assets frontend
npm run build

# 10. Jalankan server development
php artisan serve
```

### Konfigurasi Google OAuth

Tambahkan kredensial Google OAuth pada file `.env`:

```env
GOOGLE_CLIENT_ID=your-google-client-id
GOOGLE_CLIENT_SECRET=your-google-client-secret
GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback
```

> 💡 Dapatkan kredensial dari [Google Cloud Console](https://console.cloud.google.com/) → APIs & Services → Credentials → OAuth 2.0 Client IDs

---

## 🗄️ Skema Database

Sistem menggunakan **3 tabel utama** yang saling terintegrasi:

```
┌──────────────┐       ┌──────────────────┐       ┌──────────────┐
│    users     │       │   pengaduans     │       │  kategoris   │
├──────────────┤       ├──────────────────┤       ├──────────────┤
│ id        PK │──┐    │ id            PK │    ┌──│ id        PK │
│ name         │  │    │ user_id       FK │◄───┘  │ nama         │
│ email     UQ │  └───►│ kategori_id   FK │◄──────│ deskripsi    │
│ password     │       │ judul            │       │ created_at   │
│ google_id    │       │ deskripsi        │       │ updated_at   │
│ avatar       │       │ foto             │       └──────────────┘
│ role         │       │ status (enum)    │
│ email_ver_at │       │ latitude  (10,7) │
│ created_at   │       │ longitude (10,7) │
│ updated_at   │       │ created_at       │
└──────────────┘       │ updated_at       │
                       └──────────────────┘
```

**Relasi:**
- `users` **(1)** → **(N)** `pengaduans` *(satu user dapat membuat banyak pengaduan)*
- `kategoris` **(1)** → **(N)** `pengaduans` *(satu kategori mengelompokkan banyak pengaduan)*

---

## 🔐 Role & Hak Akses

| Fitur | Masyarakat | Admin Kelurahan |
| :--- | :---: | :---: |
| Registrasi & Login (Email + Google) | ✅ | ✅ |
| Kelola Profil Pribadi | ✅ | ✅ |
| Buat Pengaduan Baru + GIS | ✅ | ❌ |
| Lihat Riwayat & Lacak Status | ✅ | ❌ |
| Edit/Hapus Aduan (status Diajukan) | ✅ | ❌ |
| Dashboard Statistik + Peta GIS | ❌ | ✅ |
| Verifikasi & Update Status Aduan | ❌ | ✅ |
| Kelola Kategori Infrastruktur | ❌ | ✅ |
| Ekspor Laporan PDF Bulanan | ❌ | ✅ |

---

## 📸 Tangkapan Layar

### Landing Page
> Halaman beranda publik menampilkan peta sebaran pengaduan, statistik aduan, dan tombol aksi utama.

### Form Pengaduan + Peta GIS
> Formulir interaktif dengan unggah foto bukti dan penentuan titik koordinat pada peta Leaflet.js dilengkapi boundary check wilayah kelurahan.

### Dashboard Admin
> Panel admin menyajikan kartu statistik, progress penyelesaian, filter periode, dan peta GIS seluruh aduan.

### Ekspor Laporan PDF
> Dokumen PDF resmi ber-kop surat kelurahan dengan tabel rekapitulasi dan rincian aduan bulanan.

---

## 🧪 Pengujian

Pengujian dilakukan menggunakan metode **Black-Box Testing** pada seluruh modul fungsional utama:

| No | Modul yang Diuji | Hasil |
| :-: | :--- | :---: |
| 1 | Autentikasi Pengguna (Email + Google OAuth) | ✅ Valid |
| 2 | Pembuatan Pengaduan Baru + Geotagging GIS | ✅ Valid |
| 3 | Validasi Boundary Check Wilayah Kelurahan | ✅ Valid |
| 4 | Pelacakan & Edit Status Pengaduan | ✅ Valid |
| 5 | Tindak Lanjut Pengaduan oleh Admin | ✅ Valid |
| 6 | Manajemen CRUD Kategori Infrastruktur | ✅ Valid |
| 7 | Ekspor Laporan PDF Bulanan (Filter Periode) | ✅ Valid |

> **Hasil:** Seluruh fitur fungsional berjalan **100% sesuai harapan**, stabil, aman, dan bebas dari kesalahan (*bug*).

---

## 👨‍💻 Penulis

**Fadilah Amri** — NIM 2155201134

- 📧 Email: ikuyt123@gmail.com
- 🎓 Program Studi Teknik Informatika
- 🏫 Fakultas Ilmu Komputer, Universitas Lancang Kuning Pekanbaru

**Dosen Pembimbing:** Taslim, M.Kom., MTA., MCE.

---

## 📄 Lisensi

Proyek ini dikembangkan untuk keperluan akademis (Tugas Akhir/Skripsi) dan dilisensikan di bawah [MIT License](LICENSE).

---

<p align="center">
  <i>Dibuat dengan ❤️ untuk Kelurahan Meranti Pandak, Kecamatan Rumbai, Kota Pekanbaru</i>
</p>
