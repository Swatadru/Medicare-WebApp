<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Healthcare Plans | Medicare</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    :root {
      --primary: #4361ee;
      --primary-dark: #3a0ca3;
      --primary-light: #4895ef;
      --secondary: #4cc9f0;
      --success: #38b000;
      --warning: #f1c40f;
      --danger: #ef233c;
      --light: #f8f9fa;
      --lighter: #ffffff;
      --dark: #14213d;
      --text: #2b2d42;
      --text-light: #64748b;
      --border: #e2e8f0;
    }

    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      font-family: 'Poppins', sans-serif;
    }

    body {
      background-color: #f5f7ff;
      background-image: radial-gradient(circle at 10% 20%, rgba(67, 97, 238, 0.05) 0%, rgba(255,255,255,1) 90%);
      color: var(--text);
      line-height: 1.6;
      min-height: 100vh;
    }

    .container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 2rem 1rem;
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    .page-header {
      text-align: center;
      margin-bottom: 3rem;
      max-width: 800px;
    }

    .page-header h1 {
      font-size: 2.5rem;
      color: var(--dark);
      margin-bottom: 1rem;
      background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }

    .page-header p {
      color: var(--text-light);
      font-size: 1.1rem;
    }

    .plans-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 2rem;
      width: 100%;
    }

    .plan-card {
      background: var(--lighter);
      border-radius: 16px;
      padding: 2.5rem 2rem;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
      transition: all 0.3s ease;
      position: relative;
      border: 1px solid var(--border);
      display: flex;
      flex-direction: column;
    }

    .plan-card:hover {
      transform: translateY(-10px);
      box-shadow: 0 15px 35px rgba(67, 97, 238, 0.1);
    }

    .plan-card.popular {
      border: 2px solid var(--warning);
      position: relative;
    }

    .popular-badge {
      position: absolute;
      top: -12px;
      right: 20px;
      background: var(--warning);
      color: white;
      padding: 0.5rem 1.5rem;
      border-radius: 20px;
      font-size: 0.8rem;
      font-weight: 600;
    }

    .plan-title {
      font-size: 1.5rem;
      font-weight: 600;
      color: var(--dark);
      margin-bottom: 1rem;
    }

    .plan-price {
      font-size: 2.5rem;
      font-weight: 700;
      margin-bottom: 1.5rem;
      color: var(--primary);
    }

    .plan-price span {
      font-size: 1rem;
      font-weight: 400;
      color: var(--text-light);
    }

    .plan-features {
      list-style: none;
      margin-bottom: 2rem;
      flex-grow: 1;
    }

    .plan-features li {
      padding: 0.75rem 0;
      border-bottom: 1px solid var(--border);
      display: flex;
      align-items: center;
      gap: 0.75rem;
    }

    .plan-features li i {
      color: var(--success);
      font-size: 1.1rem;
      width: 24px;
    }

    .btn-subscribe {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 0.5rem;
      padding: 1rem;
      border-radius: 8px;
      font-weight: 600;
      text-decoration: none;
      transition: all 0.3s ease;
      width: 100%;
      border: none;
      cursor: pointer;
    }

    .btn-primary {
      background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
      color: white;
    }

    .btn-primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 12px rgba(67, 97, 238, 0.25);
    }

    .btn-outline {
      background: transparent;
      color: var(--primary);
      border: 2px solid var(--primary);
    }

    .btn-outline:hover {
      background: rgba(67, 97, 238, 0.05);
    }

    .plan-benefits {
      margin-top: 3rem;
      background: var(--light);
      border-radius: 12px;
      padding: 2rem;
      width: 100%;
      max-width: 900px;
    }

    .benefits-title {
      font-size: 1.3rem;
      margin-bottom: 1.5rem;
      color: var(--dark);
      text-align: center;
    }

    .benefits-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 1.5rem;
    }

    .benefit-item {
      display: flex;
      align-items: flex-start;
      gap: 1rem;
    }

    .benefit-icon {
      background: rgba(67, 97, 238, 0.1);
      color: var(--primary);
      width: 40px;
      height: 40px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.2rem;
      flex-shrink: 0;
    }

    .benefit-content h4 {
      font-size: 1.1rem;
      margin-bottom: 0.5rem;
      color: var(--dark);
    }

    .benefit-content p {
      color: var(--text-light);
      font-size: 0.9rem;
    }

    @media (max-width: 768px) {
      .plans-grid {
        grid-template-columns: 1fr;
        max-width: 500px;
        margin: 0 auto;
      }
      
      .page-header h1 {
        font-size: 2rem;
      }
    }

    @media (max-width: 480px) {
      .container {
        padding: 1.5rem 1rem;
      }
      
      .page-header h1 {
        font-size: 1.8rem;
      }
      
      .plan-card {
        padding: 2rem 1.5rem;
      }
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="page-header">
      <h1>Healthcare Membership Plans</h1>
      <p>Choose the perfect plan for your health needs with flexible options for every lifestyle</p>
    </div>

    <div class="plans-grid">
      <div class="plan-card">
        <h3 class="plan-title">Basic</h3>
        <div class="plan-price">₹0 <span>/month</span></div>
        <ul class="plan-features">
          <li><i class="fas fa-check"></i> Free health articles & tips</li>
          <li><i class="fas fa-check"></i> Monthly newsletter</li>
          <li><i class="fas fa-check"></i> Basic health tracking</li>
          <li><i class="fas fa-check"></i> Community support</li>
        </ul>
        <a href="#" class="btn-subscribe btn-outline">Get Started</a>
      </div>

      <div class="plan-card popular">
        <div class="popular-badge">Most Popular</div>
        <h3 class="plan-title">Standard</h3>
        <div class="plan-price">₹299 <span>/month</span></div>
        <ul class="plan-features">
          <li><i class="fas fa-check"></i> All Basic features</li>
          <li><i class="fas fa-check"></i> Doctor consultations (2/month)</li>
          <li><i class="fas fa-check"></i> Prescription management</li>
          <li><i class="fas fa-check"></i> Health record storage</li>
          <li><i class="fas fa-check"></i> 24/7 nurse support</li>
        </ul>
        <button class="btn-subscribe btn-primary">Choose Plan</button>
      </div>

      <div class="plan-card">
        <h3 class="plan-title">Premium</h3>
        <div class="plan-price">₹499 <span>/month</span></div>
        <ul class="plan-features">
          <li><i class="fas fa-check"></i> All Standard features</li>
          <li><i class="fas fa-check"></i> Unlimited consultations</li>
          <li><i class="fas fa-check"></i> Priority appointments</li>
          <li><i class="fas fa-check"></i> Live chat with specialists</li>
          <li><i class="fas fa-check"></i> Annual health checkup</li>
          <li><i class="fas fa-check"></i> Family plan options</li>
        </ul>
        <button class="btn-subscribe btn-primary">Choose Plan</button>
      </div>
    </div>

    <div class="plan-benefits">
      <h3 class="benefits-title">All Plans Include</h3>
      <div class="benefits-grid">
        <div class="benefit-item">
          <div class="benefit-icon">
            <i class="fas fa-shield-alt"></i>
          </div>
          <div class="benefit-content">
            <h4>Secure Data</h4>
            <p>HIPAA-compliant storage for all your health records</p>
          </div>
        </div>
        <div class="benefit-item">
          <div class="benefit-icon">
            <i class="fas fa-mobile-alt"></i>
          </div>
          <div class="benefit-content">
            <h4>Mobile Access</h4>
            <p>Full access through our mobile app anytime, anywhere</p>
          </div>
        </div>
        <div class="benefit-item">
          <div class="benefit-icon">
            <i class="fas fa-headset"></i>
          </div>
          <div class="benefit-content">
            <h4>Customer Support</h4>
            <p>Dedicated support team available 24/7</p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php include 'components/footer.php'; ?>

  <script>
    // Add any interactive functionality here
    document.querySelectorAll('.btn-subscribe').forEach(button => {
      button.addEventListener('click', function(e) {
        if(!this.classList.contains('btn-primary')) {
          e.preventDefault();
          // Scroll to premium plans
          document.querySelector('.plan-card.popular').scrollIntoView({
            behavior: 'smooth'
          });
        }
      });
    });
  </script>
</body>
</html>