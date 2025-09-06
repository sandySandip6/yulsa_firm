<?php
// Include db_config.php to get database connection and base_url
if (!isset($conn)) {
    include_once(__DIR__ . '/../../db_config.php');
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $businessInfo = $conn->real_escape_string($_POST['business-info']);
    $services = isset($_POST['services']) && is_array($_POST['services'])
        ? implode(", ", $_POST['services'])
        : ""; // Handle multiple services or default to empty
    $otherService = isset($_POST['other-service']) ? $conn->real_escape_string($_POST['other-service']) : null;

    // Insert data into the database
    $sql = "INSERT INTO collab_us (name, email, b_info, services, other_services)
            VALUES ('$name', '$email', '$businessInfo', '$services', '$otherService')";

    if ($conn->query($sql) === TRUE) {
        // Send success status back to JavaScript
        echo "<script>alert('Thanks for Collaboration!'); window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('There was an error submitting your form. Please try again.'); window.location.href='index.php';</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Navbar with Modal</title>
    <link rel="stylesheet" href="frontend/css/navbar.css?v=1.1">
    <link rel="stylesheet" href="frontend/css/collab-modal.css?v=1.1">
    <link rel="stylesheet" href="../css/navbar.css?v=1.2">
    <link rel="stylesheet" href="../css/collab-modal.css?v=1.1">
    <!-- <link rel="stylesheet" href="frontend/javascript/collab-success.js?v=1.0"> -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar">
        <div class="logo"><a href="<?= $base_url ?>/index.php">
                <span class="logo-red">Team</span>
                <div class="logo-text">
                    <h1>Yulsa<span class="trademark">®</span></h1>
                </div>
            </a>
        </div>
        <div class="nav-links">
            <ul class="links">
                <li><a href="<?= $base_url ?>/index.php">Home</a></li>
                <li><a href="<?= $base_url ?>/services.php">Services</a></li>
                <li><a href="<?= $base_url ?>/about-us.php">About Us</a></li>
                <li><a href="<?= $base_url ?>/blogs.php">Blogs</a></li>
                <li><a href="<?= $base_url ?>/contact.php">Contact</a></li>
            </ul>
            <a href="#" class="cta-button" onclick="openModal()">Collaborate With Us</a>
        </div>
        <div class="hamburger" onclick="toggleMenu()">
            <div class="line"></div>
            <div class="line"></div>
            <div class="line"></div>
        </div>
    </nav>

    <!-- Modal Form -->
    <div id="collaborateModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Collaborate With Us</h2>
                <button class="close-btn" onclick="closeModal()">&times;</button>
            </div>

            <div class="modal-body">
                <!-- <div id="success-message" class="hidden">Thanks for Collaboration!</div> -->
                <form id="collaborateForm" action="index.php" method="POST">
                    <div class="form-group">
                        <label for="name">Full Name</label>
                        <input type="text" id="name" name="name" placeholder="Enter your full name" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" placeholder="Enter your email" required>
                    </div>

                    <div class="form-group">
                        <label for="business-info">Associated Business Info</label>
                        <input type="text" id="business-info" name="business-info" placeholder="Enter your business info" required>
                    </div>

                    <div class="form-group">
                        <label>Interested Services:</label>
                        <div>
                            <label><input type="checkbox" name="services[]" value="Accounting & Bookkeeping"> Accounting & Bookkeeping</label>
                        </div>
                        <div>
                            <label><input type="checkbox" name="services[]" value="AR & AP Management"> AR & AP Management</label>
                        </div>
                        <div>
                            <label><input type="checkbox" name="services[]" value="Accounting Software Migration"> Accounting Software Migration</label>
                        </div>
                        <div>
                            <label><input type="checkbox" name="services[]" value="Management Reporting"> Management Reporting</label>
                        </div>
                        <div>
                            <label><input type="checkbox" name="services[]" value="Budgeting and Forecasting"> Budgeting and Forecasting</label>
                        </div>
                        <div>
                            <label><input type="checkbox" name="services[]" value="Taxes Filing"> Taxes Filing</label>
                        </div>
                        <div>
                            <label><input type="checkbox" name="services[]" value="Financial Modelling"> Financial Modelling</label>
                        </div>
                        <div>
                            <label>
                                <input type="checkbox" id="other-service-checkbox" onclick="toggleOtherService()"> Other Service
                            </label>
                        </div>
                        <div class="form-group hidden" id="other-service-group">
                            <label for="other-service">Please specify:</label>
                            <input type="text" id="other-service" name="other-service" placeholder="Enter your service">
                        </div>
                    </div>

                    <button type="submit" class="form-submit">Submit</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Toggle mobile menu
        function toggleMenu() {
            const navLinks = document.querySelector('.nav-links');
            const hamburger = document.querySelector('.hamburger');

            navLinks.classList.toggle('active'); // Show/hide nav-links
            hamburger.classList.toggle('open'); // Change hamburger to X icon

        }

        // Open modal
        function openModal() {
            document.getElementById('collaborateModal').style.display = 'block';
        }

        // Close modal
        function closeModal() {
            document.getElementById('collaborateModal').style.display = 'none';
        }

        // Close modal when clicking outside of it
        window.onclick = function(event) {
            const modal = document.getElementById('collaborateModal');
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        };

        // Toggle "Other Service" input field
        function toggleOtherService() {
            const checkbox = document.getElementById('other-service-checkbox');
            const otherServiceGroup = document.getElementById('other-service-group');
            const otherServiceInput = document.getElementById('other-service');
            
            if (checkbox.checked) {
                // Show the other service input field
                otherServiceGroup.classList.remove('hidden');
                otherServiceInput.focus(); // Focus on the input field
                otherServiceInput.required = true; // Make it required
                
                // Add smooth animation
                otherServiceGroup.style.opacity = '0';
                otherServiceGroup.style.transform = 'translateY(-10px)';
                setTimeout(() => {
                    otherServiceGroup.style.transition = 'all 0.3s ease';
                    otherServiceGroup.style.opacity = '1';
                    otherServiceGroup.style.transform = 'translateY(0)';
                }, 10);
            } else {
                // Hide the other service input field
                otherServiceGroup.style.transition = 'all 0.3s ease';
                otherServiceGroup.style.opacity = '0';
                otherServiceGroup.style.transform = 'translateY(-10px)';
                
                setTimeout(() => {
                    otherServiceGroup.classList.add('hidden');
                    otherServiceInput.value = ''; // Clear the input field
                    otherServiceInput.required = false; // Make it not required
                }, 300);
            }
        }
    </script>
    <style>
        .hidden {
            display: none;
        }
    </style>

    </style>
</body>

</html>