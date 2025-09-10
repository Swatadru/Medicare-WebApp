<?php
require_once '../backend/config/db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Medicare - Your Health, Our Priority</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Book appointments with top doctors, track medical records, and get online consultations with Medicare.">

    <!-- Google Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        :root {
            --primary: #2563eb;
            --primary-light: #3b82f6;
            --primary-dark: #1d4ed8;
            --secondary: #10b981;
            --dark: #1e293b;
            --darker: #0f172a;
            --light: #f8fafc;
            --lighter: #ffffff;
            --text: #334155;
            --text-light: #64748b;
            --border: #e2e8f0;
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-md: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --shadow-lg: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            --rounded-sm: 0.25rem;
            --rounded: 0.5rem;
            --rounded-md: 0.75rem;
            --rounded-lg: 1rem;
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            color: var(--text);
            background: var(--light);
            line-height: 1.6;
        }

        a {
            text-decoration: none;
            color: inherit;
            transition: var(--transition);
        }

        img {
            max-width: 100%;
            height: auto;
        }

        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Header */
        header {
            background: var(--lighter);
            box-shadow: var(--shadow-sm);
            padding: 15px 0;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .header-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .logo {
            font-size: 24px;
            font-weight: 700;
            color: var(--primary);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .logo i {
            font-size: 28px;
        }

        nav {
            display: flex;
            align-items: center;
            gap: 24px;
        }

        nav a {
            font-weight: 500;
            padding: 8px 0;
            position: relative;
        }

        nav a:hover {
            color: var(--primary);
        }

        nav a::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--primary);
            transition: var(--transition);
        }

        nav a:hover::after {
            width: 100%;
        }

        .login-btn {
            background: var(--primary);
            color: white;
            padding: 8px 20px;
            border-radius: var(--rounded);
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .login-btn:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: var(--shadow);
        }

        .mobile-menu-btn {
            display: none;
            background: none;
            border: none;
            font-size: 24px;
            color: var(--dark);
            cursor: pointer;
        }

        /* Hero Section */
        .hero {
            padding: 80px 0;
            background: linear-gradient(135deg, #f0f7ff 0%, #e6f0ff 100%);
            position: relative;
            overflow: hidden;
        }

        .hero-container {
            display: flex;
            align-items: center;
            gap: 40px;
        }

        .hero-text {
            flex: 1;
            max-width: 600px;
        }

        .hero-text h1 {
            font-size: 48px;
            font-weight: 700;
            line-height: 1.2;
            margin-bottom: 20px;
            color: var(--darker);
        }

        .hero-text p {
            font-size: 18px;
            color: var(--text-light);
            margin-bottom: 32px;
        }

        .hero-buttons {
            display: flex;
            gap: 16px;
            margin-bottom: 40px;
        }

        .btn {
            padding: 12px 28px;
            border-radius: var(--rounded);
            font-weight: 600;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
            box-shadow: var(--shadow);
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .btn-outline {
            border: 2px solid var(--primary);
            color: var(--primary);
        }

        .btn-outline:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-2px);
            box-shadow: var(--shadow);
        }

        .stats {
            display: flex;
            gap: 32px;
        }

        .stat-item {
            display: flex;
            flex-direction: column;
        }

        .stat-number {
            font-size: 32px;
            font-weight: 700;
            color: var(--primary);
        }

        .stat-label {
            font-size: 14px;
            color: var(--text-light);
        }

        .hero-image {
            flex: 1;
            position: relative;
            z-index: 1;
        }

        .hero-image img {
            border-radius: var(--rounded-lg);
            box-shadow: var(--shadow-lg);
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }

        /* Features Section */
        .features {
            padding: 100px 0;
            background: var(--lighter);
        }

        .section-title {
            text-align: center;
            margin-bottom: 60px;
        }

        .section-title h2 {
            font-size: 36px;
            font-weight: 700;
            color: var(--darker);
            margin-bottom: 16px;
        }

        .section-title p {
            font-size: 18px;
            color: var(--text-light);
            max-width: 700px;
            margin: 0 auto;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }

        .feature {
            background: var(--lighter);
            border-radius: var(--rounded-md);
            padding: 40px 30px;
            text-align: center;
            transition: var(--transition);
            border: 1px solid var(--border);
        }

        .feature:hover {
            transform: translateY(-10px);
            box-shadow: var(--shadow-lg);
            border-color: transparent;
        }

        .feature-icon {
            width: 80px;
            height: 80px;
            background: rgba(37, 99, 235, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px;
        }

        .feature-icon i {
            font-size: 36px;
            color: var(--primary);
        }

        .feature h3 {
            font-size: 22px;
            font-weight: 600;
            margin-bottom: 16px;
            color: var(--darker);
        }

        .feature p {
            color: var(--text-light);
        }

        /* Trust Section */
        .trust {
            padding: 80px 0;
            background: var(--light);
        }

        .trust-logos {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
            gap: 40px;
            margin-top: 40px;
        }

        .trust-logo {
            height: 40px;
            filter: grayscale(100%);
            opacity: 0.7;
            transition: var(--transition);
        }

        .trust-logo:hover {
            filter: grayscale(0);
            opacity: 1;
        }

        /* Testimonials */
        .testimonials {
            padding: 100px 0;
            background: var(--lighter);
        }

        .testimonials-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }

        .testimonial {
            background: var(--lighter);
            border-radius: var(--rounded-md);
            padding: 30px;
            box-shadow: var(--shadow);
            position: relative;
        }

        .testimonial::before {
            content: '"';
            position: absolute;
            top: 20px;
            left: 20px;
            font-size: 60px;
            color: var(--primary-light);
            opacity: 0.2;
            font-family: serif;
            line-height: 1;
        }

        .testimonial-content {
            margin-bottom: 20px;
            color: var(--text);
            position: relative;
            z-index: 1;
        }

        .testimonial-author {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .author-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            overflow: hidden;
        }

        .author-info h4 {
            font-weight: 600;
            margin-bottom: 4px;
        }

        .author-info p {
            font-size: 14px;
            color: var(--text-light);
        }

        /* CTA Section */
        .cta {
            padding: 100px 0;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            text-align: center;
        }

        .cta h2 {
            font-size: 36px;
            margin-bottom: 20px;
        }

        .cta p {
            font-size: 18px;
            max-width: 700px;
            margin: 0 auto 40px;
            opacity: 0.9;
        }

        .cta-btn {
            background: white;
            color: var(--primary);
            padding: 16px 40px;
            font-size: 18px;
            font-weight: 600;
            border-radius: var(--rounded);
            box-shadow: var(--shadow-lg);
        }

        .cta-btn:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-lg);
        }

        /* Footer */
        footer {
            background: var(--darker);
            color: white;
            padding: 80px 0 30px;
        }

        .footer-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 40px;
            margin-bottom: 60px;
        }

        .footer-col h3 {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 20px;
            color: white;
        }

        .footer-col ul {
            list-style: none;
        }

        .footer-col li {
            margin-bottom: 12px;
        }

        .footer-col a {
            color: #cbd5e1;
        }

        .footer-col a:hover {
            color: white;
        }

        .social-links {
            display: flex;
            gap: 16px;
            margin-top: 20px;
        }

        .social-links a {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: var(--transition);
        }

        .social-links a:hover {
            background: var(--primary);
            transform: translateY(-3px);
        }

        .footer-bottom {
            text-align: center;
            padding-top: 30px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            color: #94a3b8;
            font-size: 14px;
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            .hero-container {
                flex-direction: column;
                text-align: center;
            }

            .hero-buttons, .stats {
                justify-content: center;
            }

            .hero-image {
                margin-top: 40px;
            }
        }

        @media (max-width: 768px) {
            nav {
                display: none;
            }

            .mobile-menu-btn {
                display: block;
            }

            .hero-text h1 {
                font-size: 36px;
            }

            .section-title h2 {
                font-size: 30px;
            }
        }

        @media (max-width: 576px) {
            .hero-buttons {
                flex-direction: column;
                gap: 12px;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }

            .stats {
                flex-direction: column;
                gap: 20px;
            }

            .feature {
                padding: 30px 20px;
            }
        }
    </style>
</head>
<body>

<header>
    <div class="container header-container">
        <a href="index.php" class="logo">
            <i class="fas fa-heartbeat"></i>
            <span>Medicare</span>
        </a>
        
        <nav>
            <a href="index.php">Home</a>
            <a href="about.php">About</a>
            <a href="login.php">Services</a>
            <a href="login.php">Doctors</a>
            <a href="login.php">Contact</a>
            <a href="login.php" class="login-btn">
                <i class="fas fa-sign-in-alt"></i>
                <span>Login</span>
            </a>
        </nav>
        
        <button class="mobile-menu-btn">
            <i class="fas fa-bars"></i>
        </button>
    </div>
</header>

<section class="hero">
    <div class="container hero-container">
        <div class="hero-text">
            <h1>Your Health is Our Top Priority</h1>
            <p>Access premium healthcare services from the comfort of your home. Book appointments, consult doctors online, and manage your health records seamlessly.</p>
            
            <div class="hero-buttons">
                <a href="login.php" class="btn btn-primary">
                    <i class="fas fa-calendar-check"></i>
                    Book Appointment
                </a>
                <a href="register.php" class="btn btn-outline">
                    <i class="fas fa-user-plus"></i>
                    Register Now
                </a>
            </div>
            
            <div class="stats">
                <div class="stat-item">
                    <span class="stat-number">500+</span>
                    <span class="stat-label">Verified Doctors</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">10K+</span>
                    <span class="stat-label">Happy Patients</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">24/7</span>
                    <span class="stat-label">Support</span>
                </div>
            </div>
        </div>
        
        <div class="hero-image">
            <img src="https://imgs.search.brave.com/Usc9rC37B8zgsy-pWpSf8TrPIvheZ-wuHUXPADG8ksE/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly9jZG4z/ZC5pY29uc2NvdXQu/Y29tLzNkL3ByZW1p/dW0vdGh1bWIvZG9j/dG9yLXBvaW50aW5n/LXRvLXRoZS1sZWZ0/LXNpZGUtM2QtaWxs/dXN0cmF0aW9uLWRv/d25sb2FkLWluLXBu/Zy1ibGVuZC1mYngt/Z2x0Zi1maWxlLWZv/cm1hdHMtLXlvdW5n/LWJveS1wYWNrLXBy/b2Zlc3Npb25hbHMt/aWxsdXN0cmF0aW9u/cy0zODMzMTMyLnBu/Zz9mPXdlYnA" alt="Doctor and patient illustration">
        </div>
    </div>
</section>

<section class="features">
    <div class="container">
        <div class="section-title">
            <h2>Why Choose Medicare?</h2>
            <p>We provide comprehensive healthcare solutions tailored to your needs</p>
        </div>
        
        <div class="features-grid">
            <div class="feature">
                <div class="feature-icon">
                    <i class="fas fa-user-md"></i>
                </div>
                <h3>Expert Doctors</h3>
                <p>Access to board-certified physicians and specialists across 50+ medical fields.</p>
            </div>
            
            <div class="feature">
                <div class="feature-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <h3>Quick Appointments</h3>
                <p>Book same-day appointments and avoid long waiting times at clinics.</p>
            </div>
            
            <div class="feature">
                <div class="feature-icon">
                    <i class="fas fa-laptop-medical"></i>
                </div>
                <h3>Telemedicine</h3>
                <p>Consult with doctors via video call from the comfort of your home.</p>
            </div>
            
            <div class="feature">
                <div class="feature-icon">
                    <i class="fas fa-file-medical"></i>
                </div>
                <h3>Digital Records</h3>
                <p>Securely store and access your medical history anytime, anywhere.</p>
            </div>
            
            <div class="feature">
                <div class="feature-icon">
                    <i class="fas fa-pills"></i>
                </div>
                <h3>E-Prescriptions</h3>
                <p>Get digital prescriptions sent directly to your preferred pharmacy.</p>
            </div>
            
            <div class="feature">
                <div class="feature-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h3>Privacy First</h3>
                <p>Your health data is protected with enterprise-grade security measures.</p>
            </div>
        </div>
    </div>
</section>

<style>
    /* Trust Section Styles */
    
    .trust-logos {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        align-items: center;
        gap: 40px;
        padding: 20px 0;
    }
    
    .trust-logo {
        height: 102px;
        width: auto;
        object-fit: contain;
        filter: grayscale(100%);
        opacity: 0.7;
        transition: all 0.3s ease;
    }
    
    .trust-logo:hover {
        filter: grayscale(0);
        opacity: 1;
        transform: scale(1.05);
    }
    
    /* Responsive Adjustments */
    @media (max-width: 992px) {
        .trust {
            padding: 60px 0;
        }
        
        .trust-logos {
            gap: 30px;
        }
        
        .trust-logo {
            height: 50px;
        }
    }
    
    @media (max-width: 768px) {
        .trust .section-title h2 {
            font-size: 2rem;
        }
        
        .trust .section-title p {
            font-size: 1rem;
        }
        
        .trust-logos {
            gap: 25px;
        }
        
        .trust-logo {
            height: 40px;
        }
    }
    
    @media (max-width: 576px) {
        .trust {
            padding: 50px 0;
        }
        
        .trust-logos {
            gap: 20px;
            flex-wrap: wrap;
        }
        
        .trust-logo {
            height: 35px;
            max-width: 120px;
        }
    }
</style>

<section class="trust">
    <div class="container">
        <div class="section-title">
            <h2>Trusted by Leading Healthcare Providers</h2>
            <p>Partnered with the best hospitals and medical institutions to deliver exceptional care</p>
        </div>
        
        <div class="trust-logos">
            <img src="https://www.apolloinformationcentre.com/wp-content/uploads/2019/07/int-hdr-apollo-hospital-1.jpg" alt="Apollo Hospitals" class="trust-logo">
            <img src="https://hoh.care/img/hospital/Fortis%20Hospital%20BG%20Road%20Bangalore.png" alt="Fortis Hospitals" class="trust-logo">
            <img src="https://imgs.search.brave.com/xaaIHFRUHqQLLktUbqb_zoaprHJ6x-ISnMU-yRkFjy8/rs:fit:500:0:1:0/g:ce/aHR0cHM6Ly9zZWxh/bmdvci50cmF2ZWwv/d3AtY29udGVudC91/cGxvYWRzLzIwMjEv/MDEvY29sdW1iaWEt/YXNpYS1rbGFuZy1t/YWluLWJ1aWxkaW5n/LXRvdXJpc20tc2Vs/YW5nb3IuanBn" alt="Columbia Asia" class="trust-logo">
            <img src="https://imgs.search.brave.com/BA7cu3PJQQgi_wMy7AIRFG7Y8pHUBBuZzvPRme-Q4BA/rs:fit:500:0:1:0/g:ce/aHR0cHM6Ly93d3cu/bGl2b250YWdsb2Jh/bC5jb20vd3AtY29u/dGVudC91cGxvYWRz/LzIwMTgvMTAvTWFu/aXBhbC1Ib3NwaXRh/bHMtaW4tQmVuZ2Fs/dXJ1LnBuZw" alt="Manipal Hospitals" class="trust-logo">
            <img src="https://imgs.search.brave.com/uEX4VceOqj8yYCn6koHAPkNkao49ltlUeJj8w9KZt3s/rs:fit:500:0:1:0/g:ce/aHR0cHM6Ly93d3cu/am9pbnRyZXBsYWNl/bWVudHN1cmdlcnlo/b3NwaXRhbGluZGlh/LmNvbS9ob3NwaXRh/bC9uYXJheWFuYS1p/bWFnZXMvbmFyYXlh/bmEtaGVhbHRoLWJh/bm5lci5qcGc" alt="Narayana Health" class="trust-logo">
        </div>
    </div>
</section>

<section class="testimonials">
    <div class="container">
        <div class="section-title">
            <h2>What Our Patients Say</h2>
            <p>Hear from people who have experienced our services</p>
        </div>
        
        <div class="testimonials-grid">
            <div class="testimonial">
                <div class="testimonial-content">
                    "Medicare made it so easy to consult with a specialist. I got an appointment the same day and the doctor was extremely knowledgeable."
                </div>
                <div class="testimonial-author">
                    <div class="author-avatar">
                        <img src="assets\images\Sudipa.jpg" alt="Sudipa Deb">
                    </div>
                    <div class="author-info">
                        <h4>Sudipa Deb</h4>
                        <p>Hypertension Patient</p>
                    </div>
                </div>
            </div>
            
            <div class="testimonial">
                <div class="testimonial-content">
                    "The telemedicine feature saved me hours of travel time. The video consultation was as effective as an in-person visit."
                </div>
                <div class="testimonial-author">
                    <div class="author-avatar">
                        <img src="assets\images\WhatsApp Image 2025-08-01 at 22.50.37_2a126ae2.jpg" alt="Ananya Saha">
                    </div>
                    <div class="author-info">
                        <h4>Ananya Saha</h4>
                        <p>Diabetes Patient</p>
                    </div>
                </div>
            </div>
            
            <div class="testimonial">
                <div class="testimonial-content">
                    "Having all my medical records in one place is a game-changer. No more carrying files to every doctor's appointment."
                </div>
                <div class="testimonial-author">
                    <div class="author-avatar">
                        <img src="assets\images\Screenshot 2025-08-03 202627.png" alt="Subhoprasad Bhattacharyya">
                    </div>
                    <div class="author-info">
                        <h4>Subhoprasad Bhattacharyya</h4>
                        <p>Pediatric Care</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="cta">
    <div class="container">
        <h2>Ready to Take Control of Your Health?</h2>
        <p>Join thousands of patients who are managing their healthcare smarter with Medicare</p>
        <a href="register.php" class="btn cta-btn">Get Started Today</a>
    </div>
</section>

<footer>
    <div class="container">
        <div class="footer-container">
            <div class="footer-col">
                <h3>Medicare</h3>
                <p>Your trusted partner in healthcare. We're committed to making quality healthcare accessible and affordable.</p>
                <div class="social-links">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
            
            <div class="footer-col">
                <h3>Quick Links</h3>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="about.php">About Us</a></li>
                    <li><a href="services.php">Services</a></li>
                    <li><a href="doctors.php">Our Doctors</a></li>
                    <li><a href="contact.php">Contact</a></li>
                </ul>
            </div>
            
            <div class="footer-col">
                <h3>Services</h3>
                <ul>
                    <li><a href="#">Doctor Appointments</a></li>
                    <li><a href="#">Online Consultations</a></li>
                    <li><a href="#">Health Checkups</a></li>
                    <li><a href="#">Medical Records</a></li>
                    <li><a href="#">Emergency Care</a></li>
                </ul>
            </div>
            
            <div class="footer-col">
                <h3>Contact Us</h3>
                <ul>
                    <li><i class="fas fa-map-marker-alt"></i> 7/3, Nilganj Road, Belgharia, Kolkata -> 700056</li>
                    <li><i class="fas fa-phone"></i> +91 9330776539</li>
                    <li><i class="fas fa-envelope"></i> info@medicare.com</li>
                    <li><i class="fas fa-clock"></i> Mon-Fri: 24/7</li>
                </ul>
            </div>
        </div>
        
        <div class="footer-bottom">
            <p>&copy; 2025 Medicare. All rights reserved. | Designed with <i class="fas fa-heart" style="color: #ff6b6b;"></i> for better healthcare</p>
        </div>
    </div>
</footer>

<script>
    // Mobile menu toggle functionality
    document.querySelector('.mobile-menu-btn').addEventListener('click', function() {
        const nav = document.querySelector('nav');
        nav.style.display = nav.style.display === 'flex' ? 'none' : 'flex';
    });
    
    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            
            const targetId = this.getAttribute('href');
            if (targetId === '#') return;
            
            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                targetElement.scrollIntoView({
                    behavior: 'smooth'
                });
            }
        });
    });
</script>

</body>
</html>