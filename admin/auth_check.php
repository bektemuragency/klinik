<?php
require_once __DIR__ . '/../includes/config.php';

session_start();

if (empty($_SESSION[ADMIN_SESSION_NAME])) {
    header("Location: index.php");
    exit;
}