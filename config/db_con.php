<?php

const HOST = 'localhost';
const DBNAME = 'nigey_academy';
const DBUSER = 'root';
const DBPASSWORD = '';
const PORT = 3306;

try {
    $pdo = new PDO("mysql:host=".HOST.";port=".PORT.";dbname=".DBNAME, DBUSER, DBPASSWORD);
    // echo "Success!";
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection Failed:" .$e->getMessage());
}