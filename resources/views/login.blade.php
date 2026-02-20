<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | RFX Store</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-950 text-white flex items-center justify-center min-h-screen p-4">
    <div class="w-full max-w-md bg-gray-900 border border-gray-800 rounded-3xl p-8 shadow-2xl">
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-indigo-600 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg shadow-indigo-500/20">
                <i class="fa-solid fa-lock text-2xl text-white"></i>
            </div>
            <h1 class="text-2xl font-bold">Admin Panel</h1>
            <p class="text-gray-500 text-sm mt-2">Silakan masuk untuk mengelola toko.</p>
        </div>

        @if(session('error'))
            <div class="bg-red-500/10 border border-red-500/20 text-red-400 p-3 rounded-xl text-sm mb-6 text-center">
                {{ session('error') }}
            </div>
        @endif

        <form action="/login" method="POST" class="space-y-5">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-400 mb-2">Username</label>
                <input type="text" name="username" required class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 focus:outline-none focus:border-indigo-500 transition-colors">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-400 mb-2">Password</label>
                <input type="password" name="password" required class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 focus:outline-none focus:border-indigo-500 transition-colors">
            </div>
            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-500 text-white font-bold py-3 rounded-xl transition-all shadow-lg shadow-indigo-500/20">
                Masuk ke Dashboard
            </button>
        </form>
    </div>
    <script src="https://kit.fontawesome.com/your-code.js" crossorigin="anonymous"></script>
</body>
</html>