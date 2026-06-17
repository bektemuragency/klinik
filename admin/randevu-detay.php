<?php
require_once __DIR__ . '/auth_check.php';
ob_start();
?>

<div class="max-w-5xl mx-auto">

    <div class="flex justify-between mb-6">
        <h1 class="text-3xl font-bold">Randevu Detayı</h1>

        <a href="randevular.php" class="bg-gray-600 text-white px-4 py-2 rounded">
            Listeye Dön
        </a>
    </div>

    <div id="loading">Yükleniyor...</div>

    <div id="content" class="hidden bg-white p-6 rounded shadow">

        <div class="grid md:grid-cols-2 gap-4">
            <p><b>Ad:</b> <span id="full_name"></span></p>
            <p><b>Telefon:</b> <span id="phone"></span></p>
            <p><b>Tarih:</b> <span id="appointment_date"></span></p>
            <p><b>Saat:</b> <span id="appointment_time"></span></p>
            <p><b>Hizmet:</b> <span id="service_title"></span></p>
            <p><b>Durum:</b> <span id="status"></span></p>
        </div>

        <hr class="my-4">

        <textarea id="admin_note" class="w-full border p-2" placeholder="Admin notu..."></textarea>

        <div class="flex gap-3 mt-4">
            <button onclick="updateStatus('confirmed')" class="bg-green-600 text-white px-3 py-1 rounded">
                Onay
            </button>

            <button onclick="updateStatus('cancelled')" class="bg-red-600 text-white px-3 py-1 rounded">
                İptal
            </button>
        </div>

    </div>

</div>

<script>
const id = new URLSearchParams(window.location.search).get('id');

async function load() {
    const res = await fetch('../api/admin/appt-detail.php?id=' + id);
    const json = await res.json();

    if (!json.success) {
        alert(json.message || "Hata");
        return;
    }

    const a = json.data;

    document.getElementById('full_name').innerText = a.full_name ?? '-';
    document.getElementById('phone').innerText = a.phone ?? '-';
    document.getElementById('appointment_date').innerText = a.appointment_date ?? '-';
    document.getElementById('appointment_time').innerText = a.appointment_time ?? '-';
    document.getElementById('service_title').innerText = a.service_title ?? '-';
    document.getElementById('status').innerText = a.status ?? '-';
    document.getElementById('admin_note').value = a.admin_note ?? '';

    document.getElementById('loading').style.display = "none";
    document.getElementById('content').classList.remove("hidden");
}

async function updateStatus(status) {
    const confirmText = status === 'confirmed'
        ? "Randevuyu ONAYLAMAK istiyor musun?"
        : "Randevuyu İPTAL etmek istiyor musun?";

    if (!confirm(confirmText)) return;

    try {
        const res = await fetch('../api/admin/appt-status.php', {
            method: 'POST',
            body: new URLSearchParams({
                id: id,
                status: status,
                admin_note: document.getElementById('admin_note').value,
                csrf_token: window.CSRF_TOKEN || ""
            })
        });

        const result = await res.json().catch(() => ({}));

        if (result.success === false) {
            alert(result.message || "İşlem başarısız");
            return;
        }

        alert("Durum başarıyla güncellendi ✔");

        load();

    } catch (err) {
        alert("Sunucu hatası oluştu ❌");
    }
}

load();
</script>

<?php
$content = ob_get_clean();
require __DIR__ . '/layout.php';
?>