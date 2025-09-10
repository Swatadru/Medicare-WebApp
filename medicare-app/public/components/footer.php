<!-- components/footer.php -->
<footer style="
    background-color: #0f172a;
    color: #cbd5e1;
    padding: 40px 20px;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    border-top: 4px solid #2a7de1;
">
    <div style="
        max-width: 1200px;
        margin: auto;
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        align-items: flex-start;
    ">

        <!-- Branding and About -->
        <div style="flex: 1; min-width: 250px; margin-bottom: 30px;">
            <h2 style="color: #fff;">Medicare</h2>
            <p style="font-size: 14px; line-height: 1.6;">
                Your trusted partner in digital healthcare. Book appointments, get support, and manage your health efficiently.
            </p>
        </div>

        <!-- Quick Links -->
        <div style="flex: 1; min-width: 200px; margin-bottom: 30px;">
            <h4 style="color: #fff;">Quick Links</h4>
            <ul style="list-style: none; padding: 0; font-size: 14px;">
                <li><a href="index.php" style="color: #cbd5e1; text-decoration: none;">Home</a></li>
                <li><a href="login.php" style="color: #cbd5e1; text-decoration: none;">Login</a></li>
                <li><a href="register.php" style="color: #cbd5e1; text-decoration: none;">Register</a></li>
                <li><a href="support.php" style="color: #cbd5e1; text-decoration: none;">Support</a></li>
            </ul>
        </div>

        <!-- Social Media -->
        <div style="flex: 1; min-width: 200px;">
            <h4 style="color: #fff;">Follow Us</h4>
            <div style="display: flex; gap: 15px; margin-top: 10px;">
                <a href="#" style="color: #cbd5e1; font-size: 20px;"><i class="fab fa-facebook-f"></i></a>
                <a href="#" style="color: #cbd5e1; font-size: 20px;"><i class="fab fa-twitter"></i></a>
                <a href="#" style="color: #cbd5e1; font-size: 20px;"><i class="fab fa-instagram"></i></a>
                <a href="#" style="color: #cbd5e1; font-size: 20px;"><i class="fab fa-linkedin-in"></i></a>
            </div>
        </div>
    </div>

    <!-- Bottom bar -->
    <div style="
        text-align: center;
        padding-top: 20px;
        border-top: 1px solid #334155;
        font-size: 13px;
        color: #94a3b8;
        margin-top: 108px;
    ">
        &copy; <?php echo date('Y'); ?> Medicare. All rights reserved.
    </div>
</footer>

<!-- Load FontAwesome for icons -->
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>
</html>
