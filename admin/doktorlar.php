<?php
require_once __DIR__ . '/auth_check.php';
ob_start();
?>

<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold">Doktorlar</h1>

    <a href="doktor-ekle.php"
       class="bg-blue-600 text-white px-4 py-2 rounded">
        + Yeni Doktor
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

async function loadDoctors() {
    const res = await fetch("../api/admin/doctor-list.php");
    const data = await res.json();

    const list = document.getElementById("list");
    list.innerHTML = "";

    if (!data.success || !Array.isArray(data.data)) {
        list.innerHTML = `
            <div class="bg-red-100 text-red-700 p-4 rounded">
                Doktorlar yüklenemedi.
            </div>
        `;
        return;
    }

    data.data.forEach(item => {
        const id = safeId(item.id);
        const name = esc(item.name);
        const title = esc(item.title);
        const specialty = esc(item.specialty);
        const image = esc(item.image);

        const subtitle = `${title}${specialty ? ' · ' + specialty : ''}`;

        list.innerHTML += `
        <div class="bg-white p-4 rounded shadow flex gap-4 items-center">

            <div class="w-20 h-20">
                ${image ?
                    `<img src="../${image}" class="w-full h-full object-cover rounded" alt="${name}">`
                    :
                    `<div class="bg-gray-200 w-full h-full rounded"></div>`
                }
            </div>

            <div class="flex-1">
                <h2 class="font-bold">${name}</h2>
                <p class="text-sm text-gray-500">${subtitle}</p>
            </div>

            <div class="flex gap-2">
                <a href="doktor-duzenle.php?id=${id}"
                   class="bg-yellow-500 px-3 py-1 text-white rounded">Düzenle</a>

                <button onclick="deleteDoctor(${id})"
                        class="bg-red-500 px-3 py-1 text-white rounded">
                    Sil
                </button>
            </div>

        </div>`;
    });
}

async function deleteDoctor(id) {
    id = safeId(id);

    if (!id) {
        alert("Geçersiz ID");
        return;
    }

    if (!confirm("Silinsin mi?")) return;

    const fd = new FormData();
    fd.append("id", id);
    fd.append("csrf_token", window.CSRF_TOKEN || "");

    await fetch("../api/admin/doctor-delete.php", {
        method: "POST",
        body: fd
    });

    loadDoctors();
}

loadDoctors();
</script>

<?php
$content = ob_get_clean();
require __DIR__ . '/layout.php';
?>