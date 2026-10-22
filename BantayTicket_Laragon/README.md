# BantayTicket — Laragon PHP/MySQL Version

**Project Title:** A Web-Based Barangay Complaint and Request Ticketing System with CMS Integration and Resident Status Tracking for Barangay Bagong Buhay

**Students:** Cristian M. Neri and Renz Darren M. De Torres  
**Course and Section:** BSIT 3/F3

## Features
- Submit a complaint, service request, or barangay inquiry.
- Automatically generate a ticket reference number.
- Track a ticket's status using its reference number.
- Admin login with password hashing.
- Admin dashboard with ticket counts.
- Admin can update ticket status and public update notes.
- Admin can publish and delete announcements.
- PDO prepared statements and HTML output escaping.

## Requirements
- Laragon with Apache and MySQL
- PHP 8+ recommended, with PDO MySQL enabled
- Web browser

## Install in Laragon
1. Extract the `BantayTicket_Laragon` folder into `C:\laragon\www\`.
2. Rename the extracted folder to `BantayTicket` if desired. The expected path is `C:\laragon\www\BantayTicket`.
3. Open Laragon and click **Start All**.
4. Open `http://localhost/BantayTicket/setup.php`.
5. Create an administrator username and password. Use a password with at least 12 characters.
6. After successful setup, test the public site at `http://localhost/BantayTicket/`.
7. Open `http://localhost/BantayTicket/admin/login.php` and sign in with the admin credentials you created.
8. **Delete `setup.php` after installation.** Do not leave the installer accessible.
9. If MySQL uses a password in your installation, update the connection credentials in both `config/database.php` and `setup.php` before running setup.

## Database
The one-time installer creates the `bantayticket` database and its tables (`admins`, `tickets`, and `announcements`). The SQL schema is also provided in `database/bantayticket.sql`.

## GitHub
Keep this folder separate from the original repository until you review it. If you want to use GitHub, copy the converted files into your repository, inspect `git status`, commit, and push them.

## Important limitations
This is a local student prototype, not a production-ready government system. It has not been security-audited. Do not use real sensitive resident data or expose it publicly. Ticket tracking uses a reference number and shows limited public fields, but additional authorization, abuse protection, backups, audit logs, and deployment hardening would be needed before real-world use.
