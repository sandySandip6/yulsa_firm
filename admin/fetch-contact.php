<?php
session_start();
// If admin is not logged in, redirect to login page
if (!isset($_SESSION['yadmin'])) {
    header('Location: login.php');
    exit();
}

include '../db_config.php';

// Get pagination parameters
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
$offset = ($page - 1) * $limit;

// Get search parameter
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';

// Build search condition
$searchCondition = '';
if (!empty($search)) {
    $searchCondition = "WHERE name LIKE '%$search%' OR email LIKE '%$search%' OR message LIKE '%$search%'";
}

// Get total count
$countSql = "SELECT COUNT(*) as total FROM contact_form $searchCondition";
$countResult = $conn->query($countSql);
$totalRecords = $countResult->fetch_assoc()['total'];
$totalPages = ceil($totalRecords / $limit);

// Get contact messages with pagination
$sql = "SELECT * FROM contact_form $searchCondition ORDER BY id DESC LIMIT $limit OFFSET $offset";
$result = $conn->query($sql);

$contacts = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $contacts[] = $row;
    }
}

// Return JSON response
header('Content-Type: application/json');
echo json_encode([
    'contacts' => $contacts,
    'pagination' => [
        'current_page' => $page,
        'total_pages' => $totalPages,
        'total_records' => $totalRecords,
        'limit' => $limit
    ]
]);

$conn->close();
?>
