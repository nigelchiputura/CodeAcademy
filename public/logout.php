<?php

require_once __DIR__ . '/../bootstrap.php';

// Destroy session securely
$_SESSION = [];
session_unset();
session_destroy();

// Redirect to login
header("Location: ./login.php");
exit;
