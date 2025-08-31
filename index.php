<!--------------------------------------------------------------Navbar Section ------------------------------------------------------>
<?php
include_once("frontend/header_footer/navbar.php");
?>

<!--------------------------------------------------------------CSS Section ------------------------------------------------------>
<link rel="stylesheet" href="frontend/css/homepageImage.css">
<link rel="stylesheet" href="frontend/css/services.css">
<link rel="stylesheet" href="frontend/css/about.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">




<!--------------------------------------------------------------Homepage Image Slider Section ------------------------------------------------------>
<section class="image-slideshow">
    <div class="slideshow-container">
        <div class="slide">
            <div class="dark-overlay"></div>
            <img src="frontend/images/homepage_img/homepage_image.webp" alt="Image 1">
        </div>
        <div class="slide">
            <div class="dark-overlay"></div>
            <img src="frontend/images/homepage_img/homepage_image2.jpg" alt="Image 2">
        </div>
        <div class="slide">
            <div class="dark-overlay"></div>
            <img src="frontend/images/homepage_img/homepage_image3.jpg" alt="Image 3">
        </div>
    </div>
    <!-- Text Overlay -->
    <div class="text-overlay">
        <h1>Empowering <span style="color: rgb(255, 255, 39);">businesses</span> with <span
                style="color: rgb(62, 255, 255);">cutting-edge</span> solutions</h1>
        <p>We transform challenges into opportunities through innovation, expertise, and strategic partnerships.</p>
        <a href="#our-services" class="cta-button">Discover how we can elevate your business →</a>
    </div>
</section>

<!--------------------------------------------------------------Our Services Section ------------------------------------------------------>
<section id="our-services" class="our-services">
    <div class="service-title">
        <h2>Our Services</h2>
    </div>
    <div class="service-description">
        We help you increase the efficiency and efficacy of your bookkeeping, reporting,
        forecasting and customer relationship management, giving you a clear technological advantage over your
        competitors.
    </div>
    <div class="services-names">
        <!-- Service Card 1 -->
        <div class="service-card">
            <img src="frontend/images/services_img/bookkeeping.png" alt="Bookkeeping Icon" class="service-icon">
            <h3>Accounting & Bookkeeping</h3>
            <p>
                Streamlined financial management with accurate and compliant record-keeping.
            </p>
        </div>

        <!-- Service Card 2 -->
        <div class="service-card">
            <img src="frontend/images/services_img/Tax-filing.jpg" alt="Tax Filing Icon" class="service-icon">
            <h3>Tax Filing</h3>
            <p>
                Accurate tax filing services to ensure compliance and maximize benefits.

            </p>
        </div>

        <!-- Service Card 3 -->
        <div class="service-card">
            <img src="frontend/images/services_img/account_payable.png" alt="Process Automation Icon" class="service-icon">
            <h3>Accounts Receivable and Accounts Payables</h3>
            <p>
                Efficient invoicing and payment management to optimize cash flow.
            </p>
        </div>

    </div>
    <div class="see-more">
        <hr>
        <a href="./services.php" class="see-more-btn">See More</a>
        <hr>
    </div>
</section>

<!--------------------------------------------------------------About Us Section ------------------------------------------------------>
<section class="about-section">
    <div class="about-image">
        <img src="frontend/images/about_img/about-us.webp" alt="Office Image">
    </div>
    <div class="about-content">
        <h2>About Team Yulsa</h2>
        <hr class="title-underline">
        <p>
            At Team Yulsa, we specialize in delivering innovative solutions in
            <span style="color: rgb(66, 1, 82); font-size: 1rem;">
                Financial Process Automation, Financial Reporting, Accounting & Bookkeeping, Virtual CFO services,
                Data Analysis, Data Visualization, Financial Modeling
            </span>, and Comprehensive Reporting for global businesses.
        </p>

        <p>
            Collaboration is at the heart of our approach. We are committed to providing tailored solutions that enhance
            operational efficiency and help our clients achieve their financial objectives with precision. We believe in building
            strategic partnerships to offer exceptional service and create long-term value for our clients.
        </p>
        <p>
            Our team is dedicated to continuously exploring opportunities for collaboration with businesses and professionals
            worldwide, enabling us to expand our capabilities and extend our global reach. Our commitment to innovation and excellence
            has made us a trusted partner for businesses seeking to enhance their financial management and operational efficiency.
        </p>
        <p>
            We invite you to discover how we can elevate your business through our comprehensive suite of services and our dedication
            to your success.
        </p>

</section>

<!--------------------------------------------------------------Why Choose Us Section ------------------------------------------------------>
<section class="why-choose-us" id="why_choose_us">
    <div class="container">
        <h2 class="section-title">Why Choose Us?</h2>
        <p class="section-subtitle">
            We deliver innovative, reliable, and customized accounting solutions tailored to your business needs.
        </p>
        <div class="features">
            <!-- Feature 1 -->
            <div class="feature-card">
                <img src="frontend/images/why_choose_img/explogo.png" alt="Experience Icon" class="feature-icon">
                <h3> Build Scalability </h3>


            </div>
            <!-- Feature 2 -->
            <div class="feature-card">
                <img src="frontend/images/why_choose_img/cost_saving.png" alt="Expert Team Icon" class="feature-icon">
                <h3>High Cost Savings
                </h3>
                <!-- <p>
            Our team of certified accountants and advisors is dedicated to ensuring your financial success.
          </p> -->
            </div>
            <!-- Feature 3 -->
            <div class="feature-card">
                <img src="frontend/images/why_choose_img/team_exp.png" alt="Custom Solutions Icon" class="feature-icon">
                <h3>Certified Team of Accountants
                </h3>
                <!-- <p>
            We provide personalized strategies to meet the unique needs of your business and industry.
          </p> -->
            </div>

            <!--Feature 4-->
            <div class="feature-card">
                <img src="frontend/images/why_choose_img/data_security.webp" alt="Custom Solutions Icon" class="feature-icon">
                <h3>Data Security
                </h3>
            </div>

            <!--Feature 5-->
            <div class="feature-card">
                <img src="frontend/images/why_choose_img/grow_without_overheads.png" alt="Custom Solutions Icon" class="feature-icon">
                <h3>Grow without Overheads
                </h3>
            </div>

            <!--Feature 6-->
            <div class="feature-card">
                <img src="frontend/images/why_choose_img/wide_industry_exp.png" alt="Custom Solutions Icon" class="feature-icon">
                <h3>Wide Industry Experience
                </h3>
            </div>

            <!--Feature 7-->
            <div class="feature-card">
                <img src="frontend/images/why_choose_img/flexible_staffing.jpg" alt="Custom Solutions Icon" class="feature-icon">
                <h3>Flexible Staffing
                </h3>
            </div>
        </div>
    </div>
</section>

<!--------------------------------------------------------------Blog Section ------------------------------------------------------>





<?php
include_once("frontend/blog-card/blog-card.php");
?>

<script src="frontend/javascript/homepageSliider.js"></script>
<?php
include_once("frontend/header_footer/footer.php");
?>