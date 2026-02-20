<?php

// 1. Paksa Vercel menggunakan folder /tmp untuk semua cache di level runtime
$tmpEnv = [
    'APP_CONFIG_CACHE' => '/tmp/config.php',
    'APP_EVENTS_CACHE' => '/tmp/events.php',
    'APP_PACKAGES_CACHE' => '/tmp/packages.php',
    'APP_ROUTES_CACHE' => '/tmp/routes.php',
    'APP_SERVICES_CACHE' => '/tmp/services.php',
    'VIEW_COMPILED_PATH' => '/tmp',
];
foreach ($tmpEnv as $k => $v) {
    putenv("$k=$v"); 
    $_ENV[$k] = $v; 
    $_SERVER[$k] = $v;
}

// 2. TRIK BYPASS: Paksa output jadi JSON agar tidak memicu error sistem View
$_SERVER['HTTP_ACCEPT'] = 'application/json';

// Pintu Masuk Asli Laravel
require __DIR__ . '/../public/index.php';