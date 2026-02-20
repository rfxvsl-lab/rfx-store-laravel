<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Digital Store | RFX Universe</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-gray-950 text-white antialiased">

    <nav class="p-6 border-b border-gray-800 bg-gray-950/80 backdrop-blur-md fixed w-full z-50">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <a href="/" class="text-2xl font-extrabold tracking-tight italic">RFX<span class="text-indigo-500">.Store</span></a>
            <button onclick="toggleCart()" class="relative p-3 bg-indigo-600/10 rounded-full text-indigo-400">
                <i class="fa-solid fa-cart-shopping"></i>
                <span id="cart-count" class="absolute -top-1 -right-1 bg-red-500 text-white text-[10px] w-5 h-5 rounded-full flex items-center justify-center font-bold">0</span>
            </button>
        </div>
    </nav>

    <main class="pt-32 pb-20 px-4 max-w-7xl mx-auto">
        <header class="mb-16 text-center">
            <h1 class="text-4xl md:text-6xl font-black italic mb-4">Premium <span class="text-indigo-500">Assets.</span></h1>
            <p class="text-gray-500">Katalog produk digital, source code, dan lisensi premium.</p>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-8">
            @foreach($products as $p)
            <div class="bg-gray-900 border border-gray-800 rounded-[2.5rem] p-6 shadow-2xl flex flex-col group">
                <div class="aspect-square rounded-[2rem] bg-black mb-6 overflow-hidden relative shadow-inner">
                    <img src="{{ $p['image_url'] }}" class="w-full h-full object-cover">
                    @if($p['demo_url'])
                    <a href="{{ $p['demo_url'] }}" target="_blank" class="absolute top-4 right-4 bg-black/50 backdrop-blur-md p-2 rounded-full text-xs hover:bg-indigo-600 transition-all"><i class="fa-solid fa-arrow-up-right-from-square"></i> Live Demo</a>
                    @endif
                </div>
                <h3 class="text-xl font-bold mb-4">{{ $p['nama_produk'] }}</h3>
                
                <div class="space-y-2 mt-auto">
                    @foreach($p['product_tiers'] as $tier)
                    <button onclick="addToCart('{{ $p['nama_produk'] }}', '{{ $tier['nama_tier'] }}', {{ $tier['harga'] }})" class="w-full p-3 bg-gray-800 hover:bg-indigo-600 rounded-2xl flex justify-between items-center transition-all text-sm group/btn">
                        <span class="font-bold">{{ $tier['nama_tier'] }}</span>
                        <span class="text-indigo-400 group-hover/btn:text-white font-black italic">Rp {{ number_format($tier['harga'], 0, ',', '.') }}</span>
                    </button>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>
    </main>

    <div id="cart-modal" class="hidden fixed inset-0 z-[60] bg-gray-950/90 backdrop-blur-md flex items-center justify-center p-4">
        <div class="bg-gray-900 border border-gray-800 w-full max-w-lg rounded-[3rem] p-10 relative shadow-2xl">
            <button onclick="toggleCart()" class="absolute top-6 right-6 text-gray-500 hover:text-white"><i class="fa-solid fa-xmark text-2xl"></i></button>
            <h2 class="text-3xl font-black italic mb-8">Your <span class="text-indigo-500">Cart.</span></h2>
            
            <div id="cart-items" class="space-y-4 mb-10 max-h-60 overflow-y-auto pr-2">
                </div>

            <form onsubmit="checkout(event)" class="space-y-4">
                <input type="text" id="cust-name" placeholder="Nama Anda" required class="w-full bg-gray-800 border border-gray-700 rounded-2xl px-5 py-4 outline-none focus:border-indigo-500">
                <input type="tel" id="cust-wa" placeholder="Nomor WhatsApp" required class="w-full bg-gray-800 border border-gray-700 rounded-2xl px-5 py-4 outline-none focus:border-indigo-500">
                <div class="pt-6 border-t border-gray-800 flex justify-between items-center mb-6">
                    <span class="font-bold text-gray-500 uppercase tracking-widest text-xs">Total Pembayaran</span>
                    <span id="cart-total" class="text-2xl font-black italic">Rp 0</span>
                </div>
                <button type="submit" class="w-full bg-white text-gray-900 py-4 rounded-2xl font-black text-lg hover:bg-indigo-500 hover:text-white transition-all">CHECKOUT VIA WA</button>
            </form>
        </div>
    </div>

    <script>
        let cart = [];

        function toggleCart() {
            document.getElementById('cart-modal').classList.toggle('hidden');
            renderCart();
        }

        function addToCart(produk, tier, harga) {
            cart.push({ produk, tier, harga });
            updateCartBadge();
            alert(`Berhasil menambah ${produk} (${tier}) ke keranjang!`);
        }

        function updateCartBadge() {
            document.getElementById('cart-count').innerText = cart.length;
        }

        function renderCart() {
            const container = document.getElementById('cart-items');
            const totalEl = document.getElementById('cart-total');
            container.innerHTML = '';
            let total = 0;

            cart.forEach((item, index) => {
                total += item.harga;
                container.innerHTML += `
                    <div class="flex justify-between items-center bg-gray-800/50 p-4 rounded-2xl border border-gray-800">
                        <div>
                            <p class="font-bold text-sm">${item.produk}</p>
                            <p class="text-[10px] text-indigo-400 font-black uppercase">${item.tier}</p>
                        </div>
                        <div class="flex items-center gap-4">
                            <span class="text-xs font-black italic">Rp ${item.harga.toLocaleString('id-ID')}</span>
                            <button onclick="removeItem(${index})" class="text-red-500"><i class="fa-solid fa-trash-can"></i></button>
                        </div>
                    </div>
                `;
            });
            totalEl.innerText = 'Rp ' + total.toLocaleString('id-ID');
        }

        function removeItem(index) {
            cart.splice(index, 1);
            renderCart();
            updateCartBadge();
        }

        function checkout(e) {
            e.preventDefault();
            const name = document.getElementById('cust-name').value;
            const wa = document.getElementById('cust-wa').value;
            let total = 0;
            let message = `Halo RFX Store, saya mau order:\n\n*Data Pembeli:*\nNama: ${name}\nWA: ${wa}\n\n*Item Order:*\n`;
            
            cart.forEach(item => {
                message += `- ${item.produk} (${item.tier}) : Rp ${item.harga.toLocaleString('id-ID')}\n`;
                total += item.harga;
            });
            
            message += `\n*Total Tagihan:* Rp ${total.toLocaleString('id-ID')}\n\nMohon diproses, terima kasih!`;
            
            const waUrl = `https://wa.me/6285731021469?text=${encodeURIComponent(message)}`;
            window.open(waUrl, '_blank');
        }
    </script>
</body>
</html>