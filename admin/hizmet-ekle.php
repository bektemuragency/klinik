<?php
require_once __DIR__ . '/auth_check.php';
ob_start();
?>

<div class="max-w-3xl mx-auto">

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Yeni Hizmet Ekle</h1>

        <a href="hizmetler.php"
           class="bg-gray-600 text-white px-4 py-2 rounded">
            Listeye Dön
        </a>
    </div>

    <div class="bg-white rounded shadow p-6">

        <form id="serviceForm" enctype="multipart/form-data">

            <div class="mb-4">
                <label class="block mb-2 font-medium">Hizmet Başlığı</label>
                <input type="text" name="title" class="w-full border rounded p-3" required>
            </div>

            <div class="mb-4">
                <label class="block mb-2 font-medium">Kısa Açıklama</label>
                <textarea name="short_desc" class="w-full border rounded p-3"></textarea>
            </div>

            <div class="mb-4">
                <label class="block mb-2 font-medium">Detay</label>
                <textarea name="content" class="w-full border rounded p-3"></textarea>
            </div>

            <div class="mb-4">
                <label class="block mb-2 font-medium">Görsel</label>
                <input type="file" name="image" class="w-full border rounded p-3">
            </div>

            <div class="mb-4">
                <label class="block mb-2 font-medium">Durum</label>
                <select name="is_active" class="w-full border rounded p-3">
                    <option value="1">Aktif</option>
                    <option value="0">Pasif</option>
                </select>
            </div>

            <button class="bg-blue-600 text-white px-5 py-2 rounded">
                Kaydet
            </button>

        </form>

        <div id="message" class="mt-4 text-sm"></div>

    </div>
</div>

<script>
document.getElementById('serviceForm').addEventListener('submit', async (e) => {
    e.preventDefault();

    const fd = new FormData(e.target);
    fd.append("csrf_token", window.CSRF_TOKEN || "");

    const res = await fetch('../api/admin/service-create.php', {
        method: 'POST',
        body: fd
    });

    const data = await res.json();

    const msg = document.getElementById('message');

    if (data.success) {
        msg.className = "text-green-600 mt-4";
        msg.innerText = data.message;

        setTimeout(() => location.href = "hizmetler.php", 800);
    } else {
        msg.className = "text-red-600 mt-4";
        msg.innerText = data.message;
    }
});
</script>

<?php
$content = ob_get_clean();
require __DIR__ . '/layout.php';
?>