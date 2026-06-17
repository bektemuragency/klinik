<?php
require_once __DIR__ . '/auth_check.php';
ob_start();
?>

<div class="max-w-5xl mx-auto space-y-6">

    <!-- HEADER -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-slate-950 via-blue-950 to-teal-900 p-6 md:p-8 text-white shadow-xl">

        <div class="absolute -top-24 -right-24 w-72 h-72 bg-white/10 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-24 -left-24 w-72 h-72 bg-teal-400/20 rounded-full blur-3xl"></div>

        <div class="relative flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">

            <div>
                <div class="inline-flex items-center gap-2 bg-white/10 border border-white/15 rounded-full px-3 py-1 text-xs font-semibold mb-4">
                    <span class="w-2 h-2 rounded-full bg-green-400"></span>
                    Hesap Güvenliği
                </div>

                <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight">
                    Şifre Değiştir
                </h1>

                <p class="text-blue-100 mt-2 max-w-2xl">
                    Admin hesabının şifresini güvenli şekilde güncelle. Yeni şifre en az 8 karakter olmalı.
                </p>
            </div>

            <div class="bg-white/10 border border-white/15 rounded-2xl p-5 min-w-[240px] backdrop-blur">
                <p class="text-xs text-blue-100 uppercase font-semibold tracking-wide">
                    Güvenlik Durumu
                </p>

                <div class="flex items-center gap-2 mt-3">
                    <span id="securityDot" class="w-3 h-3 rounded-full bg-green-400"></span>
                    <span id="securityText" class="text-sm font-bold">
                        Aktif
                    </span>
                </div>

                <p class="text-xs text-blue-100 mt-2">
                    CSRF koruması ile işlem yapılır.
                </p>
            </div>

        </div>

    </div>

    <div class="grid lg:grid-cols-3 gap-6">

        <!-- FORM -->
        <div class="lg:col-span-2 bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">

            <div class="p-6 border-b border-slate-100">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-2xl bg-blue-600 text-white flex items-center justify-center text-xl">
                        🔐
                    </div>

                    <div>
                        <h2 class="text-xl font-black text-slate-900">
                            Şifre Bilgileri
                        </h2>
                        <p class="text-sm text-slate-500 mt-1">
                            Mevcut şifreni gir ve yeni şifreni belirle.
                        </p>
                    </div>
                </div>
            </div>

            <form id="passwordForm" class="p-6 space-y-5">

                <div>
                    <label class="block text-xs text-slate-500 uppercase font-bold mb-2">
                        Mevcut Şifre
                    </label>

                    <div class="relative">
                        <input type="password"
                               name="current_password"
                               id="current_password"
                               class="w-full border border-slate-200 rounded-2xl px-4 py-3 pr-24 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               required>

                        <button type="button"
                                onclick="togglePassword('current_password', this)"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-xs font-bold text-slate-500 hover:text-slate-900">
                            Göster
                        </button>
                    </div>
                </div>

                <div>
                    <label class="block text-xs text-slate-500 uppercase font-bold mb-2">
                        Yeni Şifre
                    </label>

                    <div class="relative">
                        <input type="password"
                               name="new_password"
                               id="new_password"
                               class="w-full border border-slate-200 rounded-2xl px-4 py-3 pr-24 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               minlength="8"
                               required>

                        <button type="button"
                                onclick="togglePassword('new_password', this)"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-xs font-bold text-slate-500 hover:text-slate-900">
                            Göster
                        </button>
                    </div>

                    <div class="mt-3">
                        <div class="flex justify-between text-xs mb-1">
                            <span class="text-slate-500 font-semibold">Şifre Gücü</span>
                            <span id="strengthText" class="text-slate-500 font-bold">-</span>
                        </div>

                        <div class="w-full bg-slate-100 rounded-full h-3 overflow-hidden">
                            <div id="strengthBar" class="h-3 rounded-full bg-slate-300 transition-all duration-300" style="width: 0%"></div>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-xs text-slate-500 uppercase font-bold mb-2">
                        Yeni Şifre Tekrar
                    </label>

                    <div class="relative">
                        <input type="password"
                               name="new_password_confirm"
                               id="new_password_confirm"
                               class="w-full border border-slate-200 rounded-2xl px-4 py-3 pr-24 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               minlength="8"
                               required>

                        <button type="button"
                                onclick="togglePassword('new_password_confirm', this)"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-xs font-bold text-slate-500 hover:text-slate-900">
                            Göster
                        </button>
                    </div>

                    <p id="matchText" class="text-xs text-slate-400 mt-2">
                        Yeni şifre tekrarını gir.
                    </p>
                </div>

                <div id="message" class="hidden rounded-2xl px-4 py-3 text-sm font-semibold"></div>

                <div class="pt-2">
                    <button type="submit"
                            id="saveBtn"
                            class="w-full md:w-auto bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl text-sm font-bold transition disabled:opacity-60 disabled:cursor-not-allowed">
                        Şifreyi Güncelle
                    </button>
                </div>

            </form>

        </div>

        <!-- INFO -->
        <div class="space-y-6">

            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">

                <div class="p-6 border-b border-slate-100">
                    <div class="flex items-center gap-3">
                        <div class="w-11 h-11 rounded-2xl bg-green-600 text-white flex items-center justify-center text-xl">
                            ✅
                        </div>

                        <div>
                            <h2 class="text-xl font-black text-slate-900">
                                Önerilen Şifre
                            </h2>
                            <p class="text-sm text-slate-500 mt-1">
                                Güçlü şifre için ipuçları.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="p-6 space-y-3 text-sm text-slate-600">

                    <div class="flex gap-2">
                        <span class="text-green-600 font-black">✓</span>
                        <span>En az 8 karakter kullan.</span>
                    </div>

                    <div class="flex gap-2">
                        <span class="text-green-600 font-black">✓</span>
                        <span>Büyük/küçük harf ekle.</span>
                    </div>

                    <div class="flex gap-2">
                        <span class="text-green-600 font-black">✓</span>
                        <span>Rakam ve özel karakter kullan.</span>
                    </div>

                    <div class="flex gap-2">
                        <span class="text-green-600 font-black">✓</span>
                        <span>Eski şifrenle aynı yapma.</span>
                    </div>

                </div>

            </div>

            <div class="bg-yellow-50 border border-yellow-100 rounded-3xl p-5">
                <p class="text-sm font-black text-yellow-900">
                    Not
                </p>

                <p class="text-sm text-yellow-800 mt-1 leading-relaxed">
                    Şifre değiştikten sonra güvenlik için tekrar giriş yapman gerekebilir.
                </p>
            </div>

        </div>

    </div>

</div>

<script>
const form = document.getElementById("passwordForm");
const msg = document.getElementById("message");
const saveBtn = document.getElementById("saveBtn");

const newPassword = document.getElementById("new_password");
const confirmPassword = document.getElementById("new_password_confirm");

const strengthBar = document.getElementById("strengthBar");
const strengthText = document.getElementById("strengthText");
const matchText = document.getElementById("matchText");

function togglePassword(inputId, btn) {
    const input = document.getElementById(inputId);

    if (input.type === "password") {
        input.type = "text";
        btn.innerText = "Gizle";
    } else {
        input.type = "password";
        btn.innerText = "Göster";
    }
}

function showMessage(type, text) {
    msg.className = type === "success"
        ? "rounded-2xl px-4 py-3 text-sm font-semibold bg-green-50 border border-green-100 text-green-700"
        : "rounded-2xl px-4 py-3 text-sm font-semibold bg-red-50 border border-red-100 text-red-700";

    msg.innerText = text;
    msg.classList.remove("hidden");
}

function getPasswordStrength(password) {
    let score = 0;

    if (password.length >= 8) score++;
    if (password.length >= 12) score++;
    if (/[a-z]/.test(password) && /[A-Z]/.test(password)) score++;
    if (/\d/.test(password)) score++;
    if (/[^a-zA-Z0-9]/.test(password)) score++;

    return score;
}

function updateStrength() {
    const value = newPassword.value;
    const score = getPasswordStrength(value);

    let width = 0;
    let label = "-";
    let cls = "h-3 rounded-full bg-slate-300 transition-all duration-300";

    if (!value) {
        width = 0;
        label = "-";
    } else if (score <= 1) {
        width = 25;
        label = "Zayıf";
        cls = "h-3 rounded-full bg-red-500 transition-all duration-300";
    } else if (score <= 3) {
        width = 60;
        label = "Orta";
        cls = "h-3 rounded-full bg-yellow-500 transition-all duration-300";
    } else {
        width = 100;
        label = "Güçlü";
        cls = "h-3 rounded-full bg-green-500 transition-all duration-300";
    }

    strengthBar.style.width = width + "%";
    strengthBar.className = cls;
    strengthText.innerText = label;
}

function updateMatch() {
    if (!confirmPassword.value) {
        matchText.className = "text-xs text-slate-400 mt-2";
        matchText.innerText = "Yeni şifre tekrarını gir.";
        return;
    }

    if (newPassword.value === confirmPassword.value) {
        matchText.className = "text-xs text-green-600 mt-2 font-semibold";
        matchText.innerText = "Şifreler eşleşiyor.";
    } else {
        matchText.className = "text-xs text-red-600 mt-2 font-semibold";
        matchText.innerText = "Şifreler eşleşmiyor.";
    }
}

newPassword.addEventListener("input", () => {
    updateStrength();
    updateMatch();
});

confirmPassword.addEventListener("input", updateMatch);

form.addEventListener("submit", async (e) => {
    e.preventDefault();

    msg.classList.add("hidden");

    if (newPassword.value !== confirmPassword.value) {
        showMessage("error", "Yeni şifreler eşleşmiyor");
        return;
    }

    saveBtn.disabled = true;
    saveBtn.innerText = "Güncelleniyor...";

    const fd = new FormData(form);
    fd.append("csrf_token", window.CSRF_TOKEN || "");

    try {
        const res = await fetch("../api/admin/change-password.php", {
            method: "POST",
            body: fd
        });

        const data = await res.json();

        if (data.success) {
            showMessage("success", data.message || "Şifre güncellendi");
            form.reset();
            updateStrength();
            updateMatch();
        } else {
            showMessage("error", data.message || "İşlem başarısız");
        }

    } catch (err) {
        showMessage("error", "Sunucu hatası");
    }

    saveBtn.disabled = false;
    saveBtn.innerText = "Şifreyi Güncelle";
});
</script>

<?php
$content = ob_get_clean();
require __DIR__ . '/layout.php';
?>