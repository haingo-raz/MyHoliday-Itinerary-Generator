<?php
require_once __DIR__ . '/../src/db.php';

header('Content-Type: application/json');

$location = $_POST['location'] ?? '';
$activity = $_POST['activity'] ?? '';
$duration = (int) ($_POST['duration'] ?? 0);
$price = (int) ($_POST['price'] ?? 0);

if ($location === '' || $activity === '') {
    http_response_code(400);
    echo json_encode(['ok' => false, 'error' => 'Missing fields']);
    exit;
}

$pdo = getDbConnection();
$stmt = $pdo->prepare(
    'INSERT INTO added_destination (added_location, added_activity, added_duration, added_price)
     VALUES (:location, :activity, :duration, :price)
     ON CONFLICT (added_activity) DO NOTHING'
);
$stmt->execute([
    ':location' => $location,
    ':activity' => $activity,
    ':duration' => $duration,
    ':price' => $price,
]);

echo json_encode(['ok' => true]);
