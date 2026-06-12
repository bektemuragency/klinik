<?php
require_once __DIR__ . '/auth_check.php';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Hizmetler</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

<div class="p-6">

    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Hizmetler</h1>

        <a href="hizmet-ekle.php" class="bg-blue-600 text-white px-4 py-2 rounded">
            + Yeni Hizmet
        </a>
    </div>

    <div id="list" class="space-y-3"></div>

</div>

<script>

async function loadServices() {

    const res = await fetch("../api/admin/service-list.php");
    const data = await res.json();

    const list = document.getElementById("list");
    list.innerHTML = "";

    if (!data.success) return;

    data.data.forEach(item => {

        list.innerHTML += `
            <div class="bg-white p-4 rounded shadow flex justify-between items-center">

                <div>
                    <h2 class="font-bold">${item.title}</h2>
                    <p class="text-gray-500 text-sm">${item.description ?? ''}</p>
                </div>

                <div class="flex gap-2">

                    <a href="hizmet-duzenle.php?id=${item.id}"
                       class="bg-yellow-500 text-white px-3 py-1 rounded">
                        Düzenle
                    </a>

                    <button onclick="deleteService(${item.id})"
                        class="bg-red-500 text-white px-3 py-1 rounded">
                        Sil
                    </button>

                </div>

            </div>
        `;
    });
}

async function deleteService(id) {

    if (!confirm("Silmek istiyor musun?")) return;

    const formData = new FormData();
    formData.append("id", id);

    const res = await fetch("../api/admin/service-delete.php", {
        method: "POST",
        body: formData
    });

    const data = await res.json();

    if (data.success) {
        loadServices();
    } else {
        alert(data.message);
    }
}

loadServices();

</script>

</body>
</html>