
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medicare - Healthcare Services</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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
            --dark: #0f172a;
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
            color: var(--text);
            line-height: 1.6;
        }

        .navbar {
            background-color: var(--lighter);
            color: var(--text);
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 2rem;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            backdrop-filter: blur(10px);
            background-color: rgba(255, 255, 255, 0.95);
        }

        .navbar .logo {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary);
            text-decoration: none;
        }

        .logo-icon {
            color: var(--primary);
            font-size: 1.8rem;
        }

        .logo-text {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .nav-links {
            list-style: none;
            display: flex;
            gap: 2rem;
            align-items: center;
        }

        .nav-links li a {
            text-decoration: none;
            color: var(--text);
            font-weight: 500;
            font-size: 1rem;
            transition: all 0.3s ease;
            position: relative;
            padding: 0.5rem 0;
        }

        .nav-links li a:hover {
            color: var(--primary);
        }

        .nav-links li a::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 0;
            left: 0;
            background-color: var(--primary);
            transition: width 0.3s ease;
        }

        .nav-links li a:hover::after {
            width: 100%;
        }

        .nav-cta {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            padding: 0.6rem 1.2rem;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .nav-cta:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(67, 97, 238, 0.25);
            color: white;
        }

        .user-menu {
            position: relative;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            cursor: pointer;
        }

        .dropdown-menu {
            position: absolute;
            top: 50px;
            right: 0;
            background-color: var(--lighter);
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            width: 200px;
            padding: 1rem 0;
            display: none;
            z-index: 1000;
        }

        .dropdown-menu.show {
            display: block;
        }

        .dropdown-menu a {
            display: block;
            padding: 0.75rem 1.5rem;
            color: var(--text);
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .dropdown-menu a:hover {
            background-color: var(--light);
            color: var(--primary);
        }

        .menu-toggle {
            display: none;
            font-size: 1.5rem;
            color: var(--text);
            cursor: pointer;
            z-index: 1001;
        }

        @media (max-width: 992px) {
            .nav-links {
                position: fixed;
                top: 0;
                right: -100%;
                width: 280px;
                height: 100vh;
                background-color: var(--lighter);
                flex-direction: column;
                justify-content: center;
                gap: 2rem;
                box-shadow: -5px 0 15px rgba(0, 0, 0, 0.1);
                transition: right 0.3s ease;
                padding: 2rem;
            }

            .nav-links.show {
                right: 0;
            }

            .menu-toggle {
                display: block;
            }

            .nav-links li a {
                font-size: 1.1rem;
            }

            .nav-cta {
                margin-top: 1rem;
            }

            .user-menu {
                margin-top: 1rem;
            }
        }

        @media (max-width: 576px) {
            .navbar {
                padding: 1rem;
            }
            
            .logo-text {
                font-size: 1.3rem;
            }
        }
    </style>
</head>
<body>

    <nav class="navbar">
        <a href="index.php" class="logo">
            <i class="fas fa-heartbeat logo-icon"></i>
            <span class="logo-text">Medicare</span>
        </a>
        
        <div class="menu-toggle">
            <i class="fas fa-bars"></i>
        </div>
        
        <ul class="nav-links">
            <li><a href="index.php">Home</a></li>
            <li><a href="doctors.php">Doctors</a></li>
            <li><a href="Appointment.php">Appointments</a></li>
            <li><a href="services.php">Services</a></li>
            <li><a href="about.php">About</a></li>
            
            <?php if(isset($_SESSION['user_id'])): ?>
                <li class="user-menu">
                    <div class="user-avatar" id="userAvatar">
                        <?= strtoupper(substr($_SESSION['username'], 0, 1)) ?>
                    </div>
                    <div class="dropdown-menu" id="dropdownMenu">
                        <a href="profile.php"><i class="fas fa-user"></i> Profile</a>
                        <a href="appointments.php"><i class="fas fa-calendar-alt"></i> My Appointments</a>
                        <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
                    </div>
                </li>
            <?php else: ?>
                <li><a href="login.php" class="nav-cta">Login</a></li>
            <?php endif; ?>
        </ul>
    </nav>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const toggle = document.querySelector('.menu-toggle');
            const menu = document.querySelector('.nav-links');
            const userAvatar = document.getElementById('userAvatar');
            const dropdownMenu = document.getElementById('dropdownMenu');
            
            // Mobile menu toggle
            toggle.addEventListener('click', () => {
                menu.classList.toggle('show');
                toggle.innerHTML = menu.classList.contains('show') 
                    ? '<i class="fas fa-times"></i>' 
                    : '<i class="fas fa-bars"></i>';
            });
            
            // User dropdown toggle
            if(userAvatar && dropdownMenu) {
                userAvatar.addEventListener('click', (e) => {
                    e.stopPropagation();
                    dropdownMenu.classList.toggle('show');
                });
            }
            
            // Close dropdown when clicking elsewhere
            document.addEventListener('click', () => {
                if(dropdownMenu) dropdownMenu.classList.remove('show');
            });
            
            // Close menu when clicking on a link (for mobile)
            document.querySelectorAll('.nav-links a').forEach(link => {
                link.addEventListener('click', () => {
                    if (window.innerWidth <= 992) {
                        menu.classList.remove('show');
                        toggle.innerHTML = '<i class="fas fa-bars"></i>';
                    }
                });
            });
        });
    </script>

