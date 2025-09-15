<?php
// Include database configuration and Gmail email service
include_once 'db_config.php';
include_once 'gmail-email-service.php';

// Set content type to JSON for AJAX responses
header('Content-Type: application/json');

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    try {
        // Sanitize and validate input data
        $name = $conn->real_escape_string(trim($_POST['name']));
        $email = $conn->real_escape_string(trim($_POST['email']));
        $businessInfo = $conn->real_escape_string(trim($_POST['business-info']));
        $services = isset($_POST['services']) && is_array($_POST['services'])
            ? implode(", ", $_POST['services'])
            : "";
        $otherService = isset($_POST['other-service']) && !empty($_POST['other-service']) 
            ? $conn->real_escape_string(trim($_POST['other-service'])) 
            : null;
        
        // Add other service to services list if provided
        if ($otherService) {
            $services .= ($services ? ", " : "") . "Other: " . $otherService;
        }
        
        // Validate required fields
        if (empty($name) || empty($email) || empty($businessInfo)) {
            echo json_encode(['status' => 'error', 'message' => 'Please fill in all required fields.']);
            exit;
        }
        
        // Validate email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(['status' => 'error', 'message' => 'Please enter a valid email address.']);
            exit;
        }
        
        // Insert data into the database
        $sql = "INSERT INTO collab_us (name, email, b_info, services, other_services) 
                VALUES ('$name', '$email', '$businessInfo', '$services', '$otherService')";
        
        if ($conn->query($sql) === TRUE) {
            // Initialize Gmail email service and send auto-reply
            $emailService = new GmailEmailService();
            $emailSent = $emailService->sendAutoReply($email, $name, $services, $businessInfo);
            
            if ($emailSent) {
                $response = ['status' => 'success', 'message' => 'Thank you for your collaboration interest! We have sent you a confirmation email.'];
            } else {
                // Even if email fails, the form was submitted successfully
                $response = ['status' => 'success', 'message' => 'Thank you for your collaboration interest! We will get back to you soon.'];
            }
            
            // Check if this is an AJAX request
            if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                // This is an AJAX request, return JSON
                echo json_encode($response);
            } else {
                // This is a regular form submission, redirect to home page
                echo "<script>alert('" . addslashes($response['message']) . "'); window.location.href='index.php';</script>";
            }
        } else {
            $error_message = 'Database error: ' . $conn->error;
            if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                echo json_encode(['status' => 'error', 'message' => $error_message]);
            } else {
                echo "<script>alert('" . addslashes($error_message) . "'); window.location.href='index.php';</script>";
            }
        }
        
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => 'An error occurred: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}

// Close database connection
$conn->close();
?>
