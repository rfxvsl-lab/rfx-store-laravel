<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RFX Universe | Visual & Digital Solutions</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .bg-grid-pattern {
            background-image: linear-gradient(to right, rgba(255,255,255,0.05) 1px, transparent 1px),
                              linear-gradient(to bottom, rgba(255,255,255,0.05) 1px, transparent 1px);
            background-size: 40px 40px;
        }
    </style>
</head>
<body class="bg-gray-950 text-white antialiased selection:bg-indigo-500 selection:text-white">

    <nav class="fixed w-full z-50 bg-gray-950/80 backdrop-blur-md border-b border-gray-800 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex items-center gap-3">
                    <span class="text-2xl font-extrabold tracking-tight italic">RFX<span class="text-indigo-500">.Visual</span></span>
                </div>
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('catalog') }}" class="text-sm font-medium text-gray-300 hover:text-white transition-colors font-bold uppercase tracking-widest">Katalog Store</a>
                    <a href="{{ route('portfolio') }}" class="text-sm font-medium text-gray-300 hover:text-white transition-colors font-bold uppercase tracking-widest">Portofolio</a>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="#contact" class="bg-white text-gray-950 px-5 py-2.5 rounded-full text-sm font-bold hover:bg-gray-200 transition-all transform active:scale-95">Get Started</a>
                </div>
            </div>
        </div>
    </nav>

    <section class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden min-h-screen flex items-center">
        <div class="absolute inset-0 bg-grid-pattern opacity-20"></div>
        <div class="absolute top-1/4 left-1/2 -translate-x-1/2 w-[600px] h-[600px] bg-indigo-600/30 rounded-full blur-[120px] pointer-events-none"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center z-10">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-500/10 border border-indigo-500/20 text-indigo-400 text-xs font-semibold uppercase tracking-wider mb-6">
                <span class="w-2 h-2 rounded-full bg-indigo-500 animate-pulse"></span> Freelance & Digital Solutions
            </div>
            <h1 class="text-5xl md:text-7xl font-extrabold tracking-tight mb-8 leading-tight">
                Membangun Dimensi <br class="hidden md:block" />
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 via-purple-400 to-pink-400 italic">Visual & Kreatif.</span>
            </h1>
            <p class="mt-4 text-lg md:text-xl text-gray-400 max-w-3xl mx-auto mb-10 leading-relaxed font-light">Dari sentuhan fotografi profesional hingga ekosistem produk digital premium yang dirancang untuk masa depan.</p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ route('catalog') }}" class="w-full sm:w-auto px-8 py-4 rounded-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold transition-all shadow-lg shadow-indigo-500/20 active:scale-95">Jelajahi Katalog Produk</a>
            </div>
        </div>
    </section>

    <section id="store" class="py-24 bg-gray-950 relative border-t border-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="flex flex-col md:flex-row justify-between items-end mb-16 gap-6">
                <div>
                    <h2 class="text-3xl md:text-5xl font-bold text-white mb-4 italic">Premium <span class="text-indigo-500 underline underline-offset-8">Digital Assets.</span></h2>
                    <p class="text-gray-400 max-w-2xl text-lg font-light">Pilih solusi digital terbaik untuk mempercepat pertumbuhan bisnis Anda.</p>
                </div>
                <a href="{{ route('catalog') }}" class="hidden md:flex items-center gap-2 text-indigo-400 font-black uppercase text-xs tracking-[0.3em] hover:text-white transition-all group">
                    Lihat Semua Produk <i class="fa-solid fa-arrow-right-long group-hover:translate-x-2 transition-transform"></i>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                {{-- MENGGUNAKAN COLLECT()->TAKE(4) UNTUK LIMIT --}}
                @forelse (collect($products)->take(4) as $item)
                    <div class="bg-gray-900/50 border border-gray-800 rounded-3xl p-5 group hover:border-indigo-500 transition-all duration-500 shadow-xl flex flex-col backdrop-blur-sm">
                        <div class="aspect-square bg-gray-800 rounded-2xl mb-5 overflow-hidden relative border border-gray-800">
                            <img src="{{ $item['image_url'] ?? '' }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 opacity-80 group-hover:opacity-100" alt="{{ $item['nama_produk'] }}">
                        </div>
                        <h3 class="text-lg font-bold text-white mb-2 italic group-hover:text-indigo-300 transition-colors">{{ $item['nama_produk'] }}</h3>
                        <p class="text-gray-500 text-xs mb-6 line-clamp-2 italic font-light leading-relaxed">Aset digital premium dari ekosistem RFX Universe.</p>
                        <a href="{{ route('catalog') }}" class="mt-auto w-full py-3.5 bg-indigo-600/10 text-indigo-400 rounded-2xl text-center text-[10px] font-black uppercase tracking-[0.2em] hover:bg-indigo-600 hover:text-white transition-all active:scale-95 shadow-lg">Buka Katalog</a>
                    </div>
                @empty
                    <div class="col-span-full text-center py-20 border border-dashed border-gray-800 rounded-3xl">
                        <p class="text-gray-600 italic">Produk belum tersedia di etalase utama.</p>
                    </div>
                @endforelse
            </div>
            
            <div class="mt-12 md:hidden">
                <a href="{{ route('catalog') }}" class="w-full py-4 bg-indigo-600 text-white rounded-2xl flex items-center justify-center font-bold uppercase tracking-widest text-xs">Jelajahi Semua Produk</a>
            </div>
        </div>
    </section>

    <section id="portfolio" class="py-24 bg-gray-950 relative overflow-hidden border-t border-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-6">
                <div class="max-w-2xl">
                    <h2 class="text-3xl md:text-5xl font-bold text-white mb-4 italic">Latest <span class="text-purple-500 underline underline-offset-8">Creations.</span></h2>
                    <p class="text-gray-400 text-lg font-light">Hasil tangkapan lensa dan proyek kreatif pilihan bulan ini.</p>
                </div>
                <a href="{{ route('portfolio') }}" class="flex items-center gap-2 text-purple-400 font-black uppercase text-xs tracking-[0.3em] hover:text-white transition-all group">
                    Lihat Galeri <i class="fa-solid fa-arrow-right-long group-hover:translate-x-2 transition-transform"></i>
                </a>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                {{-- MENGGUNAKAN COLLECT()->TAKE(4) UNTUK LIMIT --}}
                @forelse(collect($portfolios)->take(4) as $item)
                    <div class="relative group overflow-hidden rounded-2xl bg-gray-900 aspect-[3/4] border border-gray-800 shadow-2xl">
                        <img src="{{ $item['image_url'] ?? '' }}" class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 opacity-60 group-hover:opacity-100" alt="{{ $item['judul'] ?? 'Portofolio' }}">
                        <div class="absolute inset-0 bg-gradient-to-t from-gray-950/90 via-transparent to-transparent flex items-end p-4">
                            <div>
                                <span class="text-[10px] font-bold text-indigo-400 uppercase tracking-[0.2em]">{{ $item['kategori'] ?? 'Project' }}</span>
                                <h3 class="text-xs font-bold text-white leading-tight mt-1 italic">{{ $item['judul'] ?? 'Untitled' }}</h3>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-10 text-gray-600 border border-dashed border-gray-800 rounded-2xl font-medium">
                        Galeri sedang dalam pemeliharaan.
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <section class="py-24 bg-gray-950 relative overflow-hidden border-t border-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center mb-20">
            <h2 class="text-3xl md:text-5xl font-bold text-white mb-4 italic">How We <span class="text-indigo-500">Work.</span></h2>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 relative mt-16">
                <div class="relative z-10 group"><div class="w-16 h-16 mx-auto bg-gray-900 border border-gray-800 rounded-2xl flex items-center justify-center mb-6 group-hover:border-indigo-500 transition-all duration-500"><i class="fa-solid fa-lightbulb text-2xl text-indigo-400"></i></div><h3 class="font-bold">Discovery</h3><p class="text-gray-500 text-xs mt-2 italic font-light italic">Konsultasi ide.</p></div>
                <div class="relative z-10 group"><div class="w-16 h-16 mx-auto bg-gray-900 border border-gray-800 rounded-2xl flex items-center justify-center mb-6 group-hover:border-purple-500 transition-all duration-500"><i class="fa-solid fa-camera text-2xl text-purple-400"></i></div><h3 class="font-bold">Execution</h3><p class="text-gray-500 text-xs mt-2 italic font-light italic">Produksi pro.</p></div>
                <div class="relative z-10 group"><div class="w-16 h-16 mx-auto bg-gray-900 border border-gray-800 rounded-2xl flex items-center justify-center mb-6 group-hover:border-pink-500 transition-all duration-500"><i class="fa-solid fa-wand-magic-sparkles text-2xl text-pink-400"></i></div><h3 class="font-bold">Editing</h3><p class="text-gray-500 text-xs mt-2 italic font-light italic">Color grading.</p></div>
                <div class="relative z-10 group"><div class="w-16 h-16 mx-auto bg-gray-900 border border-gray-800 rounded-2xl flex items-center justify-center mb-6 group-hover:border-green-500 transition-all duration-500"><i class="fa-solid fa-check-double text-2xl text-green-400"></i></div><h3 class="font-bold">Delivery</h3><p class="text-gray-500 text-xs mt-2 italic font-light italic">Best Quality.</p></div>
            </div>
        </div>
    </section>

    @php
        $contactEmail = "mhmmadridho64@gmail.com"; 
        $contactPhone = "+6285731021469";
        $contactIG = "rfx.visual"; 
        $igLink = "https://www.instagram.com/ridhofbry?igsh=NjExc3E4MWRjNXlw" . $contactIG;
        $waLinkFooter = "https://wa.me/" . str_replace(['+',' '], '', $contactPhone);
        $msgKonsultasi = "Halo Ridho/Admin RFX Store, saya tertarik untuk melakukan *konsultasi gratis* mengenai proyek saya.";
        $linkWA_Konsultasi = $waLinkFooter . "?text=" . urlencode($msgKonsultasi);
    @endphp

    <section id="contact" class="py-24 relative overflow-hidden">
        <div class="absolute inset-0 bg-indigo-600 opacity-10 blur-[100px] rounded-full -translate-y-1/2"></div>
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <div class="bg-gray-900 border border-gray-800 rounded-3xl p-12 shadow-2xl">
                <h2 class="text-4xl font-bold text-white mb-6 italic">Ready to transform your vision?</h2>
                <p class="text-gray-400 mb-10 text-lg font-light italic">Konsultasikan kebutuhan fotografi, streaming, atau solusi digital Anda sekarang.</p>
                <div class="flex justify-center">
                    <a href="{{ $linkWA_Konsultasi }}" target="_blank" class="bg-white text-gray-950 px-10 py-4 rounded-full font-black text-sm uppercase tracking-widest hover:bg-gray-200 transition-all transform active:scale-95 shadow-xl">
                        Mulai Konsultasi Gratis
                    </a>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-gray-950 pt-20 pb-10 border-t border-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-16">
                <div class="col-span-1 md:col-span-2">
                    <h3 class="text-2xl font-extrabold tracking-tight mb-6 italic">RFX<span class="text-indigo-500">.Visual</span></h3>
                    <p class="text-gray-400 leading-relaxed pr-0 md:pr-12 mb-8 font-light">
                        Penyedia solusi visual dan ekosistem digital kreatif. Berbasis di Malang, melayani klien di seluruh semesta digital dengan kualitas tanpa kompromi.
                    </p>
                    <div class="flex gap-4">
                        <a href="{{ $igLink }}" target="_blank" class="w-10 h-10 rounded-xl bg-gray-900 border border-gray-800 flex items-center justify-center text-gray-400 hover:text-indigo-500 hover:border-indigo-500 transition-all shadow-lg">
                            <i class="fa-brands fa-instagram text-lg"></i>
                        </a>
                        <a href="{{ $waLinkFooter }}" target="_blank" class="w-10 h-10 rounded-xl bg-gray-900 border border-gray-800 flex items-center justify-center text-gray-400 hover:text-green-500 hover:border-green-500 transition-all shadow-lg">
                            <i class="fa-brands fa-whatsapp text-lg"></i>
                        </a>
                    </div>
                </div>

                <div>
                    <h4 class="text-xs font-black text-white mb-6 uppercase tracking-[0.2em]">Navigasi Cepat</h4>
                    <ul class="space-y-4 text-sm font-medium">
                        <li><a href="#" class="text-gray-500 hover:text-indigo-400 transition-colors">Beranda</a></li>
                        <li><a href="{{ route('catalog') }}" class="text-gray-500 hover:text-indigo-400 transition-colors">Katalog Digital</a></li>
                        <li><a href="{{ route('portfolio') }}" class="text-gray-500 hover:text-indigo-400 transition-colors">Portofolio Karya</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-xs font-black text-white mb-6 uppercase tracking-[0.2em]">Hubungi Kami</h4>
                    <ul class="space-y-4 text-sm font-medium">
                        <li class="flex items-center gap-3 text-gray-500"><i class="fa-solid fa-envelope text-indigo-500"></i> {{ $contactEmail }}</li>
                        <li class="flex items-center gap-3 text-gray-500"><i class="fa-brands fa-whatsapp text-green-500"></i> {{ $contactPhone }}</li>
                        <li class="flex items-center gap-3 text-gray-500"><i class="fa-solid fa-location-dot text-red-500"></i> Malang, Jawa Timur</li>
                    </ul>
                </div>
            </div>

            <div class="pt-8 border-t border-gray-900 flex flex-col md:flex-row justify-between items-center gap-4 text-[10px] text-gray-600 font-bold uppercase tracking-widest">
                <p>© {{ date('Y') }} RFX VISUAL & DIGITAL | All Right Reserved</p>
                <p>Support by Laravel <span class="text-indigo-400">Ridho Febriyansyah</span></p>
            </div>
        </div>
    </footer>
</body>
</html>