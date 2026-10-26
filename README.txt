MERRYLANE CAFE - FRONTEND VERSION (no database)
================================================
HOW TO RUN (XAMPP)
1. Copy the folder "MerryLaneCafe" into C:\xampp\htdocs\
2. Open XAMPP Control Panel and Start APACHE only (MySQL is not needed).
3. Open in the browser:
   Customer : http://localhost/MerryLaneCafe/index.php?table=07
   Login    : http://localhost/MerryLaneCafe/login.php
              (type any email with "admin" for admin, anything else for staff)

FOLDERS
 index.php, menu.php, orders.php, waiter.php  = customer pages
 process.php                                   = handles customer buttons (demo only)
 login.php, logout.php                         = staff/admin login (demo only)
 staff/staff_panel.php, admin/admin_panel.php  = staff and admin screens (sample data)
 includes/  = config.php (sample data), header.php, footer.php
 assets/    = style.css, script.js, images/ (put logo.png and gcash_qr.png here)
