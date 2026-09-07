# Sistem Monitoring Kerja Praktek (CI4)

Sistem Monitoring Kerja Praktek adalah sebuah platform berbasis web yang dikembangkan menggunakan framework CodeIgniter 4 untuk memfasilitasi dan memonitor alur pelaksanaan Kerja Praktek (KP) mahasiswa, mulai dari pengajuan kelompok, persetujuan instansi, bimbingan, pendaftaran seminar, hingga pengumpulan laporan akhir.

## Fitur Utama

Aplikasi ini dibagi menjadi 3 aktor/role utama dengan masing-masing hak akses:

1. **Mahasiswa**
   - Pengajuan Kelompok KP
   - Pengajuan Izin KP (Instansi)
   - Bimbingan (Log bimbingan)
   - Pendaftaran Seminar KP (Sidang)
   - Pengumpulan Laporan Akhir

2. **Dosen Pembimbing & Penguji**
   - Validasi/ACC log bimbingan mahasiswa
   - Melihat jadwal dan detail sidang (seminar)
   - Memberikan nilai sidang (sebagai pembimbing atau penguji)
   - Validasi laporan akhir

3. **Koordinator KP**
   - Menyetujui/Menolak pengajuan kelompok
   - Menyetujui surat izin instansi dan mengunggah surat balasan
   - Menentukan/mem-plot dosen pembimbing dan dosen penguji
   - Mengatur jadwal dan ruangan sidang
   - Validasi akhir kelulusan KP

## Persyaratan Sistem

- PHP versi 8.2 atau lebih baru.
- MySQL / MariaDB.
- Web server seperti Apache (XAMPP).
- Ekstensi PHP `intl`, `mbstring`, `json`, `mysqlnd` wajib diaktifkan.

## Cara Instalasi

1. *Clone* atau unduh repository ini ke dalam folder `htdocs` (jika menggunakan XAMPP) atau web root lokal Anda.
   ```bash
   git clone https://github.com/username/Sistem-Monitoring-KP-CI4.git
   ```
2. Buat sebuah database baru di MySQL (misalnya `monitoring_kp`).
3. Import file `monitoring_kp_dummy.sql` ke dalam database tersebut. File SQL ini berisi struktur tabel yang diperlukan beserta beberapa akun *dummy* untuk keperluan testing.
4. Salin file `env` menjadi `.env` lalu konfigurasikan bagian *Database*:
   ```env
   database.default.hostname = localhost
   database.default.database = monitoring_kp
   database.default.username = root
   database.default.password = 
   database.default.DBDriver = MySQLi
   database.default.DBPrefix =
   database.default.port = 3306
   ```
5. Akses aplikasi melalui browser dengan URL:
   ```text
   http://localhost/Sistem-Monitoring-KP-CI4/public/
   ```

## Akun Dummy untuk Pengujian

Database *dummy* (`monitoring_kp_dummy.sql`) telah dilengkapi dengan beberapa akun untuk memudahkan Anda dalam mencoba seluruh alur kerja sistem. Gunakan kredensial berikut untuk login:

### 1. Koordinator KP
- **NPM/NIP:** `koor`
- **Password:** `koor123`

### 2. Dosen Pembimbing / Penguji
- **Dosen 1**
  - **NIP:** `dosen1`
  - **Password:** `dosen123`
- **Dosen 2**
  - **NIP:** `dosen2`
  - **Password:** `dosen123`

### 3. Mahasiswa
- **Mahasiswa 1**
  - **NPM:** `mhs1`
  - **Password:** `mhs123`
- **Mahasiswa 2**
  - **NPM:** `mhs2`
  - **Password:** `mhs123`
- **Mahasiswa 3**
  - **NPM:** `mhs3`
  - **Password:** `mhs123`

## Penafian (Disclaimer)
Aplikasi ini pada awalnya dikembangkan secara *Native PHP Procedural* (sebagai bentuk *legacy code*) yang kemudian dilakukan migrasi dan refactoring ke dalam framework modern **CodeIgniter 4**. 

Selamat mencoba dan semoga bermanfaat!
