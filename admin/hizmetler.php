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
async function loadServices() {
    const res = await fetch("../api/admin/service-list.php");
    const data = await res.json();

    const list = document.getElementById("list");
    list.innerHTML = "";

    data.data.forEach(item => {
        list.innerHTML += `
        <div class="bg-white p-4 rounded shadow flex gap-4 items-center">

            <div class="w-20 h-20">
                ${item.image_path ?
                    `<img src="../${item.image_path}" class="w-full h-full object-cover rounded">`
                    :
                    `<div class="bg-gray-200 w-full h-full rounded"></div>`
                }
            </div>

            <div class="flex-1">
                <h2 class="font-bold">${item.title}</h2>
                <p class="text-sm text-gray-500">${item.short_desc ?? ''}</p>
            </div>

            <div class="flex gap-2">
                <a href="hizmet-duzenle.php?id=${item.id}"
                   class="bg-yellow-500 px-3 py-1 text-white rounded">Düzenle</a>

                <button onclick="deleteService(${item.id})"
                        class="bg-red-500 px-3 py-1 text-white rounded">
                    Sil
                </button>
            </div>

        </div>`;
    });
}

async function deleteService(id) {
    if (!confirm("Silinsin mi?")) return;

    const fd = new FormData();
    fd.append("id", id);

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