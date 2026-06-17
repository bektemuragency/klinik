<?php
require_once __DIR__ . '/auth_check.php';
ob_start();
?>

<div class="max-w-3xl mx-auto">

    <h1 class="text-2xl font-bold mb-4">Doktor Düzenle</h1>

    <div id="loading">Yükleniyor...</div>

    <form id="editForm" class="bg-white p-6 rounded shadow hidden" enctype="multipart/form-data">

        <input type="hidden" name="id" id="id">

        <div class="mb-4">
            <label>Ad Soyad</label>
            <input type="text" name="name" id="name" class="w-full border p-2 rounded">
        </div>

        <div class="mb-4">
            <label>Unvan</label>
            <input type="text" name="title" id="title" class="w-full border p-2 rounded">
        </div>

        <div class="mb-4">
            <label>Branş</label>
            <input type="text" name="specialty" id="specialty" class="w-full border p-2 rounded">
        </div>

        <div class="mb-4">
            <label>Biyografi</label>
            <textarea name="bio" id="bio" class="w-full border p-2 rounded"></textarea>
        </div>

        <div class="grid md:grid-cols-2 gap-4">
            <div class="mb-4">
                <label>Telefon</label>
                <input type="text" name="phone" id="phone" class="w-full border p-2 rounded">
            </div>

            <div class="mb-4">
                <label>Email</label>
                <input type="email" name="email" id="email" class="w-full border p-2 rounded">
            </div>
        </div>

        <div class="mb-4">
            <label>Fotoğraf</label>
            <input type="file" name="image" class="w-full border p-2 rounded">
            <img id="preview" class="mt-2 w-40 hidden">
        </div>

        <button class="bg-blue-600 text-white px-4 py-2 rounded">
            Güncelle
        </button>

    </form>
</div>

<script>
const id = new URLSearchParams(window.location.search).get("id");

async function load() {
    const res = await fetch("../api/admin/doctor-list.php");
    const data = await res.json();

    const item = data.data.find(x => x.id == id);

    if (!item) return alert("Bulunamadı");

    document.getElementById("id").value = item.id;
    document.getElementById("name").value = item.name;
    document.getElementById("title").value = item.title ?? '';
    document.getElementById("specialty").value = item.specialty ?? '';
    document.getElementById("bio").value = item.bio ?? '';
    document.getElementById("phone").value = item.phone ?? '';
    document.getElementById("email").value = item.email ?? '';

    if (item.image) {
        const img = document.getElementById("preview");
        img.src = "../" + item.image;
        img.classList.remove("hidden");
    }

    document.getElementById("loading").style.display = "none";
    document.getElementById("editForm").classList.remove("hidden");
}

load();

document.getElementById("editForm").addEventListener("submit", async (e) => {
    e.preventDefault();

    const fd = new FormData(e.target);
    fd.append("csrf_token", window.CSRF_TOKEN || "");

    const res = await fetch("../api/admin/doctor-update.php", {
        method: "POST",
        body: fd
    });

    const data = await res.json();

    alert(data.message);

    if (data.success) {
        location.href = "doktorlar.php";
    }
});
</script>

<?php
$content = ob_get_clean();
require __DIR__ . '/layout.php';
?>