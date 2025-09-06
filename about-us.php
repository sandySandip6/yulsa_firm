<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Primary Meta Tags -->
    <title>About Team Yulsa - Professional Accounting Firm | Our Mission, Vision & Expert Team</title>
    <meta name="title" content="About Team Yulsa - Professional Accounting Firm | Our Mission, Vision & Expert Team">
    <meta name="description" content="Learn about Team Yulsa, a leading accounting firm specializing in bookkeeping, tax filing, financial reporting, and virtual CFO services. Meet our expert team and discover our mission to empower businesses.">
    <meta name="keywords" content="about team yulsa, accounting firm team, professional accountants, financial advisors, bookkeeping experts, tax specialists, virtual CFO, business consulting, Nepal accounting team">
    <meta name="robots" content="index, follow">
    <meta name="language" content="English">
    <meta name="author" content="Team Yulsa">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://teamyulsa.com/about-us.php">
    <meta property="og:title" content="About Team Yulsa - Professional Accounting Firm">
    <meta property="og:description" content="Learn about Team Yulsa, a leading accounting firm with expert professionals specializing in comprehensive financial services for businesses worldwide.">
    <meta property="og:image" content="https://teamyulsa.com/frontend/images/about-og-image.jpg">
    <meta property="og:site_name" content="Team Yulsa">
    
    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="https://teamyulsa.com/about-us.php">
    <meta property="twitter:title" content="About Team Yulsa - Professional Accounting Firm">
    <meta property="twitter:description" content="Learn about Team Yulsa, a leading accounting firm with expert professionals specializing in comprehensive financial services.">
    <meta property="twitter:image" content="https://teamyulsa.com/frontend/images/about-og-image.jpg">
    
    <!-- Canonical URL -->
    <link rel="canonical" href="https://teamyulsa.com/about-us.php">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/frontend/images/favicon.ico">
    
    <!-- Preconnect to external domains -->
    <link rel="preconnect" href="https://cdnjs.cloudflare.com">
    <link rel="dns-prefetch" href="//cdnjs.cloudflare.com">
    
    <!-- Schema.org structured data for About Page -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "AboutPage",
        "name": "About Team Yulsa",
        "description": "Learn about Team Yulsa's mission, vision, and expert team of accounting professionals.",
        "url": "https://teamyulsa.com/about-us.php",
        "mainEntity": {
            "@type": "AccountingService",
            "name": "Team Yulsa",
            "description": "Professional accounting and financial services firm specializing in bookkeeping, tax filing, and virtual CFO services.",
            "foundingDate": "2019",
            "numberOfEmployees": "10-50",
            "slogan": "Empowering businesses with cutting-edge solutions"
        }
    }
    </script>
    
    <link rel="stylesheet" href="frontend/css/about-us.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>
<body>
<?php
include_once("db_config.php");
include_once("frontend/header_footer/navbar.php");

// Fetch team data from database
$query = "SELECT * FROM team ORDER BY created_at DESC";
$result = $conn->query($query);

$team_members = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $team_members[] = $row;
    }
}
?>

<!--------------------------------------------------------------About Us Section ------------------------------------------------------>
<section class="about-us" id="about-us">
    <div class="about-container">
        <!-- Image Section -->
        <div class="about-image">
            <img src="frontend/images/about_img/office_img.jpg" alt="Team Yulsa Professional Accounting Office - Modern workspace for financial services">
        </div>

        <!-- Content Section -->
        <div class="about-content">
            <h1>About Team Yulsa - Professional Accounting & Financial Services</h1>
            <p>
                At <strong>Yulsa Advisor Pvt. Ltd.</strong>, we believe in transforming businesses through innovative
                solutions and
                unparalleled expertise. With a team of seasoned professionals, we are committed to delivering exceptional
                services in bookkeeping, financial reporting, process automation, and beyond.
            </p>
            <p>
                Our mission is to empower businesses of all sizes to achieve financial clarity, operational efficiency, and
                sustainable growth. Whether you're a startup seeking strategic guidance or an established firm looking to
                streamline operations, we have the expertise and tools to make it happen.
            </p>

            <!-- <ul>
          <li><strong>Our Vision:</strong> To be a trusted global partner in financial and business consulting.</li>
          <li><strong>Our Mission:</strong> Deliver tailored solutions that drive value and innovation for our clients.
          </li>
          <li><strong>Core Values:</strong> Integrity, Excellence, Collaboration, and Innovation.</li>
        </ul> -->

            <a href="./contact.html" class="cta-button1">Contact Us</a>
        </div>
    </div>
</section>

<!--------------------------------------------------------------Our Mission, Vision, and Core Values Section ------------------------------------------------------>
<div class="row">
    <div class="card mission">
        <div class="icon">🎯</div>
        <h2>Our Mission</h2>
        <p>To deliver exceptional service and value to our customers, ensuring their satisfaction and success.</p>
    </div>

    <div class="card vision">
        <div class="icon">🌟</div>
        <h2>Our Vision</h2>
        <p>Our goal is to empower small and mid-sized companies with the same access to outsourcing resources that large firms
            enjoy. We are confident that our motivated team and strategic insights will help our clients achieve success and maximize
            competitiveness through continuous improvement. By treating our clients' businesses as our own, we strive to deliver
            exceptional results.</p>
    </div>

    <div class="card core-values">
        <div class="icon">🤝</div>
        <h2>Core Values</h2>
        <p>Integrity, teamwork, and commitment are at the heart of everything we do.</p>
    </div>
</div>

<!--------------------------------------------------------------Our Team Section ------------------------------------------------------>
<section class="team-section">
    <h2>Meet Our Expert Accounting Team</h2>
    <div class="team-container">
        <?php if (!empty($team_members)): ?>
            <?php foreach ($team_members as $member): ?>
                <div class="team-member">
                    <?php 
                    // Set image path - use database image if available, otherwise use default
                    $image_path = !empty($member['image']) ? "admin/uploads/team/" . $member['image'] : "frontend/images/team_photos/default.png";
                    ?>
                    <img src="<?php echo $image_path; ?>" alt="<?php echo htmlspecialchars($member['name']); ?> - Professional Accountant at Team Yulsa">
                    <h3><?php echo htmlspecialchars($member['name']); ?></h3>
                    <p><?php echo htmlspecialchars($member['position']); ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?> 
            <div class="team-member">
                <img src="frontend/images/team_photos/default.png" alt="Team Yulsa Professional Accountants - Coming Soon">
                <h3>Professional Team Coming Soon</h3>
                <p>Our expert accounting team will be featured here soon</p> 
            </div>
        <?php endif; ?> 
    </div>
</section>

<!-----------------------------------------Our Achievements Section ------------------------------------------------------>
<section class="achievements-section">
    <h2>Our Achievements</h2>
    <div class="achievements-container">
        <div class="achievement">
            <div class="counter-container">
                <span class="counter" data-target="30">0</span>
                <span class="plus">+</span>
            </div>
            <p>Projects Completion</p>
        </div>
        <div class="achievement">
            <div class="counter-container">
                <span class="counter" data-target="20">0</span>
                <span class="plus">+</span>
            </div>
            <p>Clients Served</p>
        </div>
        <div class="achievement">
            <div class="counter-container">
                <span class="counter" data-target="5">0</span>
                <span class="plus">+</span>
            </div>
            <p>Years of Industry Experience</p>
        </div>
        <div class="achievement">
            <!-- <div class="counter-container">
          <span class="counter" data-target="100">0</span>
          <span class="plus">%</span>
        </div> -->
            <p>Zero Tolerance Policy for Financial Errors</p>
        </div>
</section>

<?php
include_once("frontend/header_footer/footer.php");

// Close database connection
$conn->close();
?>
<script src="frontend/javascript/counter_animation.js"></script>
</body>
</html>

