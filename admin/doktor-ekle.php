<?php
require_once __DIR__ . '/auth_check.php';
ob_start();
?>

<div class="max-w-3xl mx-auto">

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Yeni Doktor Ekle</h1>

        <a href="doktorlar.php"
           class="bg-gray-600 text-white px-4 py-2 rounded">
            Listeye Dön
        </a>
    </div>

    <div class="bg-white rounded shadow p-6">

        <form id="doctorForm" enctype="multipart/form-data">

            <div class="mb-4">
                <label class="block mb-2 font-medium">Ad Soyad</label>
                <input type="text" name="name" class="w-full border rounded p-3" required>
            </div>

            <div class="mb-4">
                <label class="block mb-2 font-medium">Unvan</label>
                <input type="text" name="title" class="w-full border rounded p-3" placeholder="Op. Dr., Uzm. Dr. ...">
            </div>

            <div class="mb-4">
                <label class="block mb-2 font-medium">Branş</label>
                <input type="text" name="specialty" class="w-full border rounded p-3" placeholder="Kardiyoloji, Diş Hekimi ...">
            </div>

            <div class="mb-4">
                <label class="block mb-2 font-medium">Biyografi</label>
                <textarea name="bio" class="w-full border rounded p-3"></textarea>
            </div>

            <div class="grid md:grid-cols-2 gap-4">
                <div class="mb-4">
                    <label class="block mb-2 font-medium">Telefon</label>
                    <input type="text" name="phone" class="w-full border rounded p-3">
                </div>

                <div class="mb-4">
                    <label class="block mb-2 font-medium">Email</label>
                    <input type="email" name="email" class="w-full border rounded p-3">
                </div>
            </div>

            <div class="mb-4">
                <label class="block mb-2 font-medium">Fotoğraf</label>
                <input type="file" name="image" class="w-full border rounded p-3">
            </div>

            <button class="bg-blue-600 text-white px-5 py-2 rounded">
                Kaydet
            </button>

        </form>

        <div id="message" class="mt-4 text-sm"></div>

    </div>
</div>

<script>
document.getElementById('doctorForm').addEventListener('submit', async (e) => {
    e.preventDefault();

    const res = await fetch('../api/admin/doctor-create.php', {
        method: 'POST',
        body: new FormData(e.target)
    });

    const data = await res.json();

    const msg = document.getElementById('message');

    if (data.success) {
        msg.className = "text-green-600 mt-4";
        msg.innerText = data.message;

        setTimeout(() => location.href = "doktorlar.php", 800);
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