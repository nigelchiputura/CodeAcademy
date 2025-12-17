<?php

if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

function csrf_field(): void {
    echo '<input type="hidden" name="csrf_token" value="' . $_SESSION['csrf_token'] . '">';
}

function validate_csrf(): bool {
    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        return false;
    }
    return true;
}
