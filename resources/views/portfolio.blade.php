<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfolio | RFX Visual</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .masonry { column-count: 2; column-gap: 1.5rem; }
        @media (min-width: 768px) { .masonry { column-count: 3; } }
        .masonry-item { break-inside: avoid; margin-bottom: 1.5rem; }
    </style>
</head>
<body class="bg-gray-950 text-white antialiased selection:bg-indigo-500">

    <nav class="p-6 border-b border-gray-900 bg-gray-950/50 backdrop-blur-lg fixed w-full z-50">
        <div class="max-w-7xl mx-auto flex justify-between items-center h-10">
            <a href="/" class="flex items-center gap-2 group">
                <i class="fa-solid fa-arrow-left text-gray-400 group-hover:text-white transition-colors"></i>
                <span class="font-bold text-sm">Kembali</span>
            </a>
            <div class="text-2xl font-extrabold tracking-tight">RFX<span class="text-indigo-500">.Visual</span></div>
        </div>
    </nav>

    <main class="pt-32 pb-20 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
        
        <header class="mb-16 text-center">
            <h1 class="text-4xl md:text-6xl font-extrabold mb-4 italic">Selected <span class="text-indigo-500">Works.</span></h1>
            <p class="text-gray-400 max-w-xl mx-auto italic">"Capturing moments that tell a story beyond the frame."</p>
        </header>

        <div class="masonry">
            @forelse($portfolios as $item)
            <div class="masonry-item group relative overflow-hidden rounded-3xl bg-gray-900 shadow-xl border border-gray-800 transition-all hover:border-indigo-500/50">
                <img src="{{ $item['image_url'] }}" class="w-full h-auto object-cover group-hover:scale-105 transition-transform duration-700 opacity-80 group-hover:opacity-100" alt="{{ $item['judul'] }}">
                <div class="absolute inset-0 bg-gradient-to-t from-gray-950 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex items-end p-8">
                    <div>
                        <p class="text-[10px] text-indigo-400 font-bold uppercase tracking-[0.2em] mb-2">{{ $item['kategori'] }}</p>
                        <h3 class="text-xl font-bold leading-tight italic">{{ $item['judul'] }}</h3>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-20 border border-dashed border-gray-800 rounded-3xl">
                <p class="text-gray-500 font-medium">Belum ada karya yang diunggah di database.</p>
            </div>
            @endforelse
        </div>

        <hr class="my-32 border-gray-900">

        <section id="order-form" class="max-w-4xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-5 gap-12 items-start">
                
                <div class="lg:col-span-2 space-y-8">
                    <div>
                        <h2 class="text-4xl font-black italic mb-4 leading-tight">Mulai Proyek <br><span class="text-indigo-500 underline underline-offset-8">Visual Anda.</span></h2>
                        <p class="text-gray-400 leading-relaxed">Pilih layanan, tentukan paket, dan biarkan kami menangani sisanya. Pesanan Anda akan langsung masuk ke tim kami.</p>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="flex items-center gap-4 text-gray-300">
                            <div class="w-10 h-10 rounded-full bg-indigo-500/10 flex items-center justify-center text-indigo-400"><i class="fa-solid fa-check text-sm"></i></div>
                            <span class="text-sm font-medium">Kualitas Foto/Video Tinggi</span>
                        </div>
                        <div class="flex items-center gap-4 text-gray-300">
                            <div class="w-10 h-10 rounded-full bg-indigo-500/10 flex items-center justify-center text-indigo-400"><i class="fa-solid fa-check text-sm"></i></div>
                            <span class="text-sm font-medium">Proses Editing Profesional</span>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-3 bg-gray-900 border border-gray-800 rounded-[2rem] p-8 md:p-10 shadow-2xl relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-40 h-40 bg-indigo-600/10 blur-[80px] rounded-full"></div>

                    @if(session('success_order'))
                        <div class="bg-green-500/10 border border-green-500/20 text-green-400 p-5 rounded-2xl mb-8 flex items-center gap-4 animate-bounce">
                            <i class="fa-solid fa-circle-check text-xl"></i>
                            <span class="font-bold text-sm">{{ session('success_order') }}</span>
                        </div>
                    @endif

                    <form action="/order/submit" method="POST" class="space-y-6 relative z-10">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <label class="text-[10px] font-black text-gray-500 uppercase tracking-widest mb-2 block">Data Klien</label>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <input type="text" name="nama" placeholder="Nama Lengkap" required class="w-full bg-gray-800/50 border border-gray-700 rounded-xl px-4 py-3.5 focus:border-indigo-500 outline-none transition-all placeholder:text-gray-600">
                                    <input type="tel" name="telp" placeholder="WhatsApp (Aktif)" required class="w-full bg-gray-800/50 border border-gray-700 rounded-xl px-4 py-3.5 focus:border-indigo-500 outline-none transition-all placeholder:text-gray-600">
                                </div>
                            </div>
                            <input type="email" name="email" placeholder="Alamat Email" required class="w-full bg-gray-800/50 border border-gray-700 rounded-xl px-4 py-3.5 focus:border-indigo-500 outline-none transition-all placeholder:text-gray-600">
                        </div>

                        <div class="space-y-4">
                            <label class="text-[10px] font-black text-gray-500 uppercase tracking-widest mb-2 block">Pilih Layanan</label>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <select id="select-jasa" name="tipe_jasa" onchange="updatePaket()" required class="w-full bg-gray-800/50 border border-gray-700 rounded-xl px-4 py-3.5 focus:border-indigo-500 outline-none appearance-none">
                                    <option value="">-- Tipe Jasa --</option>
                                    @foreach($services as $s)
                                        <option value="{{ $s['nama_jasa'] }}" data-packages='@json($s['service_packages'])'>{{ $s['nama_jasa'] }}</option>
                                    @endforeach
                                </select>
                                <select id="select-paket" name="paket" onchange="updateHarga()" disabled required class="w-full bg-gray-800/50 border border-gray-700 rounded-xl px-4 py-3.5 focus:border-indigo-500 outline-none disabled:opacity-30">
                                    <option value="">-- Paket --</option>
                                </select>
                            </div>
                        </div>

                        <div id="display-harga" class="hidden p-6 bg-indigo-600 border border-indigo-400 rounded-2xl text-center shadow-lg shadow-indigo-600/20">
                            <span class="text-indigo-100 text-xs font-bold block mb-1 uppercase tracking-tighter">Total Estimasi Biaya</span>
                            <span id="harga-teks" class="text-3xl font-black text-white italic tracking-tighter">Rp 0</span>
                            <input type="hidden" id="input-harga" name="harga_final" value="0">
                        </div>

                        <button type="submit" class="w-full bg-white text-gray-900 py-4 rounded-2xl font-black text-lg hover:bg-gray-200 transition-all active:scale-95 flex items-center justify-center gap-3">
                            <i class="fa-solid fa-paper-plane"></i> KIRIM PESANAN
                        </button>
                    </form>
                </div>
            </div>
        </section>
    </main>

    <footer class="py-12 border-t border-gray-900 text-center">
        <p class="text-gray-600 text-sm">© 2026 RFX Visual. Portfolio & Order System.</p>
    </footer>

    <script>
        function updatePaket() {
            const selectJasa = document.getElementById('select-jasa');
            const selectPaket = document.getElementById('select-paket');
            const displayHarga = document.getElementById('display-harga');
            
            selectPaket.innerHTML = '<option value="">-- Paket --</option>';
            displayHarga.classList.add('hidden');

            if (selectJasa.value) {
                const selectedOption = selectJasa.options[selectJasa.selectedIndex];
                const packages = JSON.parse(selectedOption.getAttribute('data-packages'));

                packages.forEach(pkg => {
                    const opt = document.createElement('option');
                    opt.value = pkg.nama_paket;
                    opt.text = pkg.nama_paket;
                    opt.setAttribute('data-price', pkg.harga);
                    selectPaket.appendChild(opt);
                });
                selectPaket.disabled = false;
            } else {
                selectPaket.disabled = true;
            }
        }

        function updateHarga() {
            const selectPaket = document.getElementById('select-paket');
            const displayHarga = document.getElementById('display-harga');
            const hargaTeks = document.getElementById('harga-teks');
            const inputHarga = document.getElementById('input-harga');

            if (selectPaket.value && selectPaket.selectedIndex > 0) {
                const price = selectPaket.options[selectPaket.selectedIndex].getAttribute('data-price');
                const formatted = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(price);
                
                hargaTeks.innerText = formatted;
                inputHarga.value = price;
                displayHarga.classList.remove('hidden');
            } else {
                displayHarga.classList.add('hidden');
            }
        }
    </script>
</body>
</html>