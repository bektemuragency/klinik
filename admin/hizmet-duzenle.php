<?php
require_once __DIR__ . '/auth_check.php';
ob_start();
?>

<div class="max-w-3xl mx-auto">

    <h1 class="text-2xl font-bold mb-4">Hizmet Düzenle</h1>

    <div id="loading">Yükleniyor...</div>

    <form id="editForm" class="bg-white p-6 rounded shadow hidden" enctype="multipart/form-data">

        <input type="hidden" name="id" id="id">

        <div class="mb-4">
            <label>Başlık</label>
            <input type="text" name="title" id="title" class="w-full border p-2 rounded">
        </div>

        <div class="mb-4">
            <label>Kısa Açıklama</label>
            <textarea name="short_desc" id="short_desc" class="w-full border p-2 rounded"></textarea>
        </div>

        <div class="mb-4">
            <label>Detay</label>
            <textarea name="content" id="content" class="w-full border p-2 rounded"></textarea>
        </div>

        <div class="mb-4">
            <label>Görsel</label>
            <input type="file" name="image" class="w-full border p-2 rounded">
            <img id="preview" class="mt-2 w-40 hidden">
        </div>

        <div class="mb-4">
            <label>Durum</label>
            <select name="is_active" id="is_active" class="w-full border p-2 rounded">
                <option value="1">Aktif</option>
                <option value="0">Pasif</option>
            </select>
        </div>

        <button class="bg-blue-600 text-white px-4 py-2 rounded">
            Güncelle
        </button>

    </form>
</div>

<script>
const id = new URLSearchParams(window.location.search).get("id");

async function load() {
    const res = await fetch("../api/admin/service-list.php");
    const data = await res.json();

    const item = data.data.find(x => x.id == id);

    if (!item) return alert("Bulunamadı");

    document.getElementById("id").value = item.id;
    document.getElementById("title").value = item.title;
    document.getElementById("short_desc").value = item.short_desc ?? '';
    document.getElementById("content").value = item.content ?? '';
    document.getElementById("is_active").value = item.is_active;

    if (item.image_path) {
        const img = document.getElementById("preview");
        img.src = "../" + item.image_path;
        img.classList.remove("hidden");
    }

    document.getElementById("loading").style.display = "none";
    document.getElementById("editForm").classList.remove("hidden");
}

load();

document.getElementById("editForm").addEventListener("submit", async (e) => {
    e.preventDefault();

    const res = await fetch("../api/admin/service-update.php", {
        method: "POST",
        body: new FormData(e.target)
    });

    const data = await res.json();

    alert(data.message);

    if (data.success) {
        location.href = "hizmetler.php";
    }
});
</script>

<?php
$content = ob_get_clean();
require __DIR__ . '/layout.php';
?>