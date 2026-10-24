<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;

class FrontendController extends Controller
{
    private function apiUrl($endpoint)
    {
        return env('API_BASE_URL', 'http://127.0.0.1:8000/api') . $endpoint;
    }

    // Halaman Login & Register (Form)
    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    // Proses Login ke Backend API
    public function login(Request $request)
    {
        $response = Http::post($this->apiUrl('/login'), [
            'email' => $request->email,
            'password' => $request->password,
        ]);

        if ($response->successful()) {
            $token = $response->json('access_token');
            session(['api_token' => $token]);
            return redirect()->route('books.index');
        }

        return back()->withErrors(['email' => 'Email atau password salah.']);
    }

    // Proses Register ke Backend API
    public function register(Request $request)
    {
        $response = Http::post($this->apiUrl('/register'), [
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        if ($response->successful()) {
            $token = $response->json('access_token');
            session(['api_token' => $token]);
            return redirect()->route('books.index');
        }

        return back()->withErrors(['register' => 'Gagal melakukan registrasi.']);
    }

    // Menampilkan Daftar Buku
    public function index(Request $request)
    {
        $token = session('api_token');
        if (!$token) {
            return redirect()->route('login');
        }

        // 1. Ambil parameter dari URL (termasuk page, genre, sort) dan kirim ke Backend API
        $queryParams = $request->all();
        $response = Http::withToken($token)->get($this->apiUrl('/books'), $queryParams);

        // 2. Siapkan wadah default jika API gagal
        $books = new LengthAwarePaginator([], 0, 8, 1, ['path' => $request->url()]);

        if ($response->successful()) {
            $apiData = $response->json(); // Mengambil struktur JSON dari API backend

            // 3. Bungkus array JSON dari API ke dalam LengthAwarePaginator
            $books = new LengthAwarePaginator(
                $apiData['data'] ?? [],          // Data item buku per halaman
                $apiData['total'] ?? 0,          // Total keseluruhan data buku
                $apiData['per_page'] ?? 8,       // Jumlah data per halaman
                $apiData['current_page'] ?? 1,   // Halaman aktif saat ini
                [
                    'path'  => $request->url(),
                    'query' => $request->query() // Agar tombol halaman tetap membawa filter & sort
                ]
            );
        }

        // Kirim variabel $books yang sudah berupa Paginator ke file Blade
        return view('books.index', compact('books'));
    }

    // Logout
    public function logout()
    {
        $token = session('api_token');
        if ($token) {
            Http::withToken($token)->post($this->apiUrl('/logout'));
            session()->forget('api_token');
        }

        return redirect()->route('login');
    }

    // Proses Peminjaman Buku ke Backend API
    public function storeTransaction(Request $request)
    {
        $token = session('api_token');
        if (!$token) {
            return redirect()->route('login');
        }

        // Mengirim array items multi-buku langsung ke backend API
        $response = Http::withToken($token)->post($this->apiUrl('/transactions'), [
            'borrower_name' => $request->borrower_name,
            'phone_number'  => $request->phone_number,
            'due_date'      => $request->due_date,
            'items'         => $request->items, // menerima inputan multi-item dari form
        ]);

        if ($response->successful()) {
            return redirect()->route('transactions.index')->with('success', 'Transaksi peminjaman berhasil dicatat.');
        }

        return back()->withErrors(['error' => $response->json('message') ?? 'Gagal memproses peminjaman.']);
    }

    // Menampilkan Halaman Riwayat Peminjaman (Disesuaikan dengan Pagination)
    public function indexTransactions(Request $request)
    {
        $token = session('api_token');
        if (!$token) {
            return redirect()->route('login');
        }

        // Ambil parameter halaman dari URL dan kirim ke API backend
        $queryParams = $request->all();
        $response = Http::withToken($token)->get($this->apiUrl('/transactions'), $queryParams);

        // Wadah default jika API gagal
        $transactions = new LengthAwarePaginator([], 0, 10, 1, ['path' => $request->url()]);

        if ($response->successful()) {
            $json = $response->json();
            
            // Menyesuaikan struktur balasan API: ['success' => true, 'data' => $transactions]
            $paginatedData = $json['data'] ?? [];

            // Bungkus data transaksi API ke dalam LengthAwarePaginator
            $transactions = new LengthAwarePaginator(
                $paginatedData['data'] ?? [],          // Data item transaksi per halaman
                $paginatedData['total'] ?? 0,          // Total keseluruhan data transaksi
                $paginatedData['per_page'] ?? 10,      // Jumlah data per halaman
                $paginatedData['current_page'] ?? 1,   // Halaman aktif saat ini
                [
                    'path'  => $request->url(),
                    'query' => $request->query() // Agar tombol halaman tetap membawa parameter query
                ]
            );
        }

        return view('transactions.index', compact('transactions'));
    }

    // Tambah Buku Baru
    public function storeBook(Request $request)
    {
        $token = session('api_token');
        if (!$token) {
            return redirect()->route('login');
        }

        $response = Http::withToken($token)->post($this->apiUrl('/books'), [
            'title' => $request->title,
            'genre' => $request->genre,
            'stock' => $request->stock,
        ]);

        // Jika gagal, tampilkan pesan dari backend untuk debugging
        if (!$response->successful()) {
            dd($response->json(), $response->status());
        }

        return redirect()->route('books.index')->with('success', 'Buku berhasil ditambahkan.');
    }

    // Hapus Buku
    public function destroyBook($id)
    {
        $token = session('api_token');
        if (!$token) {
            return redirect()->route('login');
        }

        $response = Http::withToken($token)->delete($this->apiUrl("/books/{$id}"));

        if ($response->successful()) {
            return redirect()->route('books.index')->with('success', 'Buku berhasil dihapus.');
        }

        return back()->withErrors(['error' => 'Gagal menghapus buku.']);
    }
}