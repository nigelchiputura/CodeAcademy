<?php

// -----------------------------------------
// Session Security Configuration
// -----------------------------------------
ini_set("session.use_only_cookies", 1);
ini_set("session.use_strict_mode", 1);

// Cookie parameters
session_set_cookie_params([
    'lifetime' => 1800,          // 30 minutes
    'domain'   => 'localhost',   // Change to real domain in production
    'path'     => '/',
    'secure'   => false,         // TRUE in production with HTTPS
    'httponly' => true,          // JS cannot read cookie
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
