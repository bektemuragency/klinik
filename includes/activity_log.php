<?php

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| Admin Activity Log Helper
|--------------------------------------------------------------------------
| Admin panelde yapılan kritik işlemleri kayıt altına alır.
| Log hatası olursa sistemi bozmaz, sadece PHP error_log'a yazar.
|--------------------------------------------------------------------------
*/

function getCurrentAdminId(): ?int
{
    if (session_status() === PHP_SESSION_NONE) {
        @session_start();
    }

    if (
        defined('ADMIN_SESSION_NAME') &&
        isset($_SESSION[ADMIN_SESSION_NAME]['id'])
    ) {
        return (int)$_SESSION[ADMIN_SESSION_NAME]['id'];
    }

    return null;
}

function normalizeLogData($data): ?string
{
    if ($data === null || $data === '') {
        return null;
    }

    if (is_string($data)) {
        $decoded = json_decode($data, true);

        if (json_last_error() === JSON_ERROR_NONE) {
            return json_encode($decoded, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        }

        return json_encode(['value' => $data], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

    return json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
}

function getClientIpForLog(): ?string
{
    return $_SERVER['REMOTE_ADDR'] ?? null;
}

function getUserAgentForLog(): ?string
{
    $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? null;

    if ($userAgent === null) {
        return null;
    }

    return mb_substr($userAgent, 0, 1000, 'UTF-8');
}

function logActivity(
    PDO $pdo,
    string $action,
    ?string $entityType = null,
    ?int $entityId = null,
    $oldData = null,
    $newData = null,
    ?int $userId = null
): void {
    try {
        $action = trim($action);
        $entityType = $entityType !== null ? trim($entityType) : null;

        if ($action === '') {
            return;
        }

        if (mb_strlen($action, 'UTF-8') > 100) {
            $action = mb_substr($action, 0, 100, 'UTF-8');
        }

        if ($entityType !== null && mb_strlen($entityType, 'UTF-8') > 100) {
            $entityType = mb_substr($entityType, 0, 100, 'UTF-8');
        }

        $stmt = $pdo->prepare("
            INSERT INTO admin_activity_logs
            (
                user_id,
                action,
                entity_type,
                entity_id,
                old_data,
                new_data,
                ip_address,
                user_agent,
                created_at
            )
            VALUES
            (
                :user_id,
                :action,
                :entity_type,
                :entity_id,
                :old_data,
                :new_data,
                :ip_address,
                :user_agent,
                NOW()
            )
        ");

        $stmt->execute([
            ':user_id'     => $userId ?? getCurrentAdminId(),
            ':action'      => $action,
            ':entity_type' => $entityType ?: null,
            ':entity_id'   => $entityId,
            ':old_data'    => normalizeLogData($oldData),
            ':new_data'    => normalizeLogData($newData),
            ':ip_address'  => getClientIpForLog(),
            ':user_agent'  => getUserAgentForLog(),
        ]);

    } catch (Throwable $e) {
        error_log('Activity Log Error: ' . $e->getMessage());
    }
}