<?php
require_once __DIR__ . '/auth_check.php';
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Randevular</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

<div class="p-6">

    <h1 class="text-2xl font-bold mb-4">Randevular</h1>

    <div id="list" class="space-y-3"></div>

</div>

<script>
async function loadAppointments() {

    const res = await fetch("../api/admin/appt-list.php");
    const data = await res.json();

    const list = document.getElementById("list");
    list.innerHTML = "";

    if (!data.success) return;

    data.data.forEach(item => {

        list.innerHTML += `
            <div class="bg-white p-4 rounded shadow">
                <b>${item.full_name}</b><br>
                ${item.phone} <br>
                <span class="text-sm text-gray-500">${item.status}</span>
            </div>
        `;
    });
}

loadAppointments();
</script>

</body>
</html>