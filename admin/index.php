<?php
require_once __DIR__ . '/../includes/config.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Zaten loginse dashboard'a at
if (!empty($_SESSION[ADMIN_SESSION_NAME])) {
    header("Location: dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Admin Giriş - KlinikCMS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-slate-100 text-slate-800 antialiased">

<div class="min-h-screen grid lg:grid-cols-2">

    <!-- LEFT CORPORATE PANEL -->
    <section class="hidden lg:flex relative bg-slate-950 text-white overflow-hidden">

        <div class="absolute inset-0 bg-gradient-to-br from-slate-950 via-slate-900 to-blue-950"></div>
        <div class="absolute -top-32 -right-32 w-96 h-96 bg-blue-500/10 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-32 -left-32 w-96 h-96 bg-teal-400/10 rounded-full blur-3xl"></div>

        <div class="relative z-10 flex flex-col justify-between w-full p-12">

            <div>
                <div class="flex items-center gap-3">

                    <div class="w-12 h-12 rounded-2xl bg-white text-slate-950 flex items-center justify-center font-black text-xl">
                        K
                    </div>

                    <div>
                        <h1 class="text-2xl font-black tracking-tight">
                            KlinikCMS
                        </h1>

                        <p class="text-sm text-slate-400">
                            Kurumsal Yönetim Paneli
                        </p>
                    </div>

                </div>
            </div>

            <div class="max-w-xl">

                <p class="inline-flex items-center gap-2 bg-white/10 border border-white/10 rounded-full px-4 py-2 text-sm font-semibold text-slate-200 mb-6">
                    Güvenli Admin Erişimi
                </p>

                <h2 class="text-4xl xl:text-5xl font-black tracking-tight leading-tight">
                    Klinik süreçlerinizi tek panelden yönetin.
                </h2>

                <p class="text-slate-300 mt-5 leading-7 text-lg">
                    Hizmetler, doktorlar, randevular ve klinik ayarları için sade, güvenli ve merkezi yönetim ekranı.
                </p>

                <div class="grid grid-cols-3 gap-4 mt-10">

                    <div class="bg-white/5 border border-white/10 rounded-2xl p-4">
                        <p class="text-2xl font-black">01</p>
                        <p class="text-sm text-slate-400 mt-1">Hizmet Yönetimi</p>
                    </div>

                    <div class="bg-white/5 border border-white/10 rounded-2xl p-4">
                        <p class="text-2xl font-black">02</p>
                        <p class="text-sm text-slate-400 mt-1">Randevu Takibi</p>
                    </div>

                    <div class="bg-white/5 border border-white/10 rounded-2xl p-4">
                        <p class="text-2xl font-black">03</p>
                        <p class="text-sm text-slate-400 mt-1">Klinik Ayarları</p>
                    </div>

                </div>

            </div>

            <div class="text-sm text-slate-500">
                © <?= date('Y') ?> KlinikCMS. Tüm hakları saklıdır.
            </div>

        </div>

    </section>

    <!-- LOGIN AREA -->
    <section class="flex items-center justify-center p-6 lg:p-12">

        <div class="w-full max-w-md">

            <!-- MOBILE BRAND -->
            <div class="lg:hidden mb-8 text-center">

                <div class="mx-auto w-14 h-14 rounded-2xl bg-slate-950 text-white flex items-center justify-center font-black text-xl">
                    K
                </div>

                <h1 class="text-2xl font-black text-slate-900 mt-4">
                    KlinikCMS
                </h1>

                <p class="text-sm text-slate-500 mt-1">
                    Kurumsal Yönetim Paneli
                </p>

            </div>

            <div class="bg-white border border-slate-200 rounded-3xl shadow-xl shadow-slate-200/70 overflow-hidden">

                <div class="px-8 pt-8 pb-6 border-b border-slate-100">

                    <p class="text-xs uppercase tracking-widest font-black text-blue-700 mb-3">
                        Admin Panel
                    </p>

                    <h2 class="text-2xl font-black text-slate-950">
                        Hesabınıza giriş yapın
                    </h2>

                    <p class="text-sm text-slate-500 mt-2 leading-6">
                        Devam etmek için kayıtlı admin email adresinizi ve şifrenizi girin.
                    </p>

                </div>

                <form id="loginForm" class="p-8 space-y-5">

                    <div>
                        <label for="email" class="block text-xs text-slate-600 uppercase font-black mb-2">
                            Email Adresi
                        </label>

                        <input type="email"
                               name="email"
                               id="email"
                               placeholder="admin@klinik.com"
                               autocomplete="email"
                               required
                               class="w-full border border-slate-300 rounded-xl px-4 py-3 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600">
                    </div>

                    <div>
                        <label for="password" class="block text-xs text-slate-600 uppercase font-black mb-2">
                            Şifre
                        </label>

                        <div class="relative">
                            <input type="password"
                                   name="password"
                                   id="password"
                                   placeholder="Şifrenizi girin"
                                   autocomplete="current-password"
                                   required
                                   class="w-full border border-slate-300 rounded-xl px-4 py-3 pr-24 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600">

                            <button type="button"
                                    onclick="togglePassword()"
                                    id="toggleBtn"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 text-xs font-bold text-slate-500 hover:text-slate-900">
                                Göster
                            </button>
                        </div>
                    </div>

                    <div id="msg" class="hidden rounded-xl px-4 py-3 text-sm font-semibold"></div>

                    <button type="submit"
                            id="loginBtn"
                            class="w-full bg-slate-950 hover:bg-slate-800 text-white px-5 py-3 rounded-xl text-sm font-black transition disabled:opacity-60 disabled:cursor-not-allowed">
                        Giriş Yap
                    </button>

                    <div class="pt-2 text-center">
                        <p class="text-xs text-slate-400">
                            Yetkisiz erişim girişimleri kayıt altına alınabilir.
                        </p>
                    </div>

                </form>

            </div>

            <div class="mt-6 bg-white border border-slate-200 rounded-2xl p-4">

                <div class="flex items-start gap-3">

                    <div class="w-9 h-9 rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center font-black shrink-0">
                        i
                    </div>

                    <div>
                        <p class="text-sm font-black text-slate-900">
                            Güvenli Oturum
                        </p>

                        <p class="text-xs text-slate-500 mt-1 leading-5">
                            Giriş sonrası oturumunuz güvenli şekilde başlatılır. İşiniz bittiğinde panelden çıkış yapmanız önerilir.
                        </p>
                    </div>

                </div>

            </div>

        </div>

    </section>

</div>

<script>
const form = document.getElementById("loginForm");
const msg = document.getElementById("msg");
const loginBtn = document.getElementById("loginBtn");
const passwordInput = document.getElementById("password");
const toggleBtn = document.getElementById("toggleBtn");

function togglePassword() {
    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        toggleBtn.innerText = "Gizle";
    } else {
        passwordInput.type = "password";
        toggleBtn.innerText = "Göster";
    }
}

function showMessage(type, text) {
    msg.className = type === "success"
        ? "rounded-xl px-4 py-3 text-sm font-semibold bg-green-50 border border-green-100 text-green-700"
        : "rounded-xl px-4 py-3 text-sm font-semibold bg-red-50 border border-red-100 text-red-700";

    msg.innerText = text;
    msg.classList.remove("hidden");
}

form.addEventListener("submit", async (e) => {
    e.preventDefault();

    msg.classList.add("hidden");

    loginBtn.disabled = true;
    loginBtn.innerText = "Giriş yapılıyor...";

    const formData = new FormData(form);

    try {
        const res = await fetch("../api/admin/login.php", {
            method: "POST",
            credentials: "include",
            body: formData
        });

        const data = await res.json();

        if (data.success) {
            window.location.href = "dashboard.php";
            return;
        }

        showMessage("error", data.message || "Email veya şifre hatalı");

    } catch (err) {
        showMessage("error", "Sunucu bağlantı hatası");
    }

    loginBtn.disabled = false;
    loginBtn.innerText = "Giriş Yap";
});
</script>

</body>
</html>