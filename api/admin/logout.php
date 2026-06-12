<?php
require_once __DIR__ . '/../../includes/response.php';

session_start();

session_destroy();

jsonSuccess(null, "Çıkış yapıldı.");