<?php
require_once __DIR__ . '/auth_check.php';
require_once __DIR__ . '/../includes/functions.php';

$csrfToken = csrfToken();
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        window.CSRF_TOKEN = "<?= htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8') ?>";
    </script>
</head>

<body class="bg-gray-100">

<div class="flex h-screen">

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

            <a href="doktorlar.php" class="block p-2 rounded hover:bg-gray-700">
                🩺 Doktorlar
            </a>

            <a href="randevular.php" class="block p-2 rounded hover:bg-gray-700">
                📅 Randevular
            </a>

            <a href="ayarlar.php" class="block p-2 rounded hover:bg-gray-700">
                ⚙️ Ayarlar
            </a>

        </nav>

        <div class="p-4 border-t border-gray-700">
            <button
                id="logoutBtn"
                class="text-red-400 hover:text-red-200 w-full text-left"
            >
                🚪 Çıkış
            </button>
        </div>

    </aside>

    <div class="flex-1 flex flex-col">

        <header class="bg-white shadow p-4 flex justify-between">
            <div class="font-semibold">Admin Panel</div>

            <div class="text-sm text-gray-500">
                <?= htmlspecialchars($_SESSION[ADMIN_SESSION_NAME]['name'] ?? '', ENT_QUOTES, 'UTF-8') ?>
            </div>
        </header>

        <main class="p-6 overflow-auto flex-1">
            <?= $content ?? '' ?>
        </main>

    </div>

</div>

<script>
document.getElementById("logoutBtn").addEventListener("click", async () => {
    try {
        const fd = new FormData();
        fd.append("csrf_token", window.CSRF_TOKEN);

        const res = await fetch("../api/admin/logout.php", {
            method: "POST",
            credentials: "include",
            body: fd
        });

        const data = await res.json();

        if (data.success) {
            window.location.href = "index.php";
        } else {
            alert(data.message || "Çıkış başarısız");
        }

    } catch (err) {
        alert("Bağlantı hatası");
    }
});
</script>

</body>
</html>