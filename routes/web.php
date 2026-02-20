<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

/*
|--------------------------------------------------------------------------
| FRONT-END ROUTES (Beranda, Katalog, Portofolio)
|--------------------------------------------------------------------------
*/

// 1. Beranda (Spoiler Mode: Limit 4 Produk & 4 Portofolio)
Route::get('/', function () {
    $supabaseUrl = rtrim(env('SUPABASE_URL'), '/');
    $supabaseKey = env('SUPABASE_KEY');

    $resProducts = Http::withHeaders(['apikey' => $supabaseKey, 'Authorization' => 'Bearer ' . $supabaseKey])
        ->get($supabaseUrl . '/rest/v1/products', ['status' => 'eq.Tersedia', 'order' => 'id.desc']);

    $resPortfolio = Http::withHeaders(['apikey' => $supabaseKey, 'Authorization' => 'Bearer ' . $supabaseKey])
        ->get($supabaseUrl . '/rest/v1/portfolios', ['order' => 'id.desc']);

    return view('welcome', [
        'products' => $resProducts->json() ?? [],
        'portfolios' => $resPortfolio->json() ?? []
    ]);
});

// 2. Katalog Lengkap (Multi-Tier & Keranjang Belanja)
Route::get('/catalog', function () {
    $supabaseUrl = rtrim(env('SUPABASE_URL'), '/');
    $supabaseKey = env('SUPABASE_KEY');

    $resProducts = Http::withHeaders(['apikey' => $supabaseKey, 'Authorization' => 'Bearer ' . $supabaseKey])
        ->get($supabaseUrl . '/rest/v1/products', [
            'select' => '*, product_categories(nama_kategori), product_tiers(*)',
            'status' => 'eq.Tersedia',
            'order' => 'id.desc'
        ]);

    return view('catalog', ['products' => $resProducts->json() ?? []]);
})->name('catalog');

// 3. Portfolio Lengkap (Gallery & Form Order Jasa)
Route::get('/portfolio', function () {
    $supabaseUrl = rtrim(env('SUPABASE_URL'), '/');
    $supabaseKey = env('SUPABASE_KEY');

    $resPortfolio = Http::withHeaders(['apikey' => $supabaseKey, 'Authorization' => 'Bearer ' . $supabaseKey])
        ->get($supabaseUrl . '/rest/v1/portfolios', ['order' => 'id.desc']);

    $resServices = Http::withHeaders(['apikey' => $supabaseKey, 'Authorization' => 'Bearer ' . $supabaseKey])
        ->get($supabaseUrl . '/rest/v1/service_categories', ['select' => '*, service_packages(*)']);

    return view('portfolio', [
        'portfolios' => $resPortfolio->json() ?? [],
        'services' => $resServices->json() ?? []
    ]);
})->name('portfolio');


/*
|--------------------------------------------------------------------------
| AUTHENTICATION
|--------------------------------------------------------------------------
*/

Route::get('/login', function () {
    if (session()->has('admin_logged_in')) return redirect('/admin');
    return view('login');
})->name('login');

Route::post('/login', function (Request $request) {
    $response = Http::withHeaders(['apikey' => env('SUPABASE_KEY'), 'Authorization' => 'Bearer ' . env('SUPABASE_KEY')])
        ->get(env('SUPABASE_URL') . '/rest/v1/admins', [
            'username' => 'eq.' . $request->username,
            'password' => 'eq.' . $request->password,
            'select' => '*'
        ]);

    if ($response->successful() && !empty($response->json())) {
        session(['admin_logged_in' => true, 'admin_user' => $request->username]);
        return redirect('/admin');
    }
    return back()->with('error', 'Username atau Password salah!');
});

Route::get('/logout', function () {
    session()->forget(['admin_logged_in', 'admin_user']);
    return redirect('/login');
});


/*
|--------------------------------------------------------------------------
| ADMIN PANEL & CMS (Prefix: /admin)
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->group(function () {

    // --- DASHBOARD PRODUK & KATALOG ---
    Route::get('/', function () {
        if (!session()->has('admin_logged_in')) return redirect('/login');
        $supabaseUrl = rtrim(env('SUPABASE_URL'), '/');
        $supabaseKey = env('SUPABASE_KEY');

        $resProducts = Http::withHeaders(['apikey' => $supabaseKey, 'Authorization' => 'Bearer ' . $supabaseKey])
            ->get($supabaseUrl . '/rest/v1/products', ['select' => '*, product_tiers(*)', 'order' => 'id.desc']);
        
        $resCats = Http::withHeaders(['apikey' => $supabaseKey, 'Authorization' => 'Bearer ' . $supabaseKey])
            ->get($supabaseUrl . '/rest/v1/product_categories');

        return view('admin_dashboard', [
            'products' => $resProducts->json() ?? [],
            'categories' => $resCats->json() ?? []
        ]);
    });

    // BOT LH3 UNTUK PRODUK
    Route::post('/products/store', function (Request $request) {
        if (!session()->has('admin_logged_in')) return redirect('/login');
        
        $url = $request->image_url;
        // Logic Bot LH3 G-Drive
        if (preg_match('/\/d\/([a-zA-Z0-9_-]+)/', $url, $match)) {
            $url = "https://lh3.googleusercontent.com/d/" . $match[1];
        }

        Http::withHeaders(['apikey' => env('SUPABASE_KEY'), 'Authorization' => 'Bearer ' . env('SUPABASE_KEY')])
            ->post(env('SUPABASE_URL') . '/rest/v1/products', [
                'nama_produk' => $request->nama_produk,
                'image_url' => $url,
                'demo_url' => $request->demo_url,
                'status' => 'Tersedia'
            ]);
        return back()->with('success', 'Produk & Gambar diproses Bot!');
    });

    Route::post('/products/tier/store', function (Request $request) {
        if (!session()->has('admin_logged_in')) return redirect('/login');
        Http::withHeaders(['apikey' => env('SUPABASE_KEY'), 'Authorization' => 'Bearer ' . env('SUPABASE_KEY')])
            ->post(env('SUPABASE_URL') . '/rest/v1/product_tiers', $request->except('_token'));
        return back()->with('success', 'Tier Harga ditambahkan!');
    });

    Route::get('/products/delete/{id}', function ($id) {
        if (!session()->has('admin_logged_in')) return redirect('/login');
        Http::withHeaders(['apikey' => env('SUPABASE_KEY'), 'Authorization' => 'Bearer ' . env('SUPABASE_KEY')])
            ->delete(env('SUPABASE_URL') . '/rest/v1/products?id=eq.' . $id);
        return back()->with('success', 'Produk dihapus!');
    });

    // --- CMS PORTOFOLIO (SMART BOT) ---
    Route::get('/portfolio', function () {
        if (!session()->has('admin_logged_in')) return redirect('/login');
        $res = Http::withHeaders(['apikey' => env('SUPABASE_KEY'), 'Authorization' => 'Bearer ' . env('SUPABASE_KEY')])
            ->get(env('SUPABASE_URL') . '/rest/v1/portfolios', ['order' => 'id.desc']);
        return view('admin_portfolio', ['portfolios' => $res->json()]);
    });

    Route::post('/portfolio/store', function (Request $request) {
        if (!session()->has('admin_logged_in')) return redirect('/login');
        
        $finalUrl = $request->image_url;

        // BOT 1: YouTube Converter
        if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $finalUrl, $match)) {
            $finalUrl = "https://www.youtube.com/embed/" . $match[1];
        } 
        // BOT 2: G-Drive LH3 Converter
        elseif (preg_match('/\/d\/([a-zA-Z0-9_-]+)/', $finalUrl, $match)) {
            $finalUrl = "https://lh3.googleusercontent.com/d/" . $match[1];
        }

        // BOT 3: File Upload (Max 2MB)
        if ($request->hasFile('file_upload')) {
            $file = $request->file('file_upload');
            if ($file->getSize() > 2048 * 1024) return back()->with('error', 'Gagal! Maksimal 2MB.');

            $fileName = time() . '_' . $file->getClientOriginalName();
            $uploadResponse = Http::withHeaders([
                'apikey' => env('SUPABASE_KEY'), 'Authorization' => 'Bearer ' . env('SUPABASE_KEY'),
                'Content-Type' => $file->getMimeType()
            ])->withBody(file_get_contents($file->getRealPath()), $file->getMimeType())
              ->post(env('SUPABASE_URL') . '/storage/v1/object/portfolios/' . $fileName);

            if ($uploadResponse->successful()) {
                $finalUrl = env('SUPABASE_URL') . '/storage/v1/object/public/portfolios/' . $fileName;
            }
        }

        Http::withHeaders(['apikey' => env('SUPABASE_KEY'), 'Authorization' => 'Bearer ' . env('SUPABASE_KEY')])
            ->post(env('SUPABASE_URL') . '/rest/v1/portfolios', [
                'judul' => $request->judul, 'kategori' => $request->kategori, 'image_url' => $finalUrl
            ]);
        return back()->with('success', 'Karya berhasil diproses Bot!');
    });

    Route::get('/portfolio/delete/{id}', function ($id) {
        if (!session()->has('admin_logged_in')) return redirect('/login');
        Http::withHeaders(['apikey' => env('SUPABASE_KEY'), 'Authorization' => 'Bearer ' . env('SUPABASE_KEY')])
            ->delete(env('SUPABASE_URL') . '/rest/v1/portfolios?id=eq.' . $id);
        return back()->with('success', 'Karya dihapus!');
    });

    // --- CMS LAYANAN JASA ---
    Route::get('/services', function () {
        if (!session()->has('admin_logged_in')) return redirect('/login');
        $res = Http::withHeaders(['apikey' => env('SUPABASE_KEY'), 'Authorization' => 'Bearer ' . env('SUPABASE_KEY')])
            ->get(env('SUPABASE_URL') . '/rest/v1/service_categories', ['select' => '*, service_packages(*)', 'order' => 'id.desc']);
        return view('admin_services', ['services' => $res->json()]);
    });

    Route::post('/services/category/store', function (Request $request) {
        if (!session()->has('admin_logged_in')) return redirect('/login');
        Http::withHeaders(['apikey' => env('SUPABASE_KEY'), 'Authorization' => 'Bearer ' . env('SUPABASE_KEY')])
            ->post(env('SUPABASE_URL') . '/rest/v1/service_categories', ['nama_jasa' => $request->nama_jasa]);
        return back()->with('success', 'Kategori Jasa berhasil ditambah!');
    });

    Route::post('/services/package/store', function (Request $request) {
        if (!session()->has('admin_logged_in')) return redirect('/login');
        Http::withHeaders(['apikey' => env('SUPABASE_KEY'), 'Authorization' => 'Bearer ' . env('SUPABASE_KEY')])
            ->post(env('SUPABASE_URL') . '/rest/v1/service_packages', $request->except('_token'));
        return back()->with('success', 'Paket harga berhasil disimpan!');
    });
});

/*
|--------------------------------------------------------------------------
| ORDER SYSTEM (SMTP GMAIL INTEGRATED)
|--------------------------------------------------------------------------
*/
Route::post('/order/submit', function (Request $request) {
    $data = $request->all();
    
    // Format Pesan untuk Email
    $subject = "🔥 PESANAN BARU: " . ($data['paket'] ?? 'Produk') . " - RFX Visual";
    $content = "Halo Ridho, ada pesanan masuk dari website!\n\n"
             . "--- DATA PEMESAN ---\n"
             . "Nama      : " . ($data['nama'] ?? '-') . "\n"
             . "WhatsApp  : " . ($data['telp'] ?? '-') . "\n"
             . "Email     : " . ($data['email'] ?? '-') . "\n\n"
             . "--- DETAIL ORDER ---\n"
             . "Kategori  : " . ($data['tipe_jasa'] ?? 'Digital Asset') . "\n"
             . "Paket/Tier: " . ($data['paket'] ?? 'Default') . "\n"
             . "Total     : Rp " . number_format(($data['harga_final'] ?? 0), 0, ',', '.') . "\n\n"
             . "--- INSTRUKSI ---\n"
             . "Silakan segera hubungi klien via WhatsApp atau Email tersebut.";

    try {
        // Kirim Email via SMTP
        Mail::raw($content, function ($message) use ($subject) {
            $message->to('mhmmadridho64@gmail.com') // Email tujuan (kamu)
                    ->subject($subject);
        });

        // Redirect balik dengan pesan sukses
        return back()->with('success_order', 'Pesanan terkirim ke email Ridho! Kami akan segera menghubungi Anda.');
        
    } catch (\Exception $e) {
        // Jika SMTP gagal (biasanya karena salah password/port)
        return back()->with('error', 'Gagal kirim email: ' . $e->getMessage());
    }
});