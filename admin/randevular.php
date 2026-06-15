<?php
require_once __DIR__ . '/auth_check.php';
ob_start();
?>
 
<h1 class="text-2xl font-bold mb-4">Randevular</h1>
 
<div id="list" class="space-y-3"></div>
 
<script>
async function loadAppointments() {
 
    const res = await fetch("../api/admin/appt-list.php");
    const json = await res.json();
 
    const list = document.getElementById("list");
    list.innerHTML = "";
 
    if (!json.success) {
        list.innerHTML = "<p>Veri alınamadı</p>";
        return;
    }
 
    json.data.forEach(item => {
 
        const date = item.appointment_date ?? "-";
        const time = (item.appointment_time ?? "-").slice(0, 5);
 
        const statusMap = {
            pending:   { label: "Bekliyor",  cls: "bg-yellow-100 text-yellow-800" },
            confirmed: { label: "Onaylı",    cls: "bg-green-100 text-green-800"  },
            cancelled: { label: "İptal",     cls: "bg-red-100 text-red-800"      }
        };
 
        const st = statusMap[item.status] ?? { label: item.status, cls: "bg-gray-200" };
 
        list.innerHTML += `
            <div class="bg-white p-4 rounded shadow">
 
                <div class="flex justify-between items-start">
                    <div>
                        <b class="text-lg">${item.full_name}</b>
 
                        <div class="text-sm text-gray-600 mt-1">
                            📞 ${item.phone}
                        </div>
 
                        <div class="text-sm text-gray-600">
                            📅 ${date} &nbsp; 🕐 ${time}
                        </div>
                    </div>
 
                    <div class="flex flex-col items-end gap-2">
                        <span class="text-xs px-2 py-1 rounded font-medium ${st.cls}">
                            ${st.label}
                        </span>
 
                        <a href="randevu-detay.php?id=${item.id}"
                           class="text-sm bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">
                            Detay →
                        </a>
                    </div>
                </div>
 
            </div>
        `;
    });
}
 
loadAppointments();
</script>
 
<?php
$content = ob_get_clean();
require __DIR__ . '/layout.php';
?>