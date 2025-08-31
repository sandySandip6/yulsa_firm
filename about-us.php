<?php
include_once("frontend/header_footer/navbar.php");
?>
<link rel="stylesheet" href="frontend/css/about-us.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

<!--------------------------------------------------------------About Us Section ------------------------------------------------------>
<section class="about-us" id="about-us">
    <div class="about-container">
        <!-- Image Section -->
        <div class="about-image">
            <img src="frontend/images/about_img/office_img.jpg" alt="Our Team">
        </div>

        <!-- Content Section -->
        <div class="about-content">
            <h2>About Us</h2>
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
    <h2>Meet Our Team</h2>
    <div class="team-container">
        <div class="team-member">
            <img src="frontend/images/team_photos/CA Sagun Jung Rana.png" alt="Sagun Jung Rana">
            <h3>CA. Sagun Jung Rana</h3>
            <p>Founder</p>
        </div>
        <div class="team-member">
            <img src="frontend/images/team_photos/ManojLuitel.png" alt="Manoj Luitel">
            <h3>Manoj Luitel</h3>
            <p>Accounting Head</p>
        </div>
        <div class="team-member">
            <img src="frontend/images/team_photos/Prabesh Bhusal.png" alt="Prabesh Bhusal">
            <h3>Prabesh Bhusal</h3>
            <p>Senior Accountant</p>
        </div>
        <div class="team-member">
            <img src="frontend/images/team_photos/Sarjan Jung Rana.png" alt="Sarjan Jung Rana">
            <h3>Sarjan Jung Rana</h3>
            <p>Local Taxes Manager</p>
        </div>
        <div class="team-member">
            <img src="frontend/images/team_photos/Anubhav Kumar Mahato.png" alt="Anubhav Kumal Mahato">
            <h3>Anubhav Kumar Mahato</h3>
            <p>Senior Accountant</p>
        </div>
        <div class="team-member">
            <img src="frontend/images/team_photos/Nisha Khanal.jpg" alt="Nisha Khanal">
            <h3>Nisha Khanal</h3>
            <p>Financial Reporting Consultant</p>
        </div>
        <div class="team-member">
            <img src="frontend/images/team_photos/bhakta_photo.png" alt="Samrat Hamal">
            <h3>Samrat Hamal</h3>
            <p>IT Specialist</p>
        </div>
    </div>
</section>

<!--------------------------------------------------------------Our Achievements Section ------------------------------------------------------>
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
?>
<script src="frontend/javascript/counter_animation.js"></script>

