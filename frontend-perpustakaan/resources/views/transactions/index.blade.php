<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Peminjaman — Perpustakaan Digital</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['"Plus Jakarta Sans"', 'sans-serif'] }
                }
            }
        }
    </script>
</head>
<body class="bg-slate-50/60 text-slate-800 font-sans antialiased min-h-screen">

    <div class="flex h-screen overflow-hidden">
        
        <!-- Sidebar -->
        <aside class="w-64 bg-slate-900 text-white flex flex-col justify-between shadow-xl">
            <div>
                <div class="px-6 py-5 border-b border-slate-800 flex items-center space-x-3">
                    <div class="w-9 h-9 rounded-xl bg-slate-800 border border-slate-700 flex items-center justify-center text-white">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    </div>
                    <div>
                        <h1 class="text-sm font-bold">Perpustakaan</h1>
                        <p class="text-[10px] text-slate-400">Sistem Perpustakaan Digital</p>
                    </div>
                </div>
                <nav class="p-4 space-y-1">
                    <a href="{{ route('books.index') }}" class="flex items-center space-x-3 px-4 py-2.5 rounded-xl text-slate-400 hover:bg-slate-800 hover:text-white text-xs font-semibold transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                        <span>Katalog Utama</span>
                    </a>
                    <a href="{{ route('transactions.index') }}" class="flex items-center space-x-3 px-4 py-2.5 rounded-xl bg-slate-800 text-white text-xs font-semibold border border-slate-700/60 shadow-xs">
                        <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                        <span>Riwayat Peminjaman</span>
                    </a>
                </nav>
            </div>
            <div class="p-4 border-t border-slate-800 space-y-3">
                <div class="flex items-center space-x-3 px-3 py-2 bg-slate-800/60 rounded-xl border border-slate-800">
                    <div class="w-8 h-8 rounded-lg bg-slate-700 text-slate-200 flex items-center justify-center font-bold text-xs">
                        AD
                    </div>
                    <div class="overflow-hidden">
                        <p class="text-xs font-bold text-white truncate">Administrator</p>
                        <p class="text-[10px] text-slate-400 truncate">Token Session Active</p>
                    </div>
                </div>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full py-2 px-3 bg-red-950/40 hover:bg-red-900/60 text-red-300 border border-red-900/50 rounded-xl text-xs font-semibold transition-colors flex items-center justify-center space-x-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        <span>Keluar Sesi</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
            <header class="bg-white border-b border-slate-200/80 px-8 py-4 flex items-center justify-between">
                <div>
                    <h2 class="text-base font-bold text-slate-900">Riwayat Peminjaman Buku</h2>
                    <p class="text-xs text-slate-400">Arsip pencatatan transaksi peminjaman aktif</p>
                </div>
                <div class="px-3 py-1.5 bg-slate-100 text-slate-700 text-xs font-bold rounded-xl border border-slate-200">
                    Total Transaksi: {{ count($transactions) }}
                </div>
            </header>

            <main class="flex-1 overflow-y-auto p-8 space-y-6">
                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 uppercase tracking-wider font-bold">
                                <th class="p-4">Peminjam</th>
                                <th class="p-4">No. Telepon</th>
                                <th class="p-4">Judul Buku</th>
                                <th class="p-4">Jumlah</th>
                                <th class="p-4">Batas Jatuh Tempo & Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($transactions as $trx)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="p-4 font-bold text-slate-900">{{ $trx['borrower_name'] ?? '-' }}</td>
                                <td class="p-4 text-slate-600 font-medium">{{ $trx['phone_number'] ?? '-' }}</td>
                                
                                <!-- Judul Buku (Multi-Item Support) -->
                                <td class="p-4 font-semibold text-slate-800">
                                    @if(!empty($trx['details']))
                                        @foreach($trx['details'] as $detail)
                                            <div>{{ $detail['book']['title'] ?? 'Buku Dihapus' }}</div>
                                        @endforeach
                                    @elseif(!empty($trx['items']))
                                        @foreach($trx['items'] as $item)
                                            <div>{{ $item['book']['title'] ?? 'Buku Dihapus' }}</div>
                                        @endforeach
                                    @else
                                        Buku Dihapus
                                    @endif
                                </td>

                                <!-- Jumlah Buku -->
                                <td class="p-4 font-bold text-slate-900">
                                    @if(!empty($trx['details']))
                                        @foreach($trx['details'] as $detail)
                                            <div>{{ $detail['quantity'] ?? 1 }} Pcs</div>
                                        @endforeach
                                    @elseif(!empty($trx['items']))
                                        @foreach($trx['items'] as $item)
                                            <div>{{ $item['quantity'] ?? 1 }} Pcs</div>
                                        @endforeach
                                    @else
                                        {{ $trx['quantity'] ?? 1 }} Pcs
                                    @endif
                                </td>

                                <!-- Batas Jatuh Tempo dengan Indikator Status Waktu -->
                                <td class="p-4 font-medium">
                                    <div class="text-slate-700 mb-1">{{ $trx['due_date'] ?? '-' }}</div>
                                    @php
                                        $dueDate = \Carbon\Carbon::parse($trx['due_date']);
                                        $today = \Carbon\Carbon::today();
                                    @endphp

                                    @if($dueDate->isPast() && !$dueDate->isToday())
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-bold bg-red-50 text-red-700 border border-red-200">
                                             Terlambat
                                        </span>
                                    @elseif($dueDate->isToday())
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-200">
                                             Jatuh Tempo Hari Ini
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                            Aktif (Aman)
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="p-8 text-center text-slate-400 font-medium">Belum ada riwayat peminjaman.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
               <!-- TAMBAHKAN TOMBOL PAGINATION DI SINI -->
                <div class="mt-4">
                    {{ $transactions->links() }}
                </div>
            </main>
        </div>
    </div>

</body>
</html>