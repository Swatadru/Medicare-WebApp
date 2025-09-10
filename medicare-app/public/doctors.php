<?php
session_start();

require_once '../backend/config/db.php';

if (!$conn) {
    die("Database connection failed.");
}

$result = $conn->query("SELECT * FROM doctors");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Our Doctors | Medicare</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    :root {
      --primary: #4361ee;
      --primary-dark: #3a0ca3;
      --primary-light: #4895ef;
      --secondary: #4cc9f0;
      --success: #38b000;
      --warning: #ff9e00;
      --danger: #ef233c;
      --light: #f8f9fa;
      --lighter: #ffffff;
      --dark: #14213d;
      --text: #2b2d42;
      --text-light: #8d99ae;
      --border: #e9ecef;
      --shadow-sm: 0 1px 3px rgba(0,0,0,0.12);
      --shadow: 0 4px 6px rgba(0,0,0,0.1);
      --shadow-md: 0 10px 15px rgba(0,0,0,0.1);
      --rounded-sm: 8px;
      --rounded: 12px;
      --rounded-md: 16px;
      --transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    }

    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    body {
      background-color: #f5f7ff;
      background-image: radial-gradient(circle at 10% 20%, rgba(67, 97, 238, 0.05) 0%, rgba(255,255,255,1) 90%);
      color: var(--text);
      line-height: 1.6;
    }

    .container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 2rem 1rem;
    }

    .page-header {
      text-align: center;
      margin-bottom: 3rem;
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
      max-width: 700px;
      margin: 0 auto;
    }

    .doctors-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
      gap: 2rem;
      margin-top: 2rem;
    }

    .doctor-card {
      background: var(--lighter);
      border-radius: var(--rounded-md);
      overflow: hidden;
      box-shadow: var(--shadow);
      transition: var(--transition);
      border: 1px solid var(--border);
    }

    .doctor-card:hover {
      transform: translateY(-5px);
      box-shadow: var(--shadow-md);
    }

    .doctor-image-container {
      position: relative;
      width: 100%;
      height: 200px;
      overflow: hidden;
    }

    .doctor-image {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 0.5s ease;
    }

    .doctor-card:hover .doctor-image {
      transform: scale(1.05);
    }

    .doctor-details {
      padding: 1.5rem;
    }

    .doctor-name {
      font-size: 1.3rem;
      color: var(--dark);
      margin-bottom: 0.5rem;
      font-weight: 600;
    }

    .doctor-specialty {
      display: inline-block;
      background: rgba(67, 97, 238, 0.1);
      color: var(--primary);
      padding: 0.25rem 0.75rem;
      border-radius: 20px;
      font-size: 0.85rem;
      font-weight: 500;
      margin-bottom: 1rem;
    }

    .doctor-info {
      margin-bottom: 1rem;
    }

    .doctor-info-item {
      display: flex;
      align-items: center;
      gap: 0.5rem;
      margin-bottom: 0.5rem;
      color: var(--text-light);
      font-size: 0.9rem;
    }

    .doctor-info-item i {
      color: var(--primary);
      width: 20px;
      text-align: center;
    }

    .btn-book {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 0.5rem;
      width: 100%;
      padding: 0.75rem;
      background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
      color: white;
      border: none;
      border-radius: var(--rounded-sm);
      font-weight: 500;
      text-decoration: none;
      transition: var(--transition);
      margin-top: 1rem;
    }

    .btn-book:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 12px rgba(67, 97, 238, 0.25);
    }

    .no-doctors {
      text-align: center;
      grid-column: 1 / -1;
      padding: 2rem;
      color: var(--text-light);
    }

    .no-doctors i {
      font-size: 2rem;
      margin-bottom: 1rem;
      color: var(--text-light);
    }

    /* Default doctor image styling */
    .default-avatar {
      width: 100%;
      height: 100%;
      background: linear-gradient(135deg, var(--primary-light) 0%, var(--primary-dark) 100%);
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-size: 3rem;
    }

    @media (max-width: 768px) {
      .container {
        padding: 1.5rem;
      }
      
      .page-header h1 {
        font-size: 2rem;
      }
      
      .doctors-grid {
        grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
      }
    }

    @media (max-width: 480px) {
      .container {
        padding: 1rem;
      }
      
      .page-header h1 {
        font-size: 1.8rem;
      }
    }
  </style>
</head>
<body>
  <?php include 'components/navbar.php'; ?>

  <div class="container">
    <div class="page-header">
      <h1>Our Healthcare Specialists</h1>
      <p>Meet our team of experienced and compassionate doctors dedicated to your well-being</p>
    </div>

    <div class="doctors-grid">
      <?php if ($result && $result->num_rows > 0): ?>
        <?php while($row = $result->fetch_assoc()): ?>
          <div class="doctor-card">
            <div class="doctor-image-container">
              <?php if (!empty($row['image']) && file_exists("assets/images/" . $row['image'])): ?>
                <img src="assets/images/<?= htmlspecialchars($row['image']) ?>" 
                     alt="Dr. <?= htmlspecialchars($row['name']) ?>" 
                     class="doctor-image">
              <?php else: ?>
                <div class="default-avatar">
                  <span><?= strtoupper(substr(htmlspecialchars($row['name']), 0, 1)) ?></span>
                </div>
              <?php endif; ?>
            </div>
            
            <div class="doctor-details">
              <h3 class="doctor-name">Dr. <?= htmlspecialchars($row['name']) ?></h3>
              <span class="doctor-specialty"><?= htmlspecialchars($row['specialization']) ?></span>
              
              <div class="doctor-info">
                <div class="doctor-info-item">
                  <i class="fas fa-briefcase"></i>
                  <span><?= isset($row['experience']) ? intval($row['experience']) . ' years experience' : 'Experience not specified' ?></span>
                </div>
                <div class="doctor-info-item">
                  <i class="fas fa-graduation-cap"></i>
                  <span><?= htmlspecialchars($row['qualification'] ?? 'MD Medicine') ?></span>
                </div>
                <div class="doctor-info-item">
                  <i class="fas fa-star"></i>
                  <span><?= isset($row['rating']) ? floatval($row['rating']) . '/5' : '5/5' ?> patient rating</span>
                </div>
              </div>
              
              <a href="Appointment.php?doctor_id=<?= $row['id'] ?>" class="btn-book">
                <i class="fas fa-calendar-check"></i> Book Appointment
              </a>
            </div>
          </div>
        <?php endwhile; ?>
      <?php else: ?>
        <div class="no-doctors">
          <i class="fas fa-user-md"></i>
          <h3>No doctors available at the moment</h3>
          <p>Please check back later or contact our support team</p>
        </div>
      <?php endif; ?>
    </div>
  </div>

  <?php include 'components/footer.php'; ?>

  <!-- Sample doctor images (you would normally get these from your database) -->
  <?php
    // These are example images - in your actual implementation, you would store image paths in your database
    $sampleImages = [
      'doctor1.jpg',
      'doctor2.jpg',
      'doctor3.jpg',
      'doctor4.jpg'
    ];
  ?>
</body>
</html>