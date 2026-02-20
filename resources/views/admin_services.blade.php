<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Services | RFX CMS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-950 text-white antialiased">

    <nav class="border-b border-gray-900 p-6 bg-gray-900/50 backdrop-blur-md sticky top-0 z-40">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-8">
                <h1 class="font-black text-xl tracking-tighter text-indigo-500 uppercase">RFX CMS</h1>
                <div class="hidden md:flex items-center gap-6 text-sm font-medium">
                    <a href="/admin" class="text-gray-400 hover:text-white">Produk</a>
                    <a href="/admin/portfolio" class="text-gray-400 hover:text-white">Portofolio</a>
                    <a href="/admin/services" class="text-white border-b-2 border-indigo-500 pb-1">Layanan Jasa</a>
                </div>
            </div>
            <a href="/logout" class="bg-red-500/10 text-red-500 px-4 py-1.5 rounded-full text-xs font-bold border border-red-500/20">Logout</a>
        </div>
    </nav>

    <main class="p-4 md:p-6 max-w-7xl mx-auto">
        @if(session('success'))
            <div class="bg-green-500/10 border border-green-500/20 text-green-400 p-4 rounded-2xl mb-6 flex items-center gap-3 animate-pulse">
                <i class="fa-solid fa-circle-check"></i> <span class="font-bold text-sm">{{ session('success') }}</span>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="space-y-6">
                <div class="bg-gray-900 border border-gray-800 rounded-3xl p-6">
                    <h3 class="font-bold text-lg mb-4 text-indigo-400 italic">1. Tambah Kategori Jasa</h3>
                    <form action="/admin/services/category/store" method="POST" class="space-y-4">
                        @csrf
                        <input type="text" name="nama_jasa" placeholder="Misal: Wisuda, Wedding..." required class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 focus:border-indigo-500 outline-none text-white text-sm">
                        <button type="submit" class="w-full bg-white text-gray-900 py-3 rounded-xl font-black text-xs uppercase tracking-widest active:scale-95 transition-all">Tambah Kategori</button>
                    </form>
                </div>

                <div class="bg-gray-900 border border-gray-800 rounded-3xl p-6">
                    <h3 class="font-bold text-lg mb-4 text-indigo-400 italic">2. Tambah Paket Harga</h3>
                    <form action="/admin/services/package/store" method="POST" class="space-y-4">
                        @csrf
                        <select name="category_id" required class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 focus:border-indigo-500 outline-none text-white text-sm">
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($services as $s)
                                <option value="{{ $s['id'] }}">{{ $s['nama_jasa'] }}</option>
                            @endforeach
                        </select>
                        <select name="nama_paket" required class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 focus:border-indigo-500 outline-none text-white text-sm">
                            <option value="Silver">Silver</option>
                            <option value="Gold">Gold</option>
                            <option value="Platinum">Platinum</option>
                        </select>
                        <input type="number" name="harga" placeholder="Harga (Angka Saja)" required class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 focus:border-indigo-500 outline-none text-white text-sm">
                        <button type="submit" class="w-full bg-indigo-600 text-white py-3 rounded-xl font-black text-xs uppercase tracking-widest active:scale-95 transition-all">Simpan Paket</button>
                    </form>
                </div>
            </div>

            <div class="lg:col-span-2 space-y-6">
                <h2 class="text-2xl font-bold italic">Daftar Layanan & Paket Harga</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($services as $s)
                    <div class="bg-gray-900 border border-gray-800 rounded-3xl p-6">
                        <div class="flex justify-between items-center mb-6">
                            <h4 class="text-xl font-black text-white italic underline underline-offset-4 decoration-indigo-500">{{ $s['nama_jasa'] }}</h4>
                            <span class="text-[10px] bg-gray-800 px-2 py-1 rounded text-gray-500 uppercase font-bold">Category</span>
                        </div>
                        
                        <div class="space-y-3">
                            @foreach($s['service_packages'] as $pkg)
                            <div class="flex justify-between items-center p-3 bg-gray-800/50 rounded-xl border border-gray-700">
                                <div>
                                    <p class="text-xs font-bold text-indigo-400">{{ $pkg['nama_paket'] }}</p>
                                    <p class="text-sm font-black italic">Rp {{ number_format($pkg['harga'], 0, ',', '.') }}</p>
                                </div>
                                <a href="/admin/services/package/delete/{{ $pkg['id'] }}" onclick="return confirm('Hapus paket ini?')" class="text-gray-600 hover:text-red-500 transition-colors">
                                    <i class="fa-solid fa-trash-can text-xs"></i>
                                </a>
                            </div>
                            @endforeach

                            @if(count($s['service_packages']) == 0)
                                <p class="text-xs text-gray-600 italic">Belum ada paket harga...</p>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </main>
</body>
</html>