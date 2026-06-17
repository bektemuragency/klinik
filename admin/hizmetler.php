<?php
require_once __DIR__ . '/auth_check.php';
ob_start();
?>

<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold">Hizmetler</h1>

    <a href="hizmet-ekle.php"
       class="bg-blue-600 text-white px-4 py-2 rounded">
        + Yeni Hizmet
    </a>
</div>

<div id="list" class="space-y-4"></div>

<script>
function esc(value) {
    return String(value ?? '')
        .replaceAll('&', '&amp;')
        .replaceAll('<', '&lt;')
        .replaceAll('>', '&gt;')
        .replaceAll('"', '&quot;')
        .replaceAll("'", '&#039;');
}

function safeId(value) {
    return Number.parseInt(value, 10) || 0;
}

async function loadServices() {
    const res = await fetch("../api/admin/service-list.php");
    const data = await res.json();

    const list = document.getElementById("list");
    list.innerHTML = "";

    if (!data.success || !Array.isArray(data.data)) {
        list.innerHTML = `
            <div class="bg-red-100 text-red-700 p-4 rounded">
                Hizmetler yüklenemedi.
            </div>
        `;
        return;
    }

    data.data.forEach(item => {
        const id = safeId(item.id);
        const title = esc(item.title);
        const shortDesc = esc(item.short_desc);
        const imagePath = esc(item.image_path);

        list.innerHTML += `
        <div class="bg-white p-4 rounded shadow flex gap-4 items-center">

            <div class="w-20 h-20">
                ${imagePath ?
                    `<img src="../${imagePath}" class="w-full h-full object-cover rounded" alt="${title}">`
                    :
                    `<div class="bg-gray-200 w-full h-full rounded"></div>`
                }
            </div>

            <div class="flex-1">
                <h2 class="font-bold">${title}</h2>
                <p class="text-sm text-gray-500">${shortDesc}</p>
            </div>

            <div class="flex gap-2">
                <a href="hizmet-duzenle.php?id=${id}"
                   class="bg-yellow-500 px-3 py-1 text-white rounded">Düzenle</a>

                <button onclick="deleteService(${id})"
                        class="bg-red-500 px-3 py-1 text-white rounded">
                    Sil
                </button>
            </div>

        </div>`;
    });
}

async function deleteService(id) {
    id = safeId(id);

    if (!id) {
        alert("Geçersiz ID");
        return;
    }

    if (!confirm("Silinsin mi?")) return;

    const fd = new FormData();
    fd.append("id", id);
    fd.append("csrf_token", window.CSRF_TOKEN || "");

    await fetch("../api/admin/service-delete.php", {
        method: "POST",
        body: fd
    });

    loadServices();
}

loadServices();
</script>

<?php
$content = ob_get_clean();
require __DIR__ . '/layout.php';
?>