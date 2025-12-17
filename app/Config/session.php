<?php

// -----------------------------------------
// Development Session Security Configuration
// -----------------------------------------
ini_set("session.use_only_cookies", 1);
ini_set("session.use_strict_mode", 1);

// Cookie parameters
session_set_cookie_params([
    'lifetime' => 3600,          // 1 hour
    'domain'   => 'localhost',   // Change to real domain in production
    'path'     => '/',
    'secure'   => false,         // TRUE in production with HTTPS
    'httponly' => true,          
    'samesite' => 'Strict',      // Prevent CSRF
]);

session_start();

// -----------------------------------------
// Automatic Session ID Rotation
// -----------------------------------------

// Rotate session ID if none exists
if (!isset($_SESSION['last_regeneration'])) {
    session_regenerate_id(true);
    $_SESSION['last_regeneration'] = time();
} else {
    // Regenerate session every 30 minutes
    $interval = 60 * 30;
    if (time() - $_SESSION['last_regeneration'] >= $interval) {
        session_regenerate_id(true);
        $_SESSION['last_regeneration'] = time();
    }
}


// -----------------------------------------
// Production Session Security Configuration
// -----------------------------------------

// Secure session configuration — production
// Must run before session_start() and any output

// Force cookie-only sessions & strict mode
// ini_set('session.use_only_cookies', 1);
// ini_set('session.use_strict_mode', 1);

// // Strong session cookie settings
// $cookieParams = [
//     'lifetime' => 60 * 60 * 24 * 1,    // 1 day (adjust as needed)
//     'path'     => '/',
//     'domain'   => 'yourdomain.com',   // set to your real domain, include leading dot for subdomains: '.example.com'
//     'secure'   => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off', // true when HTTPS is used
//     'httponly' => true,
//     'samesite' => 'Lax'               // Lax is recommended for auth flows; use Strict only if you understand consequences
// ];

// session_set_cookie_params($cookieParams);

// // Use a custom session name (avoid default PHPSESSID)
// session_name('gexsess');

// // Optional: set a custom save path outside webroot
// // make sure the folder exists and PHP can write to it
// // ini_set('session.save_path', __DIR__ . '/../storage/sessions');

// // Start session
// session_start();

// // Rotate on login and periodically (not too often)
// // Regenerate if older than X minutes OR on privilege change
// $regenInterval = 60 * 30; // 30 minutes
// if (!isset($_SESSION['last_regeneration'])) {
//     $_SESSION['last_regeneration'] = time();
// } elseif (time() - $_SESSION['last_regeneration'] > $regenInterval) {
//     session_regenerate_id(true);
//     $_SESSION['last_regeneration'] = time();
// }
