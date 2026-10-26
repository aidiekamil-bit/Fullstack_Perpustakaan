# Kontrak & Dokumentasi API - Perpustakaan Digital

Dokumen ini memuat kontrak resmi untuk endpoint API yang disediakan oleh sistem backend Perpustakaan Digital.

---

## 1. Register User
- **Tujuan:** Mendaftarkan akun pengguna baru ke dalam sistem.
- **HTTP Method & Path:** `POST /api/register`
- **Autentikasi:** Publik (Tanpa token)
- **Header:** `Content-Type: application/json`, `Accept: application/json`
- **Request Body (JSON):**
  - `name` (string, wajib): Nama lengkap pengguna.
  - `email` (string, wajib, format email unik): Alamat email pengguna.
  - `password` (string, wajib, min: 8): Kata sandi akun.
  - `password_confirmation` (string, wajib): Konfirmasi password harus sama.
- **Status & Respons Berhasil (201 Created):** Mengembalikan data user dan token akses Sanctum.
- **Status & Respons Gagal (422 Unprocessable Content):** Validasi gagal (misal email sudah terdaftar).
- **Efek pada Data:** Menambahkan data record baru ke tabel `users` di database.

---

## 2. Login User
- **Tujuan:** Mengautentikasi pengguna untuk mendapatkan Bearer Token.
- **HTTP Method & Path:** `POST /api/login`
- **Autentikasi:** Publik (Tanpa token)
- **Request Body (JSON):**
  - `email` (string, wajib): Email akun yang terdaftar.
  - `password` (string, wajib): Kata sandi akun.
- **Status & Respons Berhasil (200 OK):** Mengembalikan token akses (Bearer Token).
- **Status & Respons Gagal (401 Unauthorized / 422):** Kredensial salah atau tidak valid.
- **Efek pada Data:** Membuat token sesi baru di tabel personal access tokens.

---

## 3. Detail Pengguna (User Profile)
- **Tujuan:** Mengambil informasi data profil pengguna yang sedang login.
- **HTTP Method & Path:** `GET /api/user`
- **Autentikasi:** Protected (Memerlukan Header `Authorization: Bearer <token>`)
- **Header:** `Authorization: Bearer <token>`
- **Parameter:** Tidak ada.
- **Status & Respons Berhasil (200 OK):** Mengembalikan objek data user yang sedang aktif.
- **Status & Respons Gagal (401 Unauthorized):** Token tidak valid atau tidak disertakan.
- **Efek pada Data:** Tidak ada perubahan data (Read-only).

---

## 4. Daftar Buku (Katalog)
- **Tujuan:** Menampilkan daftar seluruh koleksi buku yang tersedia di perpustakaan.
- **HTTP Method & Path:** `GET /api/books`
- **Autentikasi:** Protected (Memerlukan Header `Authorization: Bearer <token>`)
- **Query Parameters (Opsional):**
  - `search` (string): Kata kunci pencarian judul buku.
  - `genre` (string): Filter berdasarkan kategori/genre buku.
- **Status & Respons Berhasil (200 OK):** Mengembalikan data list buku (dilengkapi pagination).
- **Status & Respons Gagal (401 Unauthorized):** Akses ditolak karena tidak ada token.
- **Efek pada Data:** Tidak ada perubahan data.

---

## 5. Peminjaman Buku (Transaksi)
- **Tujuan:** Mencatat data peminjaman buku baru oleh pengguna.
- **HTTP Method & Path:** `POST /api/transactions`
- **Autentikasi:** Protected (Memerlukan Header `Authorization: Bearer <token>`)
- **Request Body (JSON):**
  - `borrower_name` (string, wajib): Nama lengkap peminjam.
  - `phone_number` (string, wajib): Nomor telepon peminjam.
  - `due_date` (date, wajib): Tenggat waktu pengembalian buku.
  - `items` (array, wajib): Daftar ID buku dan jumlah yang dipinjam (`book_id`, `quantity`).
- **Status & Respons Berhasil (201 Created):** Transaksi berhasil dicatat dan stok buku diperbarui.
- **Status & Respons Gagal (400 / 422):** Stok buku tidak mencukupi atau format data salah.
- **Efek pada Data:** 
  - Mengurangi nilai kolom `stock` pada tabel `books` sesuai jumlah buku yang dipinjam.
  - Menambahkan data transaksi baru ke tabel `transactions`.