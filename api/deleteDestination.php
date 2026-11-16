<?php
require_once __DIR__ . '/../src/db.php';

header('Content-Type: application/json');

$activity = $_POST['activity'] ?? '';

if ($activity === '') {
    http_response_code(400);
    echo json_encode(['ok' => false, 'error' => 'Missing activity']);
    exit;
}

$pdo = getDbConnection();
$stmt = $pdo->prepare('DELETE FROM added_destination WHERE added_activity = :activity');
$stmt->execute([':activity' => $activity]);

echo json_encode(['ok' => true]);
