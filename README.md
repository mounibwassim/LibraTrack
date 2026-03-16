# LibraTrack - Library Management System

LibraTrack is a digital solution designed to replace traditional paper-based library systems. It automates library operations for educational institutions, providing a streamlined experience for both students and administrators.

## 🚀 Key Features

### For Students
- **Registration & Login:** Secure access to the system.
- **Asset Browsing:** Search and view available library assets, including books and laptops.
- **Booking System:** Submit booking requests and track their status (Pending, Approved, Rejected).
- **Feedback & Reporting:** Submit feedback or report issues with specific assets.

### For Administrators
- **Inventory Management:** Full CRUD (Create, Read, Update, Delete) control over assets, including image uploads.
- **Booking Oversight:** Review, approve, or reject student booking requests.
- **Maintenance Tracking:** Log and track maintenance issues for damaged or unavailable items.
- **Feedback Review:** Monitor student reports and feedback.
- **Summary Dashboard:** High-level overview of library operations.

## 🛠️ Tech Stack
- **Backend:** PHP
- **Database:** MySQL
- **Frontend:** HTML, CSS, JavaScript
- **UI Framework:** Bootstrap 5

## 🧩 Key Modules
- **Role-Based Authentication:** Secure sessions with password hashing.
- **Asset Management:** Categorized inventory with image support.
- **Workflow System:** Status-based booking flow.
- **Maintenance Tracker:** Operational status management for assets.
- **Reporting System:** Integrated feedback and issue tracking.

## ⚙️ Local Setup Instructions

### Prerequisites
1.  Install [XAMPP](https://www.apachefriends.org/index.html).
2.  Ensure Apache and MySQL services are available.

### Installation Steps
1.  **Move Project Files:**
    Place the `LibraTrack` folder inside your XAMPP installation directory: `C:\xampp\htdocs\LibraTrack`.
2.  **Database Setup:**
    - Open XAMPP Control Panel and start **MySQL**.
    - Open your browser and go to `http://localhost:8080/phpmyadmin`.
    - Create a new database named `library_management`.
    - Click on the `library_management` database, go to the **Import** tab.
    - Choose the `library_management.sql` file located in the project root and click **Go**.
3.  **Run the Application:**
    - Start **Apache** in the XAMPP Control Panel.
    - Visit `http://localhost:8080/LibraTrack` in your browser.

## 🔧 Troubleshooting Apache Shutdown
If Apache shuts down unexpectedly in XAMPP:
- **Run as Administrator:** Right-click the XAMPP Control Panel and select "Run as Administrator".
- **Port Conflict:** I have pre-configured this to use **Port 8080** for HTTP and **Port 4433** for SSL.
    - If you need to change it back, edit `C:\xampp\apache\conf\httpd.conf` (for 8080) and `C:\xampp\apache\conf\extra\httpd-ssl.conf` (for 4433).
    - Access the site via `http://localhost:8080/LibraTrack`.

## 👥 Team
- **Web Application Build:** [Member Name]
- **Documentation & Reporting:** [Team Members]
- **Screenshots & Written Report:** [Team Members]

---
*Developed to solve manual record-keeping challenges and improve real-time library operations.*
