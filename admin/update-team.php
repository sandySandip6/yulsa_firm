<?php
include_once '../db_config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $position = $_POST['position'];
    $currentImage = $_POST['current_image'] ?? null;
    $image = $currentImage; // Keep current image by default

    // Handle new image upload
    if (!empty($_FILES['image']['name'])) {
        $targetDir = "uploads/team/";
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $fileName = time() . "_" . basename($_FILES['image']['name']);
        $targetFile = $targetDir . $fileName;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            // Delete old image if it exists
            if ($currentImage && file_exists($targetDir . $currentImage)) {
                unlink($targetDir . $currentImage);
            }
            $image = $fileName;
        }
    }

    $stmt = $conn->prepare("UPDATE team SET name = ?, position = ?, image = ? WHERE id = ?");
    $stmt->bind_param("sssi", $name, $position, $image, $id);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Team member updated successfully"]);
    } else {
        echo json_encode(["success" => false, "message" => "Error: " . $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(["success" => false, "message" => "Invalid request method"]);
}
?>
