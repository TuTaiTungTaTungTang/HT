<?php
require_once __DIR__ . '/../src/functions.php';

session_start();

if (isset($_SESSION['name']) || isset($_SESSION['role']) || isset($_SESSION['id']) || isset($_SESSION['email'])) {
    unset($_SESSION['name'], $_SESSION['role'], $_SESSION['id'], $_SESSION['email']);
}

session_destroy();
redirect('/');

