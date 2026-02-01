-- =========================================
-- HOSTEL COMPLAINT MANAGEMENT SYSTEM
-- Separate Admin Table Version
-- =========================================

CREATE DATABASE IF NOT EXISTS hostel_db;
USE hostel_db;

-- =========================================
-- STUDENT USERS TABLE
-- =========================================
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(15),
    room_number VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- =========================================
-- ADMIN TABLE (WARDEN ONLY)
-- =========================================
CREATE TABLE admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- =========================================
-- CATEGORIES TABLE
-- =========================================
CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_name VARCHAR(100) NOT NULL
);

INSERT INTO categories (category_name) VALUES
('Fire Emergency'),
('Urgent Issue'),
('Water Burst'),
('Electric Shock'),
('Security Threat'),
('Theft Case'),
('Water Leakage'),
('Danger Situation'),
('Slow Service'),
('Not Working'),
('Broken Item'),
('Damaged Property'),
('Plumbing'),
('Electricity'),
('Internet'),
('Cleanliness'),
('Furniture'),
('Security');



-- =========================================
-- COMPLAINTS TABLE
-- =========================================
CREATE TABLE complaints (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    category_id INT,
    title VARCHAR(200) NOT NULL,
    description TEXT NOT NULL,
    priority ENUM('Low','Medium','High') DEFAULT 'Low',
    status ENUM('Submitted','In Progress','Resolved','Escalated') DEFAULT 'Submitted',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
);

-- =========================================
-- FEEDBACK TABLE
-- =========================================
CREATE TABLE feedback (
    id INT AUTO_INCREMENT PRIMARY KEY,
    complaint_id INT NOT NULL,
    user_id INT NOT NULL,
    rating INT CHECK (rating BETWEEN 1 AND 5),
    message TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (complaint_id) REFERENCES complaints(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- =========================================
-- ACTIVITY LOG TABLE
-- =========================================
CREATE TABLE activity_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    complaint_id INT,
    action VARCHAR(255),
    action_by INT,
    action_role ENUM('student','admin') NOT NULL,
    action_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (complaint_id) REFERENCES complaints(id) ON DELETE CASCADE
);

-- =========================================
-- DEFAULT ADMIN ACCOUNT
-- Email: warden@gmail.com
-- Password: admin123
-- =========================================

-- Generate hash using:
-- <?php echo password_hash("admin123", PASSWORD_DEFAULT); ?>

INSERT INTO admins (name,email,password)
VALUES (
    'Hostel Warden',
    'warden@gmail.com',
    '$2y$10$REPLACE_WITH_REAL_HASH'
);
