CREATE DATABASE IF NOT EXISTS bantayticket CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE bantayticket;

CREATE TABLE IF NOT EXISTS admins (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(80) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS tickets (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  reference_no VARCHAR(40) NOT NULL UNIQUE,
  resident_name VARCHAR(120) NOT NULL,
  contact_number VARCHAR(40) NULL,
  concern_type ENUM('Complaint','Service Request','Barangay Inquiry') NOT NULL,
  subject VARCHAR(180) NOT NULL,
  details TEXT NOT NULL,
  status ENUM('Submitted','In Review','In Progress','Resolved','Rejected') NOT NULL DEFAULT 'Submitted',
  public_update TEXT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX idx_ticket_status (status),
  INDEX idx_ticket_created (created_at)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS announcements (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(180) NOT NULL,
  body TEXT NOT NULL,
  is_published TINYINT(1) NOT NULL DEFAULT 1,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;
