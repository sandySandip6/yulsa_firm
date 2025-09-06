<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Team Yulsa | Professional Accounting Services</title>
    <meta name="description" content="Get in touch with Team Yulsa for professional accounting services. Contact our expert team for bookkeeping, tax filing, and financial consulting solutions.">
    <meta name="keywords" content="contact team yulsa, accounting services contact, bookkeeping consultation, tax filing help, financial consulting contact">
    <link rel="canonical" href="https://teamyulsa.com/contact.php">
    <link rel="icon" type="image/x-icon" href="/frontend/images/favicon.ico">
</head>
<body>
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $conn->real_escape_string(trim($_POST['name']));
    $email = $conn->real_escape_string(trim($_POST['email']));
    $message = $conn->real_escape_string(trim($_POST['message']));

    if (!empty($name) && !empty($email) && !empty($message)) {
        $sql = "INSERT INTO contact_form (name, email, message) VALUES ('$name', '$email', '$message')";

        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Thanks for your message!'); window.location.href='index.php';</script>";
        } else {
            echo "<script>alert('Error: " . $conn->error . "'); window.location.href='index.php';</script>";
        }
    } else {
        echo "<script>alert('Please fill in all fields.'); window.location.href='contact.php';</script>";
    }
}

$conn->close();
?>

<?php
include_once("frontend/header_footer/navbar.php");
?>
<link rel="stylesheet" href="frontend/css/contact.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

<!--------------------------------------------------------------Contact Section ------------------------------------------------------>
<section class="contact-page">
    <div class="contact-header">
        <h1>Contact Us</h1>
        <p>We're here to help you! Get in touch with us for inquiries, support, or collaboration.</p>
    </div>

    <div class="contact-container">

        <!-- Contact Details Section -->
        <div class="contact-details">
            <h2>Get in Touch</h2>
            <ul>
                <li><span>&#9742;</span> +977 9866206950</li>
                <li><span>&#9993;</span> info.teamyulsa.com</li>
                <li><span>&#9873;</span> Koteswor Setiop Marga, Kathmandu</li>
                <li><span>&#128197;</span> Working Hours: Mon-Fri, 9-5 </li>
            </ul>
            <div class="social-icons">
                <a href="https://www.facebook.com" target="_blank" rel="noopener noreferrer" aria-label="Facebook">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="https://www.instagram.com" target="_blank" rel="noopener noreferrer" aria-label="Instagram">
                    <i class="fab fa-instagram"></i>
                </a>
                <a href="https://www.linkedin.com/company/team-yulsa/" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn">
                    <i class="fab fa-linkedin-in"></i>
                </a>
            </div>
        </div>

        <!-- Contact Form Section -->
        <div class="contact-form">
            <!-- <div class="warning-section">
                <h3 style="color: red;">This section doesn't work now</h3>
            </div> -->
            <h2>Send Us a Message</h2>
            <form id="contactForm" action="contact.php" method="POST">
                <input type="text" name="name" placeholder="Your Name" required>
                <input type="email" name="email" placeholder="Your Email" required>
                <textarea name="message" placeholder="Your Message" rows="5" required></textarea>
                <button type="submit">Submit</button>
            </form>
            <div id="successMessage" style="display: none; margin-top: 20px; color: green; text-align: center; padding: 10px; background-color: #d4edda; border: 1px solid #c3e6cb; border-radius: 5px;">
                Thank you! Your message has been sent successfully.
            </div>
        </div>
    </div>

    <!-- Map Section -->
    <div class="map-section">
        <h2>Find Us Here</h2>
        <p>!! Our office is located at opposite of Grammer Boarding College</p>
        <iframe src="https://www.google.com/maps/embed?pb=!1m28!1m12!1m3!1d2935.1538906142027!2d85.33877757462314!3d27
      .6794090261986!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!4m13!3e0!4m5!1s0x39eb19ecef2eedd1%3A0x668e25466241a9bd!2sKoteshwor%
      20Mahadevasthan%2C%20Mahadevsthan%20Marg%2C%20Kathmandu!3m2!1d27.6809461!2d85.34122959999999!4m5!1s0x39eb19ec4e52d0e5%3A0x61
      7ac9cd006fa653!2sM8HR%2BGM8%20Grammar%20School%2FCollege%2C%20Seti%20Op%20Marg%2C%20Kathmandu%2044600!3m2!1d27.6787845!2d85.
      3417253!5e1!3m2!1sen!2snp!4v1734163107629!5m2!1sen!2snp" width="100%" height="400" style="border:0;" allowfullscreen=""
            loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>

    <!-- FAQ Section -->
    <div class="faq-section">
        <h2>Frequently Asked Questions</h2>
        <details>
            <summary>What services do you offer?</summary>
            <p>We offer financial advisory, process automation, virtual CFO, accounting, and bookkeeping services.</p>
        </details>
        <details>
            <summary>How can I book a consultation?</summary>
            <p>You can contact us through the form above or call us directly to schedule a consultation.</p>
        </details>
        <details>
            <summary>Do you provide services for startups?</summary>
            <p>Yes, we specialize in offering financial solutions tailored to the needs of startups and small businesses.
            </p>
        </details>
    </div>

</section>

<?php
include_once("frontend/header_footer/footer.php");

// Close database connection
$conn->close();
?>

<!--Script for form submission-->
<script>
    document.getElementById('contactForm').addEventListener('submit', function(event) {
        // Don't prevent default - let the form submit to PHP
        // The PHP will handle the form submission and show appropriate messages
    });
</script>
</body>
</html>