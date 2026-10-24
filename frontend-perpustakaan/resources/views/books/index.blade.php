<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog & Manajemen Buku — Perpustakaan Digital</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
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
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-slate-50/60 text-slate-800 font-sans antialiased min-h-screen"
      x-data="{ sidebarOpen: false, addBookModal: false }">

    <div class="flex h-screen overflow-hidden">

        <!-- Sidebar Navigation -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-50 w-64 bg-slate-900 text-white transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-auto flex flex-col justify-between shadow-xl">
            <div>
                <div class="px-6 py-5 border-b border-slate-800 flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-9 h-9 rounded-xl bg-slate-800 border border-slate-700 flex items-center justify-center text-white">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-sm font-bold text-white">Perpustakaan</h1>
                            <p class="text-[10px] text-slate-400">Sistem Perpustakaan Digital</p>
                        </div>
                    </div>
                    <button @click="sidebarOpen = false" class="lg:hidden text-slate-400 hover:text-white">✕</button>
                </div>

                <nav class="p-4 space-y-1">
                    <a href="{{ route('books.index') }}" class="flex items-center space-x-3 px-4 py-2.5 rounded-xl bg-slate-800 text-white text-xs font-semibold border border-slate-700/60 shadow-xs">
                        <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                        <span>Katalog Utama</span>
                    </a>
                    <a href="{{ route('transactions.index') }}" class="flex items-center space-x-3 px-4 py-2.5 rounded-xl text-slate-400 hover:bg-slate-800 hover:text-white text-xs font-semibold transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                        </svg>
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

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden" x-data="borrowModal()">

            <!-- Top Action Header -->
            <header class="bg-white border-b border-slate-200/80 px-6 lg:px-8 py-4 flex items-center justify-between z-10">
                <div class="flex items-center space-x-4 flex-1">
                    <button @click="sidebarOpen = true" class="lg:hidden text-slate-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>

                    <!-- Filter Genre & Sorting Form -->
                    <form method="GET" action="{{ route('books.index') }}" class="flex items-center space-x-2">
                        <select name="genre" onchange="this.form.submit()" class="py-2 px-3 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-700 focus:outline-none focus:border-slate-900">
                            <option value="">Semua Genre</option>
                            <option value="Teknologi" {{ request('genre') == 'Teknologi' ? 'selected' : '' }}>Teknologi</option>
                            <option value="Fiksi" {{ request('genre') == 'Fiksi' ? 'selected' : '' }}>Fiksi</option>
                            <option value="Sains" {{ request('genre') == 'Sains' ? 'selected' : '' }}>Sains</option>
                        </select>

                        <select name="sort" onchange="this.form.submit()" class="py-2 px-3 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-700 focus:outline-none focus:border-slate-900">
                            <option value="">Urutkan</option>
                            <option value="az" {{ request('sort') == 'az' ? 'selected' : '' }}>Judul A-Z</option>
                            <option value="za" {{ request('sort') == 'za' ? 'selected' : '' }}>Judul Z-A</option>
                            <option value="stock_high" {{ request('sort') == 'stock_high' ? 'selected' : '' }}>Stok Naik</option>
                            <option value="stock_low" {{ request('sort') == 'stock_low' ? 'selected' : '' }}>Stok Turun</option>
                        </select>
                    </form>
                </div>

                <!-- Tombol Tambah Buku -->
                <button @click="addBookModal = true" class="px-4 py-2 bg-slate-900 text-white text-xs font-semibold rounded-xl hover:bg-slate-800 transition-all flex items-center space-x-2 shadow-xs">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    <span>Tambah Buku</span>
                </button>
            </header>

            <!-- Scrollable Content -->
            <main class="flex-1 overflow-y-auto p-6 lg:p-8 space-y-6">

                <!-- NOTIFIKASI SUKSES DARI BACKEND -->
                @if(session('success'))
                    <div class="p-3 bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs rounded-xl font-semibold flex items-center justify-between">
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                <!-- NOTIFIKASI ERROR / GAGAL DARI BACKEND (Contoh: Stok kurang) -->
                @if(session('error'))
                    <div class="p-3 bg-red-50 border border-red-200 text-red-700 text-xs rounded-xl font-semibold flex items-center justify-between">
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                <!-- VALIDASI ERROR LARAVEL -->
                @if ($errors->any())
                    <div class="p-3 bg-red-50 border border-red-200 text-red-700 text-xs rounded-xl font-semibold">
                        <ul class="list-disc pl-4 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-bold text-slate-900">Katalog Koleksi Buku</h2>
                        <p class="text-xs text-slate-400">Total ketersediaan dalam database</p>
                    </div>
                    <span class="px-3 py-1 bg-slate-100 text-slate-700 text-xs font-bold rounded-xl border border-slate-200">
                        {{ count($books) }} Koleksi
                    </span>
                </div>

                <!-- Catalog Grid -->
                <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @forelse($books as $book)
                    <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-sm hover:shadow-md transition-all duration-200 flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                                <span class="px-2.5 py-1 bg-slate-100 text-slate-600 text-[11px] font-bold rounded-lg uppercase tracking-wider">{{ $book['genre'] }}</span>
                                <span class="px-2.5 py-1 text-[11px] font-bold rounded-lg border {{ $book['stock'] > 0 ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 'bg-red-50 text-red-700 border-red-200' }}">
                                    Stok: {{ $book['stock'] }}
                                </span>
                            </div>

                            <h3 class="font-bold text-base text-slate-900 mt-4 line-clamp-2 leading-snug">
                                {{ $book['title'] }}
                            </h3>
                        </div>

                        <div class="mt-6 pt-4 border-t border-slate-100 space-y-2">
                            @if($book['stock'] > 0)
                            <button @click="openModalWithBook('{{ $book['id'] }}')" 
                                    class="w-full py-2.5 bg-slate-900 hover:bg-slate-800 text-white text-xs font-semibold rounded-xl transition-all flex items-center justify-center space-x-2">
                                <span>Pinjam Buku</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </button>
                            @else
                            <button disabled class="w-full py-2.5 bg-slate-100 text-slate-400 text-xs font-bold rounded-xl cursor-not-allowed text-center">
                                Stok Habis
                            </button>
                            @endif

                            <!-- Tombol Hapus Buku -->
                            <form action="{{ route('books.destroy', $book['id']) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus buku ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full py-1.5 bg-red-50 hover:bg-red-100 text-red-600 text-[11px] font-semibold rounded-lg transition-colors">
                                    Hapus Buku
                                </button>
                            </form>
                        </div>
                    </div>
                    @empty
                    <div class="col-span-full py-12 text-center bg-white rounded-2xl border border-slate-200">
                        <p class="text-sm font-medium text-slate-500">Tidak ada buku yang sesuai dengan filter.</p>
                    </div>
                    @endforelse
                </section>

                <div class="mt-6">
                    {{ $books->links() }}
                </div>
            </main>

            <!-- Modal Peminjaman (Multi-Step & Multi-Item sesuai LKPD) -->
            <div x-show="open" class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/40 backdrop-blur-xs flex items-center justify-center p-4" x-cloak>
                <div class="bg-white rounded-2xl max-w-lg w-full p-6 space-y-4 shadow-2xl border border-slate-200">
                    <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                        <h3 class="text-sm font-bold text-slate-900" x-text="step === 1 ? 'Form Peminjaman Buku' : 'Ringkasan Peminjaman Buku'"></h3>
                        <button @click="open = false" class="text-slate-400 hover:text-slate-600 font-bold">✕</button>
                    </div>
                    
                    <form action="{{ route('transactions.store') }}" method="POST" class="space-y-3">
                        @csrf
                        
                        <!-- STEP 1: Input Data Transaksi -->
                        <div x-show="step === 1" class="space-y-3">
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Peminjam</label>
                                <input type="text" name="borrower_name" x-model="borrower_name" required class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:bg-white focus:outline-none">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1">No. Telepon</label>
                                <input type="text" name="phone_number" x-model="phone_number" required class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:bg-white focus:outline-none">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1">Tanggal Jatuh Tempo</label>
                                <input type="date" name="due_date" x-model="due_date" required class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:bg-white focus:outline-none">
                            </div>

                            <!-- Multi-Item Input -->
                            <div class="border-t border-slate-100 pt-3">
                                <div class="flex justify-between items-center mb-2">
                                    <label class="block text-xs font-bold text-slate-800">Daftar Buku yang Dipinjam</label>
                                    <button type="button" @click="addItem()" class="text-[11px] bg-slate-100 text-slate-700 px-2.5 py-1 rounded-lg font-semibold hover:bg-slate-200">+ Tambah Buku Lain</button>
                                </div>

                                <div class="space-y-2 max-h-40 overflow-y-auto pr-1">
                                    <template x-for="(item, index) in items" :key="index">
                                        <div class="flex gap-2 items-center">
                                            <select :name="`items[${index}][book_id]`" x-model="item.book_id" required class="w-2/3 py-2 px-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none">
                                                <option value="">-- Pilih Buku --</option>
                                                @foreach($books as $book)
                                                    <option value="{{ $book['id'] }}">{{ $book['title'] }} (Stok: {{ $book['stock'] }})</option>
                                                @endforeach
                                            </select>
                                            <input type="number" :name="`items[${index}][quantity]`" x-model="item.quantity" min="1" placeholder="Qty" required class="w-1/4 py-2 px-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none">
                                            <button type="button" @click="removeItem(index)" x-show="items.length > 1" class="w-10 text-red-500 font-bold text-base text-center">&times;</button>
                                        </div>
                                    </template>
                                </div>
                            </div>

                            <div class="pt-3 flex space-x-2">
                                <button type="button" @click="open = false" class="flex-1 py-2 bg-slate-100 text-slate-700 text-xs font-semibold rounded-xl">Batal</button>
                                <button type="button" @click="goToStep2()" class="flex-1 py-2 bg-slate-900 text-white text-xs font-semibold rounded-xl">Lanjut ke Ringkasan</button>
                            </div>
                        </div>

                        <!-- STEP 2: Ringkasan Pinjaman Sebelum Konfirmasi (Wajib LKPD) -->
                        <div x-show="step === 2" class="space-y-4">
                            <div class="p-3 bg-slate-50 border border-slate-200 rounded-xl text-xs space-y-2">
                                <p><strong>Nama Peminjam:</strong> <span x-text="borrower_name"></span></p>
                                <p><strong>No. Telepon:</strong> <span x-text="phone_number"></span></p>
                                <p><strong>Jatuh Tempo:</strong> <span x-text="due_date"></span></p>
                            </div>

                            <div class="border-t border-slate-100 pt-3">
                                <label class="block text-xs font-bold text-slate-800 mb-2">Rincian Buku Dipinjam:</label>
                                <div class="space-y-1.5 max-h-36 overflow-y-auto">
                                    <template x-for="(item, index) in items" :key="index">
                                        <div class="flex justify-between items-center bg-slate-50 p-2 rounded-lg text-xs">
                                            <span class="font-medium text-slate-800" x-text="getBookTitle(item.book_id)"></span>
                                            <span class="font-bold text-slate-900" x-text="item.quantity + ' Pcs'"></span>
                                        </div>
                                    </template>
                                </div>
                            </div>

                            <!-- Pilihan Kembali untuk Mengubah Data (Wajib LKPD) -->
                            <div class="pt-3 flex space-x-2">
                                <button type="button" @click="step = 1" class="flex-1 py-2 bg-slate-100 text-slate-700 text-xs font-semibold rounded-xl">← Ubah Data</button>
                                <button type="submit" class="flex-1 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded-xl transition-colors">Konfirmasi Transaksi</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>

    <!-- Modal Form Tambah Buku -->
    <div x-show="addBookModal" class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/40 backdrop-blur-xs flex items-center justify-center p-4" x-cloak>
        <div class="bg-white rounded-2xl max-w-md w-full p-6 space-y-4 shadow-2xl border border-slate-200" @click.away="addBookModal = false">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <h3 class="text-sm font-bold text-slate-900">Tambah Buku Baru</h3>
                <button @click="addBookModal = false" class="text-slate-400 hover:text-slate-600 font-bold">✕</button>
            </div>
            <form action="{{ route('books.store') }}" method="POST" class="space-y-3">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Judul Buku</label>
                    <input type="text" name="title" required class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:bg-white focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Genre</label>
                    <input type="text" name="genre" required placeholder="Teknologi / Fiksi / Sains" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:bg-white focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Stok Awal</label>
                    <input type="number" name="stock" min="1" required class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:bg-white focus:outline-none">
                </div>
                <div class="pt-2 flex space-x-2">
                    <button type="button" @click="addBookModal = false" class="flex-1 py-2 bg-slate-100 text-slate-700 text-xs font-semibold rounded-xl">Batal</button>
                    <button type="submit" class="flex-1 py-2 bg-slate-900 text-white text-xs font-semibold rounded-xl">Simpan Buku</button>
                </div>
            </form>
        </div>
        
    </div>
    <!-- Letakkan di bawah grid daftar buku -->


    <script>
    function borrowModal() {
        return {
            open: false,
            step: 1,
            borrower_name: '',
            phone_number: '',
            due_date: '',
            items: [{ book_id: '', quantity: 1 }],
            
            openModalWithBook(bookId) {
                this.step = 1;
                this.items = [{ book_id: bookId, quantity: 1 }];
                this.open = true;
            },
            addItem() {
                this.items.push({ book_id: '', quantity: 1 });
            },
            removeItem(index) {
                this.items.splice(index, 1);
            },
            goToStep2() {
                if(!this.borrower_name || !this.phone_number || !this.due_date) {
                    alert('Harap lengkapi semua data peminjam.');
                    return;
                }
                const hasEmptyBook = this.items.some(i => !i.book_id || i.quantity < 1);
                if(hasEmptyBook) {
                    alert('Harap pilih buku dan jumlahnya dengan benar.');
                    return;
                }
                this.step = 2;
            },
            getBookTitle(bookId) {
                const selectElement = document.querySelector(`select option[value="${bookId}"]`);
                return selectElement ? selectElement.textContent.split(' (Stok:')[0] : 'Buku Dipilih';
            }
        }
    }
    </script>
</body>
</html>