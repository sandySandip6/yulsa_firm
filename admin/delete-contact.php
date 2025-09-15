<?php
session_start();
// If admin is not logged in, redirect to login page
if (!isset($_SESSION['yadmin'])) {
    header('Location: login.php');
    exit();
}

include '../db_config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $contactId = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    
    if ($contactId > 0) {
        $sql = "DELETE FROM contact_form WHERE id = $contactId";
        
        if ($conn->query($sql) === TRUE) {
            echo json_encode(['success' => true, 'message' => 'Contact message deleted successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error deleting contact message: ' . $conn->error]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid contact ID']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}

$conn->close();
?>
