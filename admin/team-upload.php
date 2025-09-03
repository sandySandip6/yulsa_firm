<?php
include_once '../db_config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $position = $_POST['position'];
    $image = null;

    if (!empty($_FILES['image']['name'])) {
        $targetDir = "uploads/team/";
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $fileName = time() . "_" . basename($_FILES['image']['name']);
        $targetFile = $targetDir . $fileName;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            $image = $fileName;
        }
    }

    $stmt = $conn->prepare("INSERT INTO team (name, position, image) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $position, $image);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Team member added"]);
    } else {
        echo json_encode(["success" => false, "message" => "Error: " . $stmt->error]);
    }

    $stmt->close();
}
?>
