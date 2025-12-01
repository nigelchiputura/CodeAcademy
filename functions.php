<?php

// How long a flash message is valid (in seconds)
const FLASH_TTL = 5;

function removeFlashMessage(string $sessionVar): void
{
    if (!isset($_SESSION[$sessionVar])) {
        return;
    }

    // If we have a timestamp and it's older than TTL, or we just printed it,
    // we can safely remove it.
    unset($_SESSION[$sessionVar]);

    // If no more flash messages, also clear flash_time
    if (!isset($_SESSION['success']) && !isset($_SESSION['error'])) {
        unset($_SESSION['flash_time']);
    }
}

function outputFlashMessage(): void
{
    // If there's a timer set and it's too old, clear all flash and bail out
    if (isset($_SESSION['flash_time'])) {
        $age = time() - (int)$_SESSION['flash_time'];
        if ($age > FLASH_TTL) {
            unset($_SESSION['success'], $_SESSION['error'], $_SESSION['flash_time']);
            return;
        }
    }

    // Print message markup
    if (!empty($_SESSION['error']) || !empty($_SESSION['success'])) {

        $type = !empty($_SESSION['success']) ? 'success' : 'error';
        $msg  = htmlspecialchars($_SESSION[$type], ENT_QUOTES, 'UTF-8');

        echo "
        <div class='flash-message flash-$type'>
            <span>$msg</span>
            <button class='close-btn'>&times;</button>
        </div>
        ";

        // Remove message from session
        removeFlashMessage($type);
    }
}

function setFlash(string $type, string $message): void
{
    $_SESSION[$type] = $message;       // 'success' or 'error'
    $_SESSION['flash_time'] = time();
}

function inputEmpty(string ...$fields) {
    foreach ($fields as $field) {
        if (empty($field)) {
            return true;
        }
    } return false;
}

function generatePassword(int $length = 12) {
    $upper = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $lower = 'abcdefghijklmnopqrstuvwxyz';
    $numbers = '0123456789';
    $symbols = '!@#%^&*()_-=+;:,.?';

    // Ensure password has at least one of each
    $all = $upper . $lower .$numbers . $symbols; 
    $password = '';
    $password .=$upper[random_int(0, strlen($upper) - 1)]; 
    $password .= $lower[random_int(0, strlen($lower) - 1)];
    $password .=$numbers[random_int(0, strlen($numbers) - 1)]; 
    $password .= $symbols[random_int(0, strlen($symbols) - 1)];

    for ($i = 4; $i < $length; $i++) {
        $password .= $all[random_int(0, strlen($all) - 1)];
    }
    
    // Shuffle the result for randomness
    return str_shuffle($password);
}

/**
 * Generate (or fetch existing) CSRF token for current session
 */
function get_csrf_token(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['csrf_token'];
}

/**
 * Echo a hidden input with the CSRF token.
 * Use this inside <form> tags.
 */
function csrf_field(): void
{
    $token = htmlspecialchars(get_csrf_token(), ENT_QUOTES, 'UTF-8');
    echo '<input type="hidden" name="csrf_token" value="' . $token . '">';
}

/**
 * Check CSRF token value against session.
 */
function verify_csrf_token(?string $token): bool
{
    if (empty($_SESSION['csrf_token']) || empty($token)) {
        return false;
    }

    return hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Enforce valid CSRF token on POST requests.
 * Call this at the top of each public entry file that handles POST.
 */
function require_valid_csrf_token(): void
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $token = $_POST['csrf_token'] ?? '';

        if (!verify_csrf_token($token)) {
            http_response_code(419); // "authentication timeout" style code
            die('Invalid CSRF token. Please refresh the page and try again.');
        }
    }
}