<?php
require_once __DIR__ . '/../includes/config.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (empty($_SESSION[ADMIN_SESSION_NAME])) {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

<div class="flex h-screen">

    <!-- SIDEBAR -->
    <aside class="w-64 bg-gray-900 text-white flex flex-col">

        <div class="p-5 text-xl font-bold border-b border-gray-700">
            KlinikCMS
        </div>

        <nav class="flex-1 p-4 space-y-2">

            <a href="dashboard.php" class="block p-2 rounded hover:bg-gray-700">
                📊 Dashboard
            </a>

            <a href="hizmetler.php" class="block p-2 rounded hover:bg-gray-700">
                🧾 Hizmetler
            </a>

            <a href="randevular.php" class="block p-2 rounded hover:bg-gray-700">
                📅 Randevular
            </a>

            <a href="ayarlar.php" class="block p-2 rounded hover:bg-gray-700">
                ⚙️ Ayarlar
            </a>

        </nav>

        <!-- LOGOUT -->
        <div class="p-4 border-t border-gray-700">
            <button
                id="logoutBtn"
                class="text-red-400 hover:text-red-200 w-full text-left"
            >
                🚪 Çıkış
            </button>
        </div>

    </aside>

    <!-- MAIN -->
    <div class="flex-1 flex flex-col">

        <header class="bg-white shadow p-4 flex justify-between">
            <div class="font-semibold">Admin Panel</div>
            <div class="text-sm text-gray-500">
                <?= $_SESSION[ADMIN_SESSION_NAME]['name'] ?? '' ?>
            </div>
        </header>

        <main class="p-6 overflow-auto flex-1">
            <?= $content ?? '' ?>
        </main>

    </div>

</div>

<!-- LOGOUT SCRIPT -->
<script>
document.getElementById("logoutBtn").addEventListener("click", async () => {

    try {
        const res = await fetch("../api/admin/logout.php", {
            method: "POST",
            credentials: "include"
        });

        const data = await res.json();

        if (data.success) {
            // kesin temiz yönlendirme
            window.location.href = "index.php";
        } else {
            alert("Çıkış başarısız");
        }

    } catch (err) {
        alert("Bağlantı hatası");
    }

});
</script>

</body>
</html>