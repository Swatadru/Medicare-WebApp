# Medicare - Medical Consultation & Subscription Platform

A comprehensive full-stack web application built with PHP that facilitates online medical consultations. Users can browse healthcare professionals, book appointments, and manage subscription plans for continuous care.

## 🌟 Key Features

- **Secure User Authentication**: User registration, login, and session management.
- **Doctor Directory**: Browse and search through a list of available doctors with detailed profiles.
- **Appointment Management**: Book, view, and cancel medical appointments seamlessly.
- **Subscription System**: Choose from various subscription plans for ongoing medical support.
- **User Dashboard**: A centralized hub for users to manage their appointments, profile, and subscriptions.
- **Responsive Design**: Accessible and user-friendly on both desktop and mobile devices.

## 🏗️ Technology Stack

- **Backend:** PHP (Procedural)
- **Frontend:** HTML, CSS, JavaScript, Bootstrap
- **Database:** MySQL
- **Server:** XAMPP (Apache)
- **Architecture:** MVC-inspired structure (Model-View-Controller)

## 📂 Project File Structure
```
medicare-app/
├── backend/
│ ├── config/
│ │ └── db.php # Centralized database connection script
│ ├── controllers/ # Contains application business logic
│ │ ├── authController.php # Handles user login & registration
│ │ ├── bookingController.php # Processes appointment bookings
│ │ └── doctorController.php # Fetches and manages doctor data
│ └── models/ # Classes representing data entities
│ ├── User.php # User model & methods (e.g., create, login)
│ └── Doctor.php # Doctor model & methods
├── public/ # Publicly accessible directory (DocumentRoot)
│ ├── assets/
│ │ └── images/ # Stores all static images (logos, icons, etc.)
│ ├── components/ # Reusable PHP partials
│ │ ├── header.php # Common header
│ │ ├── navbar.php # Navigation bar
│ │ └── footer.php # Common footer
│ ├── index.php # Homepage
│ ├── login.php # User login page
│ ├── register.php # User registration page
│ ├── dashboard.php # User profile & activity dashboard
│ ├── doctors.php # Page to list all available doctors
│ ├── book.php # Page to book a new appointment
│ ├── appointment.php # Page to view user's appointments
│ ├── subscription.php # Page to view and manage subscriptions
│ ├── about.php # About us information
│ ├── support.php # Customer support/contact page
│ └── logout.php # Script to destroy user session
├── LICENSE # Software license information
└── README.md # Project documentation (this file)
```
## ⚙️ Local Development Setup (Using XAMPP)

This guide will help you set up the project on a local XAMPP server.

### Prerequisites
- [XAMPP](https://www.apachefriends.org/index.html) installed on your machine.

### Installation Steps

1.  **Start XAMPP:**
    - Launch the XAMPP Control Panel.
    - Start the **Apache** and **MySQL** modules.

2.  **Clone/Place the Project:**
    - Clone this repository or extract the project folder into your XAMPP's `htdocs` directory.
    - **Path typically is:** `C:\xampp\htdocs\` on Windows or `/opt/lampp/htdocs/` on Linux.
    - Ensure the project is placed as `C:\xampp\htdocs\medicare-app\`.

3.  **Create the Database:**
    - Open your web browser and go to `http://localhost/phpmyadmin`.
    - Click on **New** to create a new database.
    - Name it `medicare_db` (or any name you prefer) and select collation `utf8_general_ci`.
    - Click **Create**.

4.  **Import the Schema (Optional):**
    - If you have an SQL dump file (e.g., `medicare_db.sql`), select the new database in phpMyAdmin.
    - Click the **Import** tab, choose the file, and click **Go** to import the table structure and sample data.

5.  **Configure Database Connection:**
    - Navigate to the file `medicare-app/backend/config/db.php`.
    - Update the database connection variables to match your MySQL setup (XAMPP's default is usually `root` with no password).
    ```php
    <?php
    $host = 'localhost';
    $dbname = 'medicare_db'; // Name of the database you created
    $username = 'root';      // Default XAMPP MySQL username
    $password = '';          // Default XAMPP MySQL password is empty
    // ... rest of the connection code
    ?>
    ```

6.  **Access the Application:**
    - Open your browser and visit: `http://localhost/medicare-app/public/`
    - You should see the homepage of the Medicare App. You can now register a new user and explore the site.

## 🗄️ Database Schema

The application relies on several key MySQL tables, including:
- `users`: Stores user credentials and personal information.
- `doctors`: Stores details about doctors (name, specialty, bio, etc.).
- `appointments`: Links users to doctors with date, time, and status.
- `subscriptions`: Manages user subscription plans and their validity.

*(A detailed SQL schema file is recommended to be included in a `database/` folder for full clarity.)*

## 🧪 How to Use

1.  **Homepage:** Start at `http://localhost/medicare-app/public/`.
2.  **Register/Login:** Create a new account or log in to an existing one.
3.  **Find a Doctor:** Navigate to the "Doctors" page to browse healthcare professionals.
4.  **Book an Appointment:** Select a doctor and choose an available time slot to book a consultation.
5.  **Dashboard:** Go to your dashboard to see your upcoming appointments and active subscriptions.
6.  **Subscribe:** Visit the "Subscription" page to choose a plan that fits your needs.

## 🔒 Security Notes

- This is a project for **educational and portfolio purposes**.
- For a production environment, critical security measures must be implemented, such as:
  - Using **prepared statements** everywhere to prevent SQL injection.
  - Strong password hashing (e.g., `password_hash()` with `PASSWORD_DEFAULT`).
  - Input validation and sanitization on all user-supplied data.
  - HTTPS enforcement.

## 📜 License

This project is open-source and available under the [MIT License](LICENSE).

## 🤝 Contributing

Contributions are what make the open-source community such an amazing place to learn, inspire, and create. Any contributions you make are **greatly appreciated**.
1.  Fork the Project
2.  Create your Feature Branch (`git checkout -b feature/AmazingFeature`)
3.  Commit your Changes (`git commit -m 'Add some AmazingFeature'`)
4.  Push to the Branch (`git push origin feature/AmazingFeature`)
5.  Open a Pull Request

## 📞 Support

If you have any questions or run into issues during setup, please open an issue on this GitHub repository.

---

**Disclaimer:** This project is a demo and is not intended for real-world medical use. It does not handle sensitive patient health information (PHI) and should not be used as a real medical service.
