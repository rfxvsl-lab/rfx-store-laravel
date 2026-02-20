<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Portfolio | RFX CMS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-950 text-white antialiased selection:bg-indigo-500">

    <nav class="border-b border-gray-900 p-6 bg-gray-900/50 backdrop-blur-md sticky top-0 z-40">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-8">
                <h1 class="font-black text-xl tracking-tighter text-indigo-500 uppercase">RFX CMS</h1>
                <div class="hidden md:flex items-center gap-6">
                    <a href="/admin" class="text-sm font-medium text-gray-400 hover:text-white transition-colors">Produk</a>
                    <a href="/admin/portfolio" class="text-sm font-bold text-white border-b-2 border-indigo-500 pb-1">Portofolio</a>
                    <a href="/admin/services" class="text-sm font-medium text-gray-400 hover:text-white transition-colors">Layanan Jasa</a>
                </div>
            </div>
            <a href="/logout" class="bg-red-500/10 text-red-500 px-4 py-1.5 rounded-full text-xs font-bold border border-red-500/20">Logout</a>
        </div>
    </nav>

    <main class="p-4 md:p-6 max-w-7xl mx-auto">
        @if(session('success'))
            <div class="bg-green-500/10 border border-green-500/20 text-green-400 p-4 rounded-2xl mb-6 flex items-center gap-3 animate-pulse">
                <i class="fa-solid fa-robot text-xl"></i> <span>{{ session('success') }}</span>
            </div>
        @endif

        <div class="flex flex-col md:flex-row justify-between items-center mb-10 gap-4">
            <div>
                <h2 class="text-3xl font-bold italic">Galeri Portofolio</h2>
                <p class="text-gray-500 text-sm">Automasi Bot: Tempel link YouTube/Drive atau Upload file.</p>
            </div>
            <button onclick="toggleModal('modal-tambah')" class="w-full md:w-auto bg-indigo-600 px-6 py-3 rounded-xl font-bold shadow-lg shadow-indigo-500/20 flex items-center justify-center gap-2 active:scale-95 transition-all">
                <i class="fa-solid fa-plus-circle"></i> Tambah Karya
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($portfolios as $item)
            <div class="bg-gray-900 border border-gray-800 rounded-3xl overflow-hidden group shadow-xl">
                <div class="aspect-video relative overflow-hidden bg-black">
                    @if(str_contains($item['image_url'], 'youtube.com/embed'))
                        <iframe src="{{ $item['image_url'] }}" class="w-full h-full" frameborder="0" allowfullscreen></iframe>
                    @else
                        <img src="{{ $item['image_url'] }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    @endif
                    <div class="absolute top-2 right-2">
                        <a href="/admin/portfolio/delete/{{ $item['id'] }}" onclick="return confirm('Hapus karya ini?')" class="w-8 h-8 bg-red-500 text-white rounded-full flex items-center justify-center hover:scale-110 transition-transform"><i class="fa-solid fa-trash-can text-xs"></i></a>
                    </div>
                </div>
                <div class="p-4">
                    <span class="text-[10px] font-bold text-indigo-400 uppercase tracking-widest">{{ $item['kategori'] }}</span>
                    <h3 class="font-bold text-white truncate italic">{{ $item['judul'] }}</h3>
                </div>
            </div>
            @endforeach
        </div>
    </main>

    <div id="modal-tambah" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-950/80 backdrop-blur-sm">
        <div class="bg-gray-900 border border-gray-800 w-full max-w-xl rounded-3xl p-8 shadow-2xl animate-in zoom-in duration-300">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-bold text-indigo-400"><i class="fa-solid fa-robot mr-2"></i> Bot Intelligence</h3>
                <button onclick="toggleModal('modal-tambah')" class="text-gray-500 hover:text-white"><i class="fa-solid fa-xmark text-xl"></i></button>
            </div>
            
            <form action="/admin/portfolio/store" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[10px] font-black text-gray-500 uppercase mb-2">Judul Karya</label>
                        <input type="text" name="judul" required placeholder="Contoh: Cinematic Wedding" class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 focus:border-indigo-500 outline-none text-white text-sm">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-gray-500 uppercase mb-2">Kategori (Bisa Baru)</label>
                        <input list="categories" name="kategori" required placeholder="Pilih / Ketik..." class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 focus:border-indigo-500 outline-none text-white text-sm">
                        <datalist id="categories">
                            @foreach(collect($portfolios)->pluck('kategori')->unique() as $cat)
                                <option value="{{ $cat }}">
                            @endforeach
                        </datalist>
                    </div>
                </div>

                <div id="preview-container" class="hidden w-full aspect-video rounded-2xl bg-black border border-gray-800 overflow-hidden mb-4 shadow-inner flex items-center justify-center text-gray-700">
                    <img id="img-preview" class="hidden w-full h-full object-cover">
                    <iframe id="yt-preview" class="hidden w-full h-full" frameborder="0"></iframe>
                </div>

                <div class="p-4 bg-indigo-500/5 border border-indigo-500/10 rounded-2xl space-y-4">
                    <input type="text" name="image_url" id="link-input" oninput="handlePreview()" placeholder="Paste Link YouTube / G-Drive" class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 focus:border-indigo-500 outline-none text-sm text-indigo-300">
                    
                    <div class="flex items-center gap-4 text-[10px] text-gray-700 font-bold uppercase"><div class="h-px flex-1 bg-gray-800"></div>Atau File Foto (Max 2MB)<div class="h-px flex-1 bg-gray-800"></div></div>

                    <input type="file" name="file_upload" id="file-input" onchange="handleFilePreview()" accept="image/*" class="w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-indigo-600 file:text-white hover:file:bg-indigo-500 cursor-pointer">
                </div>

                <button type="submit" class="w-full bg-white text-gray-900 py-4 rounded-xl font-black text-sm hover:bg-gray-200 transition-all active:scale-95 shadow-xl shadow-indigo-500/10 uppercase tracking-widest">
                    Pajang Karya Sekarang
                </button>
            </form>
        </div>
    </div>

    <script>
        function toggleModal(id) {
            document.getElementById(id).classList.toggle('hidden');
        }

        // SMART PREVIEW LOGIC
        function handlePreview() {
            const url = document.getElementById('link-input').value;
            const container = document.getElementById('preview-container');
            const img = document.getElementById('img-preview');
            const yt = document.getElementById('yt-preview');

            container.classList.remove('hidden');
            img.classList.add('hidden');
            yt.classList.add('hidden');

            // Detect YouTube
            const ytMatch = url.match(/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/);
            if(ytMatch) {
                yt.src = "https://www.youtube.com/embed/" + ytMatch[1];
                yt.classList.remove('hidden');
                return;
            }

            // Detect Google Drive
            const gdMatch = url.match(/\/d\/([a-zA-Z0-9_-]+)/);
            if(gdMatch) {
                img.src = "https://lh3.googleusercontent.com/d/" + gdMatch[1];
                img.classList.remove('hidden');
                return;
            }

            // Standard Image Link
            if(url.match(/\.(jpeg|jpg|gif|png|webp)$/) != null || url.startsWith('http')) {
                img.src = url;
                img.classList.remove('hidden');
            }
        }

        function handleFilePreview() {
            const file = document.getElementById('file-input').files[0];
            const container = document.getElementById('preview-container');
            const img = document.getElementById('img-preview');
            const yt = document.getElementById('yt-preview');

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    img.src = e.target.result;
                    container.classList.remove('hidden');
                    img.classList.remove('hidden');
                    yt.classList.add('hidden');
                }
                reader.readAsDataURL(file);
            }
        }
    </script>
</body>
</html>