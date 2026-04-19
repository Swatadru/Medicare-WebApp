<nav class="navbar navbar-expand-lg fixed-top animate-fade-in">
    <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center" href="index.php">
            <div class="bg-primary text-white rounded-circle p-2 me-2 d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                <i class="fas fa-heartbeat fa-xs"></i>
            </div>
            <span>Medicare</span>
        </a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                <li class="nav-item">
                    <a class="nav-link fw-bold" href="dashboard.php">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-bold" href="doctors.php">Specialists</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-bold" href="medicines.php">Medicine Hub</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-bold" href="subscription.php">Plans</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-bold" href="support.php">Support</a>
                </li>
            </ul>
            
            <div class="d-flex align-items-center gap-3">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <div class="dropdown">
                        <div class="d-flex align-items-center gap-2 role-badge px-3 py-1 rounded-pill bg-light border cursor-pointer" id="userDropdown" data-bs-toggle="dropdown">
                            <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($_SESSION['fullname']); ?>&background=random" class="rounded-circle" width="28">
                            <span class="small fw-bold d-none d-md-inline"><?php echo htmlspecialchars($_SESSION['fullname']); ?></span>
                        </div>
                        <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg p-2 rounded-4 mt-3">
                            <li class="px-3 py-2 border-bottom mb-2">
                                <p class="mb-0 small text-muted">Signed in as</p>
                                <p class="mb-0 fw-bold"><?php echo htmlspecialchars($_SESSION['username']); ?></p>
                            </li>
                            <li><a class="dropdown-item rounded-3 py-2" href="#"><i class="fas fa-user-circle me-2 opacity-50"></i> Profile</a></li>
                            <li><a class="dropdown-item rounded-3 py-2" href="#"><i class="fas fa-cog me-2 opacity-50"></i> Settings</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item rounded-3 py-2 text-danger" href="logout.php"><i class="fas fa-sign-out-alt me-2 opacity-50"></i> Logout</a></li>
                        </ul>
                    </div>
                <?php else: ?>
                    <a href="login.php" class="btn btn-outline-primary rounded-pill px-4">Login</a>
                    <a href="register.php" class="btn btn-primary rounded-pill px-4">Join Now</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>

<style>
/* Header spacing to prevent content overlap with fixed-top navbar */
body {
    padding-top: 100px;
}

.cursor-pointer { cursor: pointer; }

/* Refined Dropdown Pill */
.dropdown-menu {
    min-width: 220px;
}

.dropdown-item:active {
    background-color: var(--primary);
}

@media (max-width: 991.98px) {
    body { padding-top: 80px; }
    
    .navbar {
        background: #fff !important; /* Solid background for mobile expansion visibility */
    }
}
</style>
