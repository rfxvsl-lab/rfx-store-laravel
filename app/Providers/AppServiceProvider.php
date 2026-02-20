<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL; // Wajib diimpor agar tidak error

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Gunakan config('app.env') karena lebih stabil dibanding env() saat cache aktif
        if (config('app.env') !== 'local') {
            URL::forceScheme('https');
        }
    }
}