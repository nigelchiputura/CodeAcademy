<?php

namespace App\Controllers;

class IndexController {

    public function __construct()
    {
        require_once __DIR__ . '/../Views/index.php';
    }
}