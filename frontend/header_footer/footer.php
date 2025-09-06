  <?php
    // Include db_config.php to get base_url variable
    if (!isset($base_url)) {
        include_once(__DIR__ . '/../../db_config.php');
    }
    ?>

  <link rel="stylesheet" href="frontend/css/footer.css?v=1.0">
  <link rel="stylesheet" href="../css/footer.css?v=1.0">

  <!--Footer Section-->
  <footer class="footer">
      <div class="footer-container">
          <div class="footer-logo">
              <div class="logo"><a href="<?= $base_url ?>/index.php">
                      <span class="logo-red">Team</span>
                      <div class="logo-text">
                          <h1>Yulsa<span class="trademark">®</span></h1>
                          <!-- <p>Pvt. Ltd.</p> -->
                      </div>
                  </a>
              </div>
              <p>
                  Our company is a leading provider of process automation, financial advisory, accounting and bookkeeping,
                  reporting requirements, virtual CFO, and dashboard preparation services. We pride ourselves on delivering
                  innovative solutions that help our clients streamline their operations and achieve their financial goals.
              </p>
          </div>

          <div class="footer-links">
              <h3>About Us</h3>
              <ul>
                  <li><a href="<?= $base_url ?>/index.php" class="active">Home</a></li>
                  <li><a href="<?= $base_url ?>/services.php">Services</a></li>
                  <li><a href="<?= $base_url ?>/about-us.php">About Us</a></li>
                  <li><a href="<?= $base_url ?>/blogs.php">Blogs</a></li>
                  <li><a href="<?= $base_url ?>/contact.php">Contact</a></li>
              </ul>
          </div>

          <div class="footer-contact">
              <h3>Contact Information</h3>
              <ul>
                  <li><span>&#9742;</span> +977 9866206950</li>
                  <li><span>&#9993;</span> info.teamyulsa@com</li>
                  <li><span>&#9873;</span> Koteswor Setiop Marga, Kathmandu</li>
              </ul>
              <h4>Connect with us:</h4>
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
      </div>
      <div class="footer-bottom">
          <p>©2024 Yulsa Advisor Pvt. Ltd. All rights reserved.</p>
      </div>
  </footer>