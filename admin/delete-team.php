<?php
include_once '../db_config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

    // First get the image path to delete the file
    $stmt = $conn->prepare("SELECT image FROM team WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($row = $result->fetch_assoc()) {
        $imagePath = $row['image'];
        
        // Delete the team member from database
        $deleteStmt = $conn->prepare("DELETE FROM team WHERE id = ?");
        $deleteStmt->bind_param("i", $id);
        
        if ($deleteStmt->execute()) {
            // Delete the image file if it exists
            if ($imagePath && file_exists("uploads/team/" . $imagePath)) {
                unlink("uploads/team/" . $imagePath);
            }
            echo json_encode(["success" => true, "message" => "Team member deleted successfully"]);
        } else {
            echo json_encode(["success" => false, "message" => "Error: " . $deleteStmt->error]);
        }
        
        $deleteStmt->close();
    } else {
        echo json_encode(["success" => false, "message" => "Team member not found"]);
    }
    
    $stmt->close();
} else {
    echo json_encode(["success" => false, "message" => "Invalid request method"]);
}
?>
