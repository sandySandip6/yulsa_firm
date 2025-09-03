<?php
include_once '../db_config.php';

$query = "SELECT * FROM team ORDER BY created_at DESC";
$result = $conn->query($query);

$members = [];
while ($row = $result->fetch_assoc()) {
    $row['image'] = !empty($row['image']) ? "./uploads/team/" . $row['image'] : "./uploads/team/default.png";
    $members[] = $row;
}

echo json_encode($members);
?>
