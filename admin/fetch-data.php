<?php
// fetch-data.php
header('Content-Type: application/json; charset=utf-8');

// Include DB config — adjust path if necessary
include_once '../db_config.php';

// Stop if connection missing
if (!isset($conn) || $conn->connect_error) {
    echo json_encode(['error' => 'Database connection failed']);
    exit();
}

// Explicit column selection and aliasing to stable keys
$sql = "SELECT id, name, email, b_info, services, other_services FROM collab_us";
$result = $conn->query($sql);

if (!$result) {
    echo json_encode(['error' => $conn->error]);
    exit();
}

$data = [];
while ($row = $result->fetch_assoc()) {
    // Optional: normalize NULL to empty string to avoid undefined on client
    $row['services'] = $row['services'] ?? '';
    $row['other_services'] = $row['other_services'] ?? '';
    $data[] = $row;
}

echo json_encode($data, JSON_UNESCAPED_UNICODE);
exit();
?>
