# Proyek Perpustakaan Digital (Fullstack Laravel & API)

Repositori ini berisi sistem aplikasi Perpustakaan Digital yang mencakup backend RESTful API, frontend berbasis Blade, serta dokumentasi kontrak API untuk keperluan uji silang.

## 🛠️ Persyaratan Sistem
- PHP >= 8.2
- Composer
- Node.js & NPM
- MySQL / SQLite

## 🚀 Panduan Instalasi & Menjalankan Server

1. **Clone Repositori:**
   ```bash
   git clone [https://github.com/aidiekamil-bit/Fullstack_Perpustakaan.git](https://github.com/aidiekamil-bit/Fullstack_Perpustakaan.git)
   cd Fullstack_Perpustakaan

2. Setup Backend (Laravel API):


    cd backend-perpustakaan
    composer install
    cp .env.example .env
    php artisan key:generate
    php artisan migrate --seed
    php artisan serve
    (Server backend akan berjalan di http://127.0.0.1:8000)

3. Cara Menguji Menggunakan Postman:

    Impor file Perpus_API.postman_collection.json ke dalam aplikasi Postman kamu.

    Sesuaikan variabel base_url menjadi http://127.0.0.1:8000.

    Lakukan pengujian mulai dari endpoint Register / Login untuk mendapatkan token akses (Bearer Token), lalu gunakan token tersebut untuk mengakses endpoint terproteksi seperti peminjaman buku.


