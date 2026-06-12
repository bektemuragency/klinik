<?php
require_once __DIR__ . '/auth_check.php';
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

<div class="p-6">

    <h1 class="text-3xl font-bold mb-6">Dashboard</h1>

    <div class="grid grid-cols-4 gap-4">

        <div class="bg-white p-4 rounded shadow">
            <p class="text-gray-500">Toplam Randevu</p>
            <h2 id="total" class="text-2xl font-bold">0</h2>
        </div>

        <div class="bg-white p-4 rounded shadow">
            <p class="text-gray-500">Bekleyen</p>
            <h2 id="pending" class="text-2xl font-bold">0</h2>
        </div>

        <div class="bg-white p-4 rounded shadow">
            <p class="text-gray-500">Onaylı</p>
            <h2 id="confirmed" class="text-2xl font-bold">0</h2>
        </div>

        <div class="bg-white p-4 rounded shadow">
            <p class="text-gray-500">İptal</p>
            <h2 id="cancelled" class="text-2xl font-bold">0</h2>
        </div>

    </div>

</div>

<script>
async function loadStats() {

    const res = await fetch("../api/admin/appt-list.php?stats=1");
    const data = await res.json();

    if (data.success) {
        document.getElementById("total").innerText = data.data.total;
        document.getElementById("pending").innerText = data.data.pending;
        document.getElementById("confirmed").innerText = data.data.confirmed;
        document.getElementById("cancelled").innerText = data.data.cancelled;
    }
}

loadStats();
</script>

</body>
</html>