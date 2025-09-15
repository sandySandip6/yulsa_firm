<?php
// Debug form submission
// This file helps debug why the form isn't sending emails

echo "<h2>Form Submission Debug</h2>";

// Check if form data is being received
echo "<h3>1. Form Data Check:</h3>";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    echo "<p style='color: green;'>✓ POST request received</p>";
    echo "<p><strong>Form Data:</strong></p>";
    echo "<ul>";
    foreach ($_POST as $key => $value) {
        if (is_array($value)) {
            echo "<li><strong>$key:</strong> " . implode(', ', $value) . "</li>";
        } else {
            echo "<li><strong>$key:</strong> " . htmlspecialchars($value) . "</li>";
        }
    }
    echo "</ul>";
} else {
    echo "<p style='color: red;'>✗ No POST request received</p>";
    echo "<p>Method: " . $_SERVER["REQUEST_METHOD"] . "</p>";
}

// Check if required files exist
echo "<h3>2. File Existence Check:</h3>";
$files_to_check = [
    'db_config.php' => 'Database configuration',
    'gmail-email-service.php' => 'Gmail email service',
    'gmail-config.php' => 'Gmail configuration'
];

foreach ($files_to_check as $file => $description) {
    if (file_exists($file)) {
        echo "<p style='color: green;'>✓ $description ($file) exists</p>";
    } else {
        echo "<p style='color: red;'>✗ $description ($file) missing</p>";
    }
}

// Test database connection
echo "<h3>3. Database Connection Test:</h3>";
try {
    include_once 'db_config.php';
    if ($conn && $conn->ping()) {
        echo "<p style='color: green;'>✓ Database connection successful</p>";
    } else {
        echo "<p style='color: red;'>✗ Database connection failed</p>";
    }
} catch (Exception $e) {
    echo "<p style='color: red;'>✗ Database error: " . $e->getMessage() . "</p>";
}

// Test Gmail email service
echo "<h3>4. Gmail Email Service Test:</h3>";
try {
    include_once 'gmail-email-service.php';
    $emailService = new GmailEmailService();
    echo "<p style='color: green;'>✓ Gmail email service loaded successfully</p>";
} catch (Exception $e) {
    echo "<p style='color: red;'>✗ Gmail email service error: " . $e->getMessage() . "</p>";
}

// Test actual form processing
echo "<h3>5. Form Processing Test:</h3>";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    try {
        // Simulate form processing
        $name = $conn->real_escape_string(trim($_POST['name']));
        $email = $conn->real_escape_string(trim($_POST['email']));
        $businessInfo = $conn->real_escape_string(trim($_POST['business-info']));
        $services = isset($_POST['services']) && is_array($_POST['services'])
            ? implode(", ", $_POST['services'])
            : "";
        $otherService = isset($_POST['other-service']) && !empty($_POST['other-service']) 
            ? $conn->real_escape_string(trim($_POST['other-service'])) 
            : null;
        
        if ($otherService) {
            $services .= ($services ? ", " : "") . "Other: " . $otherService;
        }
        
        echo "<p><strong>Processed Data:</strong></p>";
        echo "<ul>";
        echo "<li><strong>Name:</strong> " . htmlspecialchars($name) . "</li>";
        echo "<li><strong>Email:</strong> " . htmlspecialchars($email) . "</li>";
        echo "<li><strong>Business Info:</strong> " . htmlspecialchars($businessInfo) . "</li>";
        echo "<li><strong>Services:</strong> " . htmlspecialchars($services) . "</li>";
        echo "</ul>";
        
        // Test email sending
        echo "<p><strong>Testing email sending...</strong></p>";
        $emailService = new GmailEmailService();
        $result = $emailService->sendAutoReply($email, $name, $services, $businessInfo);
        
        if ($result) {
            echo "<p style='color: green;'>✓ Email sent successfully!</p>";
        } else {
            echo "<p style='color: red;'>✗ Email sending failed</p>";
        }
        
    } catch (Exception $e) {
        echo "<p style='color: red;'>✗ Form processing error: " . $e->getMessage() . "</p>";
    }
}

echo "<hr>";
echo "<h3>6. JavaScript Form Test:</h3>";
echo "<p>Test the form submission with JavaScript:</p>";
echo "<form id='testForm' method='POST'>";
echo "<input type='text' name='name' placeholder='Full Name' required><br><br>";
echo "<input type='email' name='email' placeholder='Email' required><br><br>";
echo "<input type='text' name='business-info' placeholder='Business Info' required><br><br>";
echo "<label><input type='checkbox' name='services[]' value='Accounting & Bookkeeping'> Accounting & Bookkeeping</label><br>";
echo "<label><input type='checkbox' name='services[]' value='Tax Filing'> Tax Filing</label><br><br>";
echo "<button type='submit'>Test Form Submission</button>";
echo "</form>";

echo "<hr>";
echo "<p><strong>Note:</strong> Delete this file after debugging for security reasons.</p>";
?>
