<?php
require_once __DIR__ . '/auth_check.php';
require_once __DIR__ . '/../includes/db.php';

$pdo = getDB();

function e($value): string
{
    return htmlspecialchars((string)($value ?? ''), ENT_QUOTES, 'UTF-8');
}

function formatLogDate($value): string
{
    if (!$value) {
        return '-';
    }

    $timestamp = strtotime((string)$value);

    if (!$timestamp) {
        return e($value);
    }

    return date('d.m.Y H:i', $timestamp);
}

function actionLabel(string $action): string
{
    $labels = [
        'login_success' => 'Giriş Başarılı',
        'login_failed' => 'Giriş Başarısız',
        'logout' => 'Çıkış Yapıldı',

        'service_created' => 'Hizmet Eklendi',
        'service_updated' => 'Hizmet Güncellendi',
        'service_deleted' => 'Hizmet Silindi',

        'doctor_created' => 'Doktor Eklendi',
        'doctor_updated' => 'Doktor Güncellendi',
        'doctor_deleted' => 'Doktor Silindi',

        'settings_updated' => 'Ayarlar Güncellendi',
        'logo_updated' => 'Logo Güncellendi',

        'appointment_status_updated' => 'Randevu Durumu Güncellendi',
    ];

    return $labels[$action] ?? $action;
}

function actionBadgeClass(string $action): string
{
    if (str_contains($action, 'failed') || str_contains($action, 'deleted')) {
        return 'bg-red-50 text-red-700 border-red-100';
    }

    if (str_contains($action, 'created') || str_contains($action, 'success')) {
        return 'bg-green-50 text-green-700 border-green-100';
    }

    if (str_contains($action, 'updated') || str_contains($action, 'logo')) {
        return 'bg-blue-50 text-blue-700 border-blue-100';
    }

    if (str_contains($action, 'logout')) {
        return 'bg-slate-50 text-slate-700 border-slate-100';
    }

    return 'bg-yellow-50 text-yellow-700 border-yellow-100';
}

function prettyJson($value): string
{
    if (!$value) {
        return '-';
    }

    $decoded = json_decode((string)$value, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        return e($value);
    }

    return e(json_encode($decoded, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
}

$search = trim($_GET['q'] ?? '');
$action = trim($_GET['action'] ?? '');
$entity = trim($_GET['entity'] ?? '');
$page = max(1, (int)($_GET['page'] ?? 1));
$perPage = 15;
$offset = ($page - 1) * $perPage;

$where = [];
$params = [];

if ($search !== '') {
    $where[] = "(
        l.action LIKE :search
        OR l.entity_type LIKE :search
        OR l.ip_address LIKE :search
        OR u.name LIKE :search
        OR u.email LIKE :search
    )";
    $params[':search'] = '%' . $search . '%';
}

if ($action !== '') {
    $where[] = "l.action = :action";
    $params[':action'] = $action;
}

if ($entity !== '') {
    $where[] = "l.entity_type = :entity";
    $params[':entity'] = $entity;
}

$whereSql = $where ? "WHERE " . implode(" AND ", $where) : "";

/*
|--------------------------------------------------------------------------
| Stats
|--------------------------------------------------------------------------
*/
$totalStmt = $pdo->prepare("
    SELECT COUNT(*)
    FROM admin_activity_logs l
    LEFT JOIN users u ON u.id = l.user_id
    $whereSql
");
$totalStmt->execute($params);
$totalRows = (int)$totalStmt->fetchColumn();
$totalPages = max(1, (int)ceil($totalRows / $perPage));

$todayStmt = $pdo->query("
    SELECT COUNT(*)
    FROM admin_activity_logs
    WHERE DATE(created_at) = CURDATE()
");
$todayCount = (int)$todayStmt->fetchColumn();

$failedStmt = $pdo->query("
    SELECT COUNT(*)
    FROM admin_activity_logs
    WHERE action = 'login_failed'
      AND created_at >= DATE_SUB(NOW(), INTERVAL 24 HOUR)
");
$failedCount = (int)$failedStmt->fetchColumn();

/*
|--------------------------------------------------------------------------
| Filter Options
|--------------------------------------------------------------------------
*/
$actions = $pdo->query("
    SELECT DISTINCT action
    FROM admin_activity_logs
    ORDER BY action ASC
")->fetchAll(PDO::FETCH_COLUMN);

$entities = $pdo->query("
    SELECT DISTINCT entity_type
    FROM admin_activity_logs
    WHERE entity_type IS NOT NULL
      AND entity_type != ''
    ORDER BY entity_type ASC
")->fetchAll(PDO::FETCH_COLUMN);

/*
|--------------------------------------------------------------------------
| Logs
|--------------------------------------------------------------------------
*/
$sql = "
    SELECT
        l.*,
        u.name AS user_name,
        u.email AS user_email
    FROM admin_activity_logs l
    LEFT JOIN users u ON u.id = l.user_id
    $whereSql
    ORDER BY l.id DESC
    LIMIT :limit OFFSET :offset
";

$stmt = $pdo->prepare($sql);

foreach ($params as $key => $value) {
    $stmt->bindValue($key, $value, PDO::PARAM_STR);
}

$stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();

$logs = $stmt->fetchAll(PDO::FETCH_ASSOC);

ob_start();
?>

<div class="max-w-7xl mx-auto space-y-6">

    <!-- HEADER -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-slate-950 via-blue-950 to-teal-900 p-6 md:p-8 text-white shadow-xl">

        <div class="absolute -top-24 -right-24 w-72 h-72 bg-white/10 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-24 -left-24 w-72 h-72 bg-teal-400/20 rounded-full blur-3xl"></div>

        <div class="relative flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">

            <div>
                <div class="inline-flex items-center gap-2 bg-white/10 border border-white/15 rounded-full px-3 py-1 text-xs font-semibold mb-4">
                    <span class="w-2 h-2 rounded-full bg-green-400"></span>
                    Güvenlik ve İşlem Kayıtları
                </div>

                <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight">
                    Aktivite Logları
                </h1>

                <p class="text-blue-100 mt-2 max-w-2xl">
                    Admin panelde yapılan giriş, çıkış, ekleme, güncelleme ve silme işlemlerini buradan takip edebilirsin.
                </p>
            </div>

            <div class="bg-white/10 border border-white/15 rounded-2xl p-5 min-w-[240px] backdrop-blur">
                <p class="text-xs text-blue-100 uppercase font-semibold tracking-wide">
                    Toplam Kayıt
                </p>

                <h2 class="text-3xl font-black mt-2">
                    <?= e($totalRows) ?>
                </h2>

                <p class="text-xs text-blue-100 mt-2">
                    Filtreye göre gösterilen kayıt sayısı.
                </p>
            </div>

        </div>

    </div>

    <!-- STATS -->
    <div class="grid md:grid-cols-3 gap-4">

        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-5">
            <p class="text-xs text-slate-500 uppercase font-bold">Bugünkü Log</p>
            <h2 class="text-4xl font-black text-slate-900 mt-3"><?= e($todayCount) ?></h2>
            <p class="text-xs text-slate-400 mt-2">Bugün oluşan admin aktiviteleri.</p>
        </div>

        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-5">
            <p class="text-xs text-red-600 uppercase font-bold">Son 24 Saat Başarısız Giriş</p>
            <h2 class="text-4xl font-black text-red-700 mt-3"><?= e($failedCount) ?></h2>
            <p class="text-xs text-slate-400 mt-2">Şüpheli giriş denemeleri için takip edilir.</p>
        </div>

        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-5">
            <p class="text-xs text-blue-600 uppercase font-bold">Sayfa</p>
            <h2 class="text-4xl font-black text-blue-700 mt-3"><?= e($page) ?> / <?= e($totalPages) ?></h2>
            <p class="text-xs text-slate-400 mt-2">Her sayfada <?= e($perPage) ?> kayıt gösterilir.</p>
        </div>

    </div>

    <!-- FILTERS -->
    <form method="GET" class="bg-white rounded-3xl shadow-sm border border-slate-100 p-5 grid lg:grid-cols-4 gap-4">

        <div>
            <label class="block text-xs text-slate-500 uppercase font-bold mb-2">
                Arama
            </label>

            <input type="text"
                   name="q"
                   value="<?= e($search) ?>"
                   placeholder="Kullanıcı, IP, işlem..."
                   class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div>
            <label class="block text-xs text-slate-500 uppercase font-bold mb-2">
                İşlem
            </label>

            <select name="action"
                    class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">Tümü</option>

                <?php foreach ($actions as $item): ?>
                    <option value="<?= e($item) ?>" <?= $action === $item ? 'selected' : '' ?>>
                        <?= e(actionLabel((string)$item)) ?>
                    </option>
                <?php endforeach; ?>

            </select>
        </div>

        <div>
            <label class="block text-xs text-slate-500 uppercase font-bold mb-2">
                Varlık
            </label>

            <select name="entity"
                    class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">Tümü</option>

                <?php foreach ($entities as $item): ?>
                    <option value="<?= e($item) ?>" <?= $entity === $item ? 'selected' : '' ?>>
                        <?= e($item) ?>
                    </option>
                <?php endforeach; ?>

            </select>
        </div>

        <div class="flex items-end gap-2">
            <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-xl text-sm font-bold transition">
                Filtrele
            </button>

            <a href="aktivite-loglari.php"
               class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-5 py-3 rounded-xl text-sm font-bold transition">
                Sıfırla
            </a>
        </div>

    </form>

    <!-- LOG LIST -->
    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">

        <div class="p-6 border-b border-slate-100 flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div>
                <h2 class="text-xl font-black text-slate-900">
                    Log Kayıtları
                </h2>
                <p class="text-sm text-slate-500 mt-1">
                    En yeni kayıtlar üstte listelenir.
                </p>
            </div>
        </div>

        <?php if (!$logs): ?>

            <div class="p-8 text-center text-slate-500">
                Kayıt bulunamadı.
            </div>

        <?php else: ?>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-slate-50 border-b border-slate-100">
                    <tr>
                        <th class="text-left px-5 py-4 text-xs uppercase text-slate-500 font-black">Tarih</th>
                        <th class="text-left px-5 py-4 text-xs uppercase text-slate-500 font-black">Kullanıcı</th>
                        <th class="text-left px-5 py-4 text-xs uppercase text-slate-500 font-black">İşlem</th>
                        <th class="text-left px-5 py-4 text-xs uppercase text-slate-500 font-black">Varlık</th>
                        <th class="text-left px-5 py-4 text-xs uppercase text-slate-500 font-black">IP</th>
                        <th class="text-right px-5 py-4 text-xs uppercase text-slate-500 font-black">Detay</th>
                    </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100">
                    <?php foreach ($logs as $log): ?>
                        <?php
                        $modalId = 'logModal_' . (int)$log['id'];
                        $userText = $log['user_name']
                            ? $log['user_name'] . ' (' . ($log['user_email'] ?? '-') . ')'
                            : 'Sistem / Bilinmiyor';
                        ?>

                        <tr class="hover:bg-slate-50 align-top">
                            <td class="px-5 py-4 whitespace-nowrap font-semibold text-slate-700">
                                <?= e(formatLogDate($log['created_at'] ?? null)) ?>
                            </td>

                            <td class="px-5 py-4">
                                <div class="font-bold text-slate-900">
                                    <?= e($userText) ?>
                                </div>
                                <div class="text-xs text-slate-400 mt-1">
                                    User ID: <?= e($log['user_id'] ?? '-') ?>
                                </div>
                            </td>

                            <td class="px-5 py-4">
                                <span class="inline-flex px-3 py-1 rounded-full border text-xs font-black <?= e(actionBadgeClass((string)$log['action'])) ?>">
                                    <?= e(actionLabel((string)$log['action'])) ?>
                                </span>

                                <div class="text-xs text-slate-400 mt-2">
                                    <?= e($log['action']) ?>
                                </div>
                            </td>

                            <td class="px-5 py-4">
                                <div class="font-bold text-slate-800">
                                    <?= e($log['entity_type'] ?? '-') ?>
                                </div>

                                <div class="text-xs text-slate-400 mt-1">
                                    ID: <?= e($log['entity_id'] ?? '-') ?>
                                </div>
                            </td>

                            <td class="px-5 py-4 whitespace-nowrap text-slate-700 font-semibold">
                                <?= e($log['ip_address'] ?? '-') ?>
                            </td>

                            <td class="px-5 py-4 text-right">
                                <button type="button"
                                        onclick="document.getElementById('<?= e($modalId) ?>').classList.remove('hidden')"
                                        class="bg-slate-900 hover:bg-slate-800 text-white px-4 py-2 rounded-xl text-xs font-bold transition">
                                    Detay
                                </button>
                            </td>
                        </tr>

                        <!-- MODAL -->
                        <div id="<?= e($modalId) ?>"
                             class="hidden fixed inset-0 z-50 bg-slate-950/60 backdrop-blur-sm p-4 overflow-y-auto">

                            <div class="max-w-5xl mx-auto my-8 bg-white rounded-3xl shadow-2xl overflow-hidden">

                                <div class="p-6 border-b border-slate-100 flex items-start justify-between gap-4">
                                    <div>
                                        <h3 class="text-2xl font-black text-slate-900">
                                            Log Detayı #<?= e($log['id']) ?>
                                        </h3>

                                        <p class="text-sm text-slate-500 mt-1">
                                            <?= e(actionLabel((string)$log['action'])) ?> · <?= e(formatLogDate($log['created_at'] ?? null)) ?>
                                        </p>
                                    </div>

                                    <button type="button"
                                            onclick="document.getElementById('<?= e($modalId) ?>').classList.add('hidden')"
                                            class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-4 py-2 rounded-xl text-sm font-bold">
                                        Kapat
                                    </button>
                                </div>

                                <div class="p-6 grid md:grid-cols-2 gap-5">

                                    <div class="rounded-2xl border border-slate-100 bg-slate-50 p-4">
                                        <p class="text-xs text-slate-500 uppercase font-bold mb-1">Kullanıcı</p>
                                        <p class="font-black text-slate-900"><?= e($userText) ?></p>
                                    </div>

                                    <div class="rounded-2xl border border-slate-100 bg-slate-50 p-4">
                                        <p class="text-xs text-slate-500 uppercase font-bold mb-1">IP Adresi</p>
                                        <p class="font-black text-slate-900"><?= e($log['ip_address'] ?? '-') ?></p>
                                    </div>

                                    <div class="rounded-2xl border border-slate-100 bg-slate-50 p-4">
                                        <p class="text-xs text-slate-500 uppercase font-bold mb-1">İşlem</p>
                                        <p class="font-black text-slate-900"><?= e($log['action']) ?></p>
                                    </div>

                                    <div class="rounded-2xl border border-slate-100 bg-slate-50 p-4">
                                        <p class="text-xs text-slate-500 uppercase font-bold mb-1">Varlık</p>
                                        <p class="font-black text-slate-900">
                                            <?= e($log['entity_type'] ?? '-') ?> / ID: <?= e($log['entity_id'] ?? '-') ?>
                                        </p>
                                    </div>

                                    <div class="md:col-span-2 rounded-2xl border border-slate-100 bg-slate-50 p-4">
                                        <p class="text-xs text-slate-500 uppercase font-bold mb-2">User Agent</p>
                                        <p class="text-sm text-slate-700 break-all">
                                            <?= e($log['user_agent'] ?? '-') ?>
                                        </p>
                                    </div>

                                    <div class="rounded-2xl border border-red-100 bg-red-50 p-4">
                                        <p class="text-xs text-red-700 uppercase font-bold mb-2">
                                            Eski Veri
                                        </p>

                                        <pre class="text-xs whitespace-pre-wrap break-words text-red-900 bg-white/70 border border-red-100 rounded-xl p-4 max-h-[420px] overflow-auto"><?= prettyJson($log['old_data'] ?? null) ?></pre>
                                    </div>

                                    <div class="rounded-2xl border border-green-100 bg-green-50 p-4">
                                        <p class="text-xs text-green-700 uppercase font-bold mb-2">
                                            Yeni Veri
                                        </p>

                                        <pre class="text-xs whitespace-pre-wrap break-words text-green-900 bg-white/70 border border-green-100 rounded-xl p-4 max-h-[420px] overflow-auto"><?= prettyJson($log['new_data'] ?? null) ?></pre>
                                    </div>

                                </div>

                            </div>
                        </div>

                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        <?php endif; ?>

    </div>

    <!-- PAGINATION -->
    <?php if ($totalPages > 1): ?>
        <div class="flex flex-wrap justify-center gap-2">

            <?php
            $baseParams = $_GET;
            unset($baseParams['page']);

            $makeUrl = function (int $p) use ($baseParams) {
                return 'aktivite-loglari.php?' . http_build_query(array_merge($baseParams, ['page' => $p]));
            };
            ?>

            <?php if ($page > 1): ?>
                <a href="<?= e($makeUrl($page - 1)) ?>"
                   class="px-4 py-2 rounded-xl bg-white border border-slate-100 text-slate-700 font-bold text-sm hover:bg-slate-50">
                    ← Önceki
                </a>
            <?php endif; ?>

            <?php
            $start = max(1, $page - 2);
            $end = min($totalPages, $page + 2);
            ?>

            <?php for ($i = $start; $i <= $end; $i++): ?>
                <a href="<?= e($makeUrl($i)) ?>"
                   class="px-4 py-2 rounded-xl border text-sm font-bold <?= $i === $page ? 'bg-blue-600 text-white border-blue-600' : 'bg-white border-slate-100 text-slate-700 hover:bg-slate-50' ?>">
                    <?= e($i) ?>
                </a>
            <?php endfor; ?>

            <?php if ($page < $totalPages): ?>
                <a href="<?= e($makeUrl($page + 1)) ?>"
                   class="px-4 py-2 rounded-xl bg-white border border-slate-100 text-slate-700 font-bold text-sm hover:bg-slate-50">
                    Sonraki →
                </a>
            <?php endif; ?>

        </div>
    <?php endif; ?>

</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/layout.php';
?>