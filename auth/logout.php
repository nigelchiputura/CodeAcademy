<?php

if (isset($_POST['logout-submit'])) { 
    session_start();
    session_unset();
    session_destroy();
}

header("Location: ./login.php");
die();