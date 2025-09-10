<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Support | Medicare</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 20px;
    }

    .container {
      background: #fff;
      max-width: 550px;
      width: 100%;
      padding: 40px;
      border-radius: 20px;
      box-shadow: 0 15px 40px rgba(0, 0, 0, 0.08);
      position: relative;
      overflow: hidden;
    }

    .container::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 8px;
      background: linear-gradient(90deg, #3498db, #2ecc71);
    }

    h2 {
      text-align: center;
      margin-bottom: 30px;
      color: #2c3e50;
      font-size: 28px;
      font-weight: 600;
    }

    label {
      font-weight: 500;
      margin-bottom: 8px;
      display: block;
      color: #34495e;
      font-size: 15px;
    }

    input, textarea {
      width: 100%;
      padding: 14px 16px;
      border: 2px solid #e0e6ed;
      border-radius: 10px;
      margin-bottom: 20px;
      font-size: 15px;
      transition: all 0.3s ease;
      background-color: #f8fafc;
    }

    input:focus, textarea:focus {
      border-color: #3498db;
      outline: none;
      background-color: #fff;
      box-shadow: 0 0 0 4px rgba(52, 152, 219, 0.1);
    }

    textarea {
      resize: vertical;
      min-height: 120px;
    }

    button {
      background: linear-gradient(90deg, #3498db, #2ecc71);
      color: #fff;
      padding: 16px;
      width: 100%;
      border: none;
      border-radius: 10px;
      font-size: 16px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
      margin-top: 10px;
      letter-spacing: 0.5px;
    }

    button:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 20px rgba(52, 152, 219, 0.2);
    }

    .message {
      text-align: center;
      margin-bottom: 25px;
      padding: 14px;
      border-radius: 10px;
      font-weight: 500;
      font-size: 15px;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .message.success {
      background: #e8f8ef;
      color: #27ae60;
      border: 1px solid #a5d6a7;
    }

    .message.error {
      background: #ffebee;
      color: #e74c3c;
      border: 1px solid #ef9a9a;
    }

    .message svg {
      margin-right: 10px;
      width: 20px;
      height: 20px;
    }

    @media (max-width: 600px) {
      .container {
        padding: 30px 25px;
      }
      
      h2 {
        font-size: 24px;
        margin-bottom: 25px;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Contact Support</h2>

    <?php if (isset($success)): ?>
      <div class="message success">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
        </svg>
        <?php echo $success; ?>
      </div>
    <?php elseif (isset($error)): ?>
      <div class="message error">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <?php echo $error; ?>
      </div>
    <?php endif; ?>

    <form method="POST" action="">
      <label for="name">Your Name</label>
      <input type="text" name="name" id="name" placeholder="Enter your name" required>

      <label for="email">Your Email</label>
      <input type="email" name="email" id="email" placeholder="Enter your email" required>

      <label for="message">Message</label>
      <textarea name="message" id="message" rows="4" placeholder="How can we help you?" required></textarea>

      <button type="submit">Send Message</button>
    </form>
  </div>
</body>
</html>