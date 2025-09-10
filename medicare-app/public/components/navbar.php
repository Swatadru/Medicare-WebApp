<nav class="nav-container">
    <div class="nav-left">
        <div class="nav-logo">
            <i class="fas fa-heartbeat"></i>
            <span>Medicare</span>
        </div>
        <button class="menu-toggle" id="menuToggle">
            <i class="fas fa-bars"></i>
        </button>
    </div>

    <ul class="nav-items" id="navMenu">
        <li><a href="dashboard.php"><i class="fas fa-home"></i> Dashboard</a></li>
        <li><a href="doctors.php"><i class="fas fa-user-md"></i> Doctors</a></li>
        <li><a href="Appointment.php"><i class="fas fa-calendar-alt"></i> Appointments</a></li>
        <li><a href="support.php"><i class="fas fa-headset"></i> Support</a></li>
    </ul>

    <div class="user-dropdown">
        <img src="https://i.pravatar.cc/40" alt="User Avatar" class="avatar" id="avatarBtn">
        <div class="dropdown-content" id="dropdownMenu">
            <a href="#"><i class="fas fa-user"></i> Profile</a>
            <a href="#"><i class="fas fa-cog"></i> Settings</a>
            <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
    </div>
</nav>

<!-- STYLE -->
<style>
    .nav-container {
        display: flex;
        align-items: center;
        justify-content: space-between;
        background-color: #fff;
        padding: 15px 30px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        position: sticky;
        top: 0;
        z-index: 1000;
        font-family: 'Segoe UI', sans-serif;
    }

    .nav-left {
        display: flex;
        align-items: center;
    }

    .nav-logo {
        font-size: 22px;
        font-weight: bold;
        color: #2a7de1;
        display: flex;
        align-items: center;
    }

    .nav-logo i {
        margin-right: 8px;
    }

    .menu-toggle {
        display: none;
        margin-left: 15px;
        background: none;
        border: none;
        font-size: 22px;
        cursor: pointer;
    }

    .nav-items {
        list-style: none;
        display: flex;
        gap: 25px;
        margin: 0;
        padding: 0;
    }

    .nav-items li {
        display: inline-block;
    }

    .nav-items a {
        text-decoration: none;
        color: #333;
        font-weight: 500;
        font-size: 15px;
        display: flex;
        align-items: center;
        padding: 8px 12px;
        border-radius: 6px;
        transition: background 0.2s;
    }

    .nav-items a i {
        margin-right: 6px;
        color: #2a7de1;
    }

    .nav-items a:hover {
        background-color: #f0f4ff;
        color: #2a7de1;
    }

    .user-dropdown {
        position: relative;
    }

    .avatar {
        height: 36px;
        width: 36px;
        border-radius: 50%;
        cursor: pointer;
    }

    .dropdown-content {
        display: none;
        position: absolute;
        right: 0;
        top: 46px;
        background-color: #fff;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        border-radius: 8px;
        overflow: hidden;
        z-index: 999;
        width: 160px;
    }

    .dropdown-content a {
        display: block;
        padding: 10px 15px;
        color: #333;
        font-size: 14px;
        text-decoration: none;
        transition: background 0.2s;
    }

    .dropdown-content a i {
        margin-right: 8px;
        color: #2a7de1;
    }

    .dropdown-content a:hover {
        background-color: #f0f4ff;
    }

    @media screen and (max-width: 768px) {
        .nav-items {
            display: none;
            flex-direction: column;
            position: absolute;
            top: 70px;
            left: 0;
            width: 100%;
            background: #fff;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            padding: 20px 0;
        }

        .nav-items.active {
            display: flex;
        }

        .menu-toggle {
            display: block;
        }
    }
</style>

<!-- JS -->
<script>
    const menuToggle = document.getElementById('menuToggle');
    const navMenu = document.getElementById('navMenu');
    const avatarBtn = document.getElementById('avatarBtn');
    const dropdownMenu = document.getElementById('dropdownMenu');

    menuToggle.addEventListener('click', () => {
        navMenu.classList.toggle('active');
    });

    avatarBtn.addEventListener('click', () => {
        dropdownMenu.style.display = dropdownMenu.style.display === 'block' ? 'none' : 'block';
    });

    window.addEventListener('click', function(e) {
        if (!avatarBtn.contains(e.target) && !dropdownMenu.contains(e.target)) {
            dropdownMenu.style.display = 'none';
        }
    });
</script>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
