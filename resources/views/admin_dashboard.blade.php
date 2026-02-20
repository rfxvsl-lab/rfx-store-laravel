<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Management | RFX CMS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-950 text-white antialiased selection:bg-indigo-500">

    <nav class="border-b border-gray-900 p-6 bg-gray-900/50 backdrop-blur-md sticky top-0 z-40">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <h1 class="font-black text-xl tracking-tighter text-indigo-500">RFX CMS</h1>
            <div class="flex items-center gap-6">
                <a href="/admin" class="text-sm font-bold text-white border-b-2 border-indigo-500">Produk</a>
                <a href="/admin/portfolio" class="text-sm font-medium text-gray-400">Portofolio</a>
                <a href="/logout" class="bg-red-500/10 text-red-500 px-4 py-1.5 rounded-full text-xs font-bold border border-red-500/20">Logout</a>
            </div>
        </div>
    </nav>

    <main class="p-4 md:p-6 max-w-7xl mx-auto">
        @if(session('success'))
            <div class="bg-green-500/10 border border-green-500/20 text-green-400 p-4 rounded-2xl mb-6 flex items-center gap-3 animate-pulse">
                <i class="fa-solid fa-robot"></i> <span>{{ session('success') }}</span>
            </div>
        @endif

        <div class="flex flex-col md:flex-row justify-between items-center mb-10 gap-4">
            <div>
                <h2 class="text-3xl font-bold italic">Master Katalog</h2>
                <p class="text-gray-500 text-sm">Bot LH3 Aktif: Link G-Drive akan otomatis diconvert.</p>
            </div>
            <button onclick="toggleModal('modal-tambah')" class="bg-indigo-600 px-6 py-3 rounded-xl font-bold active:scale-95 transition-all flex items-center gap-2">
                <i class="fa-solid fa-plus-circle"></i> Tambah Item Baru
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($products as $p)
            <div class="bg-gray-900 border border-gray-800 rounded-3xl overflow-hidden shadow-2xl flex flex-col">
                <div class="aspect-video bg-black relative">
                    <img src="{{ $p['image_url'] }}" class="w-full h-full object-cover opacity-60">
                    <div class="absolute top-2 right-2 flex gap-2">
                        <a href="/admin/products/delete/{{ $p['id'] }}" onclick="return confirm('Hapus produk?')" class="w-8 h-8 bg-red-500/80 rounded-full flex items-center justify-center text-xs"><i class="fa-solid fa-trash"></i></a>
                    </div>
                </div>
                
                <div class="p-5 flex-1">
                    <h3 class="text-xl font-black italic mb-4">{{ $p['nama_produk'] }}</h3>
                    
                    <div class="space-y-2 mb-6">
                        <p class="text-[10px] font-black text-gray-500 uppercase tracking-widest">Daftar Tier Harga:</p>
                        @foreach($p['product_tiers'] as $t)
                        <div class="flex justify-between items-center bg-gray-800/50 p-2 rounded-lg border border-gray-800">
                            <span class="text-xs font-bold text-indigo-400">{{ $t['nama_tier'] }}</span>
                            <span class="text-xs font-black">Rp {{ number_format($t['harga'], 0, ',', '.') }}</span>
                        </div>
                        @endforeach
                        <button onclick="openTierModal('{{ $p['id'] }}', '{{ $p['nama_produk'] }}')" class="w-full py-2 border border-dashed border-gray-700 rounded-lg text-[10px] font-bold text-gray-500 hover:border-indigo-500 hover:text-indigo-400 transition-all">+ Tambah Tier (Bronze/Gold/Dll)</button>
                    </div>
                </div>

                <div class="p-4 border-t border-gray-800 bg-gray-800/20">
                    <a href="{{ $p['demo_url'] }}" target="_blank" class="text-[10px] text-gray-400 hover:text-white flex items-center gap-2 truncate">
                        <i class="fa-solid fa-link"></i> {{ $p['demo_url'] ?? 'No Demo Link' }}
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </main>

    <div id="modal-tambah" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-950/80 backdrop-blur-sm">
        <div class="bg-gray-900 border border-gray-800 w-full max-w-lg rounded-3xl p-8 shadow-2xl">
            <h3 class="text-xl font-bold text-indigo-400 mb-6">Tambah Katalog Baru</h3>
            <form action="/admin/products/store" method="POST" class="space-y-4">
                @csrf
                <input type="text" name="nama_produk" required placeholder="Nama Produk" class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 focus:border-indigo-500 outline-none text-white">
                <input type="text" name="image_url" placeholder="Link Preview (G-Drive/Direct)" class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 focus:border-indigo-500 outline-none text-white">
                <input type="text" name="demo_url" placeholder="Link Demo Website (Optional)" class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 focus:border-indigo-500 outline-none text-white">
                
                <div class="flex gap-2">
                    <button type="submit" class="flex-1 bg-indigo-600 py-4 rounded-xl font-black uppercase tracking-widest text-xs">Simpan Katalog</button>
                    <button type="button" onclick="toggleModal('modal-tambah')" class="px-6 py-4 bg-gray-800 rounded-xl font-bold text-xs uppercase">Batal</button>
                </div>
            </form>
        </div>
    </div>

    <div id="modal-tier" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-950/80 backdrop-blur-sm">
        <div class="bg-gray-900 border border-gray-800 w-full max-w-sm rounded-3xl p-8 shadow-2xl">
            <h3 id="tier-title" class="text-lg font-bold text-indigo-400 mb-6 uppercase tracking-tighter">Tambah Tier</h3>
            <form action="/admin/products/tier/store" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="product_id" id="tier-product-id">
                <input type="text" name="nama_tier" required placeholder="Nama Tier (Bronze, Silver, Lifetime...)" class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 focus:border-indigo-500 outline-none text-white text-sm">
                <input type="number" name="harga" required placeholder="Harga (Angka Saja)" class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 focus:border-indigo-500 outline-none text-white text-sm">
                <button type="submit" class="w-full bg-white text-gray-900 py-4 rounded-xl font-black uppercase tracking-widest text-xs">Tambah Harga</button>
                <button type="button" onclick="toggleModal('modal-tier')" class="w-full py-2 text-xs text-gray-500 font-bold">Tutup</button>
            </form>
        </div>
    </div>

    <script>
        function toggleModal(id) {
            document.getElementById(id).classList.toggle('hidden');
        }

        function openTierModal(id, name) {
            document.getElementById('tier-product-id').value = id;
            document.getElementById('tier-title').innerText = "Tier Harga: " + name;
            toggleModal('modal-tier');
        }
    </script>
</body>
</html>