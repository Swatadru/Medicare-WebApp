<?php
$page_title = "About Us - Medicare";
$page_description = "Learn about Medicare's mission, values, and commitment to quality healthcare services.";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $page_title; ?></title>
  <meta name="description" content="<?php echo $page_description; ?>">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
  <style>
    :root {
      --primary: #3498db;
      --secondary: #2ecc71;
      --dark: #2c3e50;
      --light: #f8fafc;
      --gray: #95a5a6;
      --danger: #e74c3c;
    }
    
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    
    body {
      font-family: 'Poppins', sans-serif;
      color: #333;
      line-height: 1.6;
      background-color: var(--light);
    }
    
    .container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 20px;
    }
    
    /* Header Styles */
    header {
      background: linear-gradient(135deg, var(--primary), var(--secondary));
      color: white;
      padding: 80px 0 120px;
      text-align: center;
      position: relative;
      overflow: hidden;
    }
    
    header::after {
      content: '';
      position: absolute;
      bottom: -50px;
      left: 0;
      width: 100%;
      height: 100px;
      background-color: var(--light);
      transform: skewY(-3deg);
      z-index: 1;
    }
    
    .header-content {
      position: relative;
      z-index: 2;
    }
    
    h1 {
      font-family: 'Playfair Display', serif;
      font-size: 3.5rem;
      margin-bottom: 20px;
      font-weight: 700;
    }
    
    .subtitle {
      font-size: 1.2rem;
      max-width: 700px;
      margin: 0 auto;
      opacity: 0.9;
    }
    
    /* Mission Section */
    .mission {
      padding: 80px 0;
      background-color: white;
    }
    
    .section-title {
      text-align: center;
      margin-bottom: 50px;
    }
    
    .section-title h2 {
      font-family: 'Playfair Display', serif;
      font-size: 2.5rem;
      color: var(--dark);
      margin-bottom: 15px;
      position: relative;
      display: inline-block;
    }
    
    .section-title h2::after {
      content: '';
      position: absolute;
      bottom: -10px;
      left: 50%;
      transform: translateX(-50%);
      width: 80px;
      height: 3px;
      background: linear-gradient(to right, var(--primary), var(--secondary));
    }
    
    .section-title p {
      color: var(--gray);
      max-width: 700px;
      margin: 0 auto;
    }
    
    .mission-content {
      display: flex;
      align-items: center;
      gap: 50px;
    }
    
    .mission-text {
      flex: 1;
    }
    
    .mission-image {
      flex: 1;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 15px 30px rgba(0,0,0,0.1);
    }
    
    .mission-image img {
      width: 100%;
      height: auto;
      display: block;
      transition: transform 0.5s ease;
    }
    
    .mission-image:hover img {
      transform: scale(1.05);
    }
    
    /* Values Section */
    .values {
      padding: 80px 0;
      background-color: var(--light);
    }
    
    .values-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 30px;
      margin-top: 50px;
    }
    
    .value-card {
      background: white;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.05);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .value-card:hover {
      transform: translateY(-10px);
      box-shadow: 0 15px 30px rgba(0,0,0,0.1);
    }
    
    .value-icon {
      font-size: 2.5rem;
      color: var(--primary);
      margin-bottom: 20px;
    }
    
    .value-card h3 {
      font-size: 1.5rem;
      margin-bottom: 15px;
      color: var(--dark);
    }
    
    /* Team Section */
    .team {
      padding: 80px 0;
      background-color: white;
    }
    
    .team-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 30px;
      margin-top: 50px;
    }
    
    .team-member {
      text-align: center;
      background: var(--light);
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 5px 15px rgba(0,0,0,0.05);
      transition: transform 0.3s ease;
    }
    
    .team-member:hover {
      transform: translateY(-10px);
    }
    
    .member-image {
      width: 100%;
      height: 600px;
      overflow: hidden;
    }
    
    .member-image img {
      width: 40%;
      height: 100%;
      object-fit: cover;
      transition: transform 0.5s ease;
    }
    
    .team-member:hover .member-image img {
      transform: scale(1.1);
    }
    
    .member-info {
      padding: 20px;
    }
    
    .member-info h3 {
      font-size: 1.3rem;
      margin-bottom: 5px;
      color: var(--dark);
    }
    
    .member-info p {
      color: var(--primary);
      font-weight: 500;
    }
    
    /* Responsive Styles */
    @media (max-width: 992px) {
      h1 {
        font-size: 2.8rem;
      }
      
      .mission-content {
        flex-direction: column;
      }
    }
    
    @media (max-width: 768px) {
      header {
        padding: 60px 0 100px;
      }
      
      h1 {
        font-size: 2.2rem;
      }
      
      .subtitle {
        font-size: 1rem;
      }
      
      .section-title h2 {
        font-size: 2rem;
      }
    }
    
    @media (max-width: 576px) {
      header {
        padding: 50px 0 80px;
      }
      
      h1 {
        font-size: 1.8rem;
      }
    }
  </style>
</head>
<body>
  <?php include 'components/header.php'; ?>
  <!-- Header Section -->
  <header>
    <div class="container">
      <div class="header-content">
        <h1>About Medicare</h1>
        <p class="subtitle">Committed to excellence in healthcare with a patient-first approach for over 15 years</p>
      </div>
    </div>
  </header>
  
  <!-- Mission Section -->
  <section class="mission">
    <div class="container">
      <div class="section-title">
        <h2>Our Mission</h2>
        <p>We strive to make quality healthcare accessible and affordable for everyone</p>
      </div>
      
      <div class="mission-content">
        <div class="mission-text">
          <p>Founded in 2008, Medicare has grown from a single clinic to a network of healthcare facilities serving communities across the region. Our journey has been guided by a simple principle: every patient deserves compassionate, high-quality care regardless of their background or financial situation.</p>
          <br>
          <p>Today, we operate 12 hospitals, 45 clinics, and employ over 2,000 healthcare professionals dedicated to improving lives through innovative medical solutions and personalized care.</p>
          <br>
          <p>Our state-of-the-art facilities combine cutting-edge technology with a human touch, ensuring that patients receive not just treatment, but genuine care and support throughout their healthcare journey.</p>
        </div>
        <div class="mission-image">
          <img src="https://images.unsplash.com/photo-1579684385127-1ef15d508118?ixlib=rb-1.2.1&auto=format&fit=crop&w=1000&q=80" alt="Medical team discussing patient care">
        </div>
      </div>
    </div>
  </section>
  
  <!-- Values Section -->
  <section class="values">
    <div class="container">
      <div class="section-title">
        <h2>Our Core Values</h2>
        <p>The principles that guide everything we do</p>
      </div>
      
      <div class="values-grid">
        <div class="value-card">
          <div class="value-icon">❤️</div>
          <h3>Compassion</h3>
          <p>We treat every patient with empathy, dignity, and respect, understanding that healthcare is as much about caring as it is about curing.</p>
        </div>
        
        <div class="value-card">
          <div class="value-icon">🏆</div>
          <h3>Excellence</h3>
          <p>We pursue the highest standards in medical care through continuous learning, innovation, and quality improvement.</p>
        </div>
        
        <div class="value-card">
          <div class="value-icon">🤝</div>
          <h3>Integrity</h3>
          <p>We maintain the highest ethical standards, being honest and transparent in all our interactions and decisions.</p>
        </div>
        
        <div class="value-card">
          <div class="value-icon">🌍</div>
          <h3>Community</h3>
          <p>We're committed to serving and improving the health of our communities through outreach and education programs.</p>
        </div>
        
        <div class="value-card">
          <div class="value-icon">💡</div>
          <h3>Innovation</h3>
          <p>We embrace new technologies and treatment methods to provide the most effective care possible.</p>
        </div>
        
        <div class="value-card">
          <div class="value-icon">👨‍👩‍👧‍👦</div>
          <h3>Teamwork</h3>
          <p>We collaborate across disciplines to provide comprehensive, coordinated care for our patients.</p>
        </div>
      </div>
    </div>
  </section>
  
  <!-- Team Section -->
  <section class="team">
    <div class="container">
      <div class="section-title">
        <h2>Meet Our Leadership</h2>
        <p>The experienced professionals guiding our organization</p>
      </div>
      
      <div class="team-grid">
        <div class="team-member">
          <div class="member-image">
            <img src="assets\images\AS9_4406.jpg" alt="Dr. Swatadru Paul">
          </div>
          <div class="member-info">
            <h3>Dr. Swatadru Paul</h3>
            <p>Chief Medical Officer</p>
          </div>
        </div>        
      </div>
    </div>
  </section>
    <!-- Footer Section -->
     <footer class="site-footer">
    <div class="container">
        <div class="footer-grid">
            <!-- Column 1: About -->
            <div class="footer-column">
                <h3 class="footer-title">About Medicare</h3>
                <div class="footer-logo">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#3498db" width="24" height="24">
                        <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-1 16H6c-.55 0-1-.45-1-1V6c0-.55.45-1 1-1h12c.55 0 1 .45 1 1v12c0 .55-.45 1-1 1zm-4.44-6.19l-2.35 3.02-1.56-1.88c-.2-.25-.58-.24-.78.01l-1.74 2.23c-.26.33-.02.81.39.81h8.98c.41 0 .65-.47.4-.8l-2.55-3.39c-.19-.26-.59-.26-.79 0z"/>
                    </svg>
                    <span>Medicare</span>
                </div>
                <p>Committed to excellence in healthcare with a patient-first approach for over 15 years.</p>
                <div class="social-links">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                </div>
            </div>

            <!-- Column 2: Quick Links -->
            <div class="footer-column">
                <h3 class="footer-title">Quick Links</h3>
                <ul class="footer-links">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="about.php">About Us</a></li>
                    <li><a href="services.php">Services</a></li>
                    <li><a href="doctors.php">Our Doctors</a></li>
                    <li><a href="contact.php">Contact</a></li>
                    <li><a href="faq.php">FAQ</a></li>
                </ul>
            </div>

            <!-- Column 3: Services -->
            <div class="footer-column">
                <h3 class="footer-title">Our Services</h3>
                <ul class="footer-links">
                    <li><a href="#">Emergency Care</a></li>
                    <li><a href="#">Primary Care</a></li>
                    <li><a href="#">Specialist Referrals</a></li>
                    <li><a href="#">Diagnostic Services</a></li>
                    <li><a href="#">Surgical Services</a></li>
                    <li><a href="#">Health Checkups</a></li>
                </ul>
            </div>

            <!-- Column 4: Contact -->
            <div class="footer-column">
                <h3 class="footer-title">Contact Us</h3>
                <ul class="footer-contact">
                    <li>
                        <i class="fas fa-map-marker-alt"></i>
                        <span>7/3, Nilganj Road, Belgharia, Kolkata -> 700056</span>
                    </li>
                    <li>
                        <i class="fas fa-phone-alt"></i>
                        <span> +91 9330776539</span>
                    </li>
                    <li>
                        <i class="fas fa-envelope"></i>
                        <span>info@medicare.example</span>
                    </li>
                    <li>
                        <i class="fas fa-clock"></i>
                        <span>24/7 Emergency Services Available</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="footer-bottom">
            <div class="copyright">
                &copy; <?php echo date('Y'); ?> Medicare. All Rights Reserved.
            </div>
            <div class="legal-links">
                <a href="privacy.php">Privacy Policy</a>
                <a href="terms.php">Terms of Service</a>
                <a href="sitemap.php">Sitemap</a>
            </div>
        </div>
    </div>
</footer>

<style>
    /* Footer Styles */
    .site-footer {
        background: linear-gradient(135deg, #2c3e50, #34495e);
        color: #fff;
        padding: 60px 0 0;
        font-family: 'Poppins', sans-serif;
    }

    .footer-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 40px;
        margin-bottom: 40px;
    }

    .footer-column {
        margin-bottom: 30px;
    }

    .footer-title {
        font-size: 1.2rem;
        margin-bottom: 20px;
        position: relative;
        padding-bottom: 10px;
        font-weight: 600;
    }

    .footer-title::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: 0;
        width: 50px;
        height: 2px;
        background: linear-gradient(to right, #3498db, #2ecc71);
    }

    .footer-logo {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
    }

    .footer-logo svg {
        margin-right: 10px;
    }

    .footer-logo span {
        font-size: 1.5rem;
        font-weight: 700;
    }

    .footer-column p {
        margin-bottom: 20px;
        opacity: 0.8;
        line-height: 1.6;
    }

    .social-links {
        display: flex;
        gap: 15px;
    }

    .social-links a {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.1);
        color: #fff;
        transition: all 0.3s ease;
    }

    .social-links a:hover {
        background: #3498db;
        transform: translateY(-3px);
    }

    .footer-links {
        list-style: none;
    }

    .footer-links li {
        margin-bottom: 12px;
    }

    .footer-links a {
        color: rgba(255, 255, 255, 0.8);
        text-decoration: none;
        transition: all 0.3s ease;
        display: inline-block;
    }

    .footer-links a:hover {
        color: #fff;
        transform: translateX(5px);
    }

    .footer-contact {
        list-style: none;
    }

    .footer-contact li {
        display: flex;
        margin-bottom: 15px;
        align-items: flex-start;
    }

    .footer-contact i {
        margin-right: 10px;
        color: #3498db;
        margin-top: 3px;
    }

    .footer-contact span {
        opacity: 0.8;
        line-height: 1.5;
    }

    .footer-bottom {
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        padding: 20px 0;
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        align-items: center;
    }

    .copyright {
        opacity: 0.7;
        font-size: 0.9rem;
    }

    .legal-links {
        display: flex;
        gap: 20px;
    }

    .legal-links a {
        color: rgba(255, 255, 255, 0.7);
        text-decoration: none;
        font-size: 0.9rem;
        transition: all 0.3s ease;
    }

    .legal-links a:hover {
        color: #fff;
    }

    /* Font Awesome Icons (if not already included) */
    .fab, .fas {
        font-style: normal;
        font-weight: 400;
        font-family: "Font Awesome 5 Free";
    }

    @media (max-width: 768px) {
        .footer-grid {
            grid-template-columns: 1fr 1fr;
        }
        
        .footer-bottom {
            flex-direction: column;
            text-align: center;
            gap: 10px;
        }
    }

    @media (max-width: 480px) {
        .footer-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<!-- Font Awesome for icons (include this in your head if not already present) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</body>
</html>