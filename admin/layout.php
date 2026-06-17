<?php
require_once __DIR__ . '/auth_check.php';
require_once __DIR__ . '/../includes/functions.php';

$csrfToken = csrfToken();

$currentPage = basename($_SERVER['PHP_SELF']);
$adminName = $_SESSION[ADMIN_SESSION_NAME]['name'] ?? 'Admin';

function isActiveMenu(string $page, string $currentPage): string
{
    return $page === $currentPage
        ? 'bg-white text-slate-950 shadow-sm'
        : 'text-slate-300 hover:bg-white/10 hover:text-white';
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel - KlinikCMS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        window.CSRF_TOKEN = "<?= htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8') ?>";
    </script>
</head>

<body class="bg-slate-100 text-slate-800 antialiased">

<div class="min-h-screen">

    <!-- SIDEBAR -->
    <aside class="fixed left-0 top-0 h-screen w-72 bg-slate-950 text-white flex flex-col z-40 overflow-hidden">

        <!-- LOGO -->
        <div class="p-4 border-b border-white/10 shrink-0">

            <a href="dashboard.php" class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-gradient-to-br from-blue-500 to-teal-400 flex items-center justify-center text-xl font-black shadow-lg">
                    K
                </div>

                <div>
                    <div class="text-xl font-black leading-none">
                        KlinikCMS
                    </div>
                    <div class="text-xs text-slate-400 mt-1">
                        Yönetim Paneli
                    </div>
                </div>
            </a>

        </div>

        <!-- USER -->
        <div class="p-3 border-b border-white/10 shrink-0">

            <div class="bg-white/5 border border-white/10 rounded-2xl p-3">

                <p class="text-xs text-slate-400 uppercase font-bold">
                    Oturum
                </p>

                <div class="flex items-center gap-3 mt-2">

                    <div class="w-9 h-9 rounded-xl bg-white text-slate-950 flex items-center justify-center font-black">
                        <?= htmlspecialchars(mb_substr($adminName, 0, 1, 'UTF-8'), ENT_QUOTES, 'UTF-8') ?>
                    </div>

                    <div class="min-w-0">
                        <p class="font-bold text-sm truncate">
                            <?= htmlspecialchars($adminName, ENT_QUOTES, 'UTF-8') ?>
                        </p>
                        <p class="text-xs text-slate-400">
                            Admin
                        </p>
                    </div>

                </div>

            </div>

        </div>

        <!-- NAV -->
        <nav class="flex-1 p-3 space-y-1.5 overflow-hidden">

            <a href="dashboard.php"
               class="flex items-center gap-3 px-4 py-2.5 rounded-2xl text-sm font-bold transition <?= isActiveMenu('dashboard.php', $currentPage) ?>">
                <span class="text-lg">📊</span>
                <span>Dashboard</span>
            </a>

            <a href="hizmetler.php"
               class="flex items-center gap-3 px-4 py-2.5 rounded-2xl text-sm font-bold transition <?= isActiveMenu('hizmetler.php', $currentPage) ?>">
                <span class="text-lg">🧾</span>
                <span>Hizmetler</span>
            </a>

            <a href="doktorlar.php"
               class="flex items-center gap-3 px-4 py-2.5 rounded-2xl text-sm font-bold transition <?= isActiveMenu('doktorlar.php', $currentPage) ?>">
                <span class="text-lg">🩺</span>
                <span>Doktorlar</span>
            </a>

            <a href="randevular.php"
               class="flex items-center gap-3 px-4 py-2.5 rounded-2xl text-sm font-bold transition <?= isActiveMenu('randevular.php', $currentPage) ?>">
                <span class="text-lg">📅</span>
                <span>Randevular</span>
            </a>

            <a href="ayarlar.php"
               class="flex items-center gap-3 px-4 py-2.5 rounded-2xl text-sm font-bold transition <?= isActiveMenu('ayarlar.php', $currentPage) ?>">
                <span class="text-lg">⚙️</span>
                <span>Ayarlar</span>
            </a>

            <a href="aktivite-loglari.php"
               class="flex items-center gap-3 px-4 py-2.5 rounded-2xl text-sm font-bold transition <?= isActiveMenu('aktivite-loglari.php', $currentPage) ?>">
                <span class="text-lg">🕒</span>
                <span>Aktivite Logları</span>
            </a>

            <a href="sifre-degistir.php"
               class="flex items-center gap-3 px-4 py-2.5 rounded-2xl text-sm font-bold transition <?= isActiveMenu('sifre-degistir.php', $currentPage) ?>">
                <span class="text-lg">🔐</span>
                <span>Şifre Değiştir</span>
            </a>

        </nav>

        <!-- LOGOUT -->
        <div class="p-3 border-t border-white/10 shrink-0">

            <button id="logoutBtn"
                    class="w-full flex items-center justify-center gap-2 bg-red-500/10 hover:bg-red-500/20 border border-red-400/20 text-red-300 px-4 py-2.5 rounded-2xl text-sm font-bold transition disabled:opacity-60 disabled:cursor-not-allowed">
                <span>🚪</span>
                <span id="logoutText">Çıkış Yap</span>
            </button>

        </div>

    </aside>

    <!-- MAIN AREA -->
    <div class="ml-72 min-h-screen">

        <!-- TOPBAR -->
        <header class="bg-white border-b border-slate-200">

            <div class="px-4 md:px-6 py-4 flex items-center justify-between gap-4">

                <div>
                    <p class="text-sm font-black text-slate-900">
                        Admin Panel
                    </p>
                    <p class="text-xs text-slate-500">
                        KlinikCMS yönetim ekranı
                    </p>
                </div>

                <div class="flex items-center gap-3">

                    <a href="../index.php"
                       target="_blank"
                       class="hidden sm:inline-flex items-center gap-2 bg-slate-100 hover:bg-slate-200 text-slate-700 px-4 py-2 rounded-xl text-sm font-bold transition">
                        Siteyi Gör →
                    </a>

                    <div class="flex items-center gap-3 bg-slate-50 border border-slate-100 rounded-2xl px-3 py-2">

                        <div class="w-9 h-9 rounded-xl bg-slate-900 text-white flex items-center justify-center font-black text-sm">
                            <?= htmlspecialchars(mb_substr($adminName, 0, 1, 'UTF-8'), ENT_QUOTES, 'UTF-8') ?>
                        </div>

                        <div class="hidden md:block min-w-0">
                            <p class="text-sm font-bold text-slate-900 truncate max-w-[180px]">
                                <?= htmlspecialchars($adminName, ENT_QUOTES, 'UTF-8') ?>
                            </p>
                            <p class="text-xs text-slate-500">
                                Yetkili kullanıcı
                            </p>
                        </div>

                    </div>

                </div>

            </div>

        </header>

        <!-- CONTENT -->
        <main class="p-4 md:p-6">
            <?= $content ?? '' ?>
        </main>

    </div>

</div>

<script>
document.getElementById("logoutBtn").addEventListener("click", async () => {
    if (!confirm("Çıkış yapmak istiyor musun?")) {
        return;
    }

    const btn = document.getElementById("logoutBtn");
    const text = document.getElementById("logoutText");

    btn.disabled = true;
    text.innerText = "Çıkış yapılıyor...";

    try {
        const fd = new FormData();
        fd.append("csrf_token", window.CSRF_TOKEN || "");

        const res = await fetch("../api/admin/logout.php", {
            method: "POST",
            credentials: "include",
            body: fd
        });

        const data = await res.json();

        if (data.success) {
            window.location.href = "index.php";
            return;
        }

        alert(data.message || "Çıkış başarısız");

    } catch (err) {
        alert("Bağlantı hatası");
    }

    btn.disabled = false;
    text.innerText = "Çıkış Yap";
});
</script>

</body>
</html>