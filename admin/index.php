<?php
require_once __DIR__ . '/../includes/config.php';
session_start();

// zaten loginse dashboard'a at
if (!empty($_SESSION[ADMIN_SESSION_NAME])) {
    header("Location: dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Admin Giriş</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex items-center justify-center h-screen">

<div class="bg-white p-8 rounded shadow w-96">

    <h1 class="text-2xl font-bold mb-6">Admin Panel</h1>

    <form id="loginForm">

        <input type="email" name="email" placeholder="Email"
               class="w-full border p-2 mb-3 rounded">

        <input type="password" name="password" placeholder="Şifre"
               class="w-full border p-2 mb-3 rounded">

        <button class="bg-blue-600 text-white w-full p-2 rounded">
            Giriş Yap
        </button>

    </form>

    <p id="msg" class="text-red-500 mt-3"></p>

</div>

<script>
document.getElementById("loginForm").addEventListener("submit", async (e) => {
    e.preventDefault();

    const formData = new FormData(e.target);

    const res = await fetch("../api/admin/login.php", {
        method: "POST",
        body: formData
    });

    const data = await res.json();

    if (data.success) {
        window.location.href = "dashboard.php";
    } else {
        document.getElementById("msg").innerText = data.message;
    }
});
</script>

</body>
</html>