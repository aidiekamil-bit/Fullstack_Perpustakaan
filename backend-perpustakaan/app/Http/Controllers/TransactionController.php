<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    // Menampilkan riwayat peminjaman beserta detail buku
   public function index(Request $request)
{
    // Gunakan paginate() agar data riwayat terbagi per halaman
    $transactions = Transaction::with('details.book')->latest()->paginate(10);

    return response()->json([
        'success' => true,
        'data'    => $transactions
    ]);
}
    // Membuat transaksi peminjaman baru (multi-buku)
    public function store(Request $request)
    {
        $request->validate([
            'borrower_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'due_date' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.book_id' => 'required|exists:books,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        // Gunakan Database Transaction agar aman (rollback jika ada kendala)
        DB::beginTransaction();

        try {
            // 1. Cek ketersediaan stok semua buku terlebih dahulu
            foreach ($request->items as $item) {
                $book = Book::lockForUpdate()->find($item['book_id']);

                if ($book->stock < $item['quantity']) {
                    return response()->json([
                        'success' => false,
                        'message' => "Stok buku '{$book->title}' tidak mencukupi. Sisa stok: {$book->stock}"
                    ], 400);
                }
            }

            // 2. Buat data transaksi utama
            $transaction = Transaction::create([
                'borrower_name' => $request->borrower_name,
                'phone_number' => $request->phone_number,
                'due_date' => $request->due_date,
            ]);

            // 3. Masukkan detail transaksi dan kurangi stok buku
            foreach ($request->items as $item) {
                $book = Book::find($item['book_id']);

                TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'book_id' => $book->id,
                    'quantity' => $item['quantity'],
                ]);

                // Kurangi stok buku
                $book->decrement('stock', $item['quantity']);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Peminjaman berhasil dicatat dan stok telah dikurangi',
                'data' => $transaction->load('details.book')
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan pada server: ' . $e->getMessage()
            ], 500);
        }
    }
}