CREATE TABLE roles (
    role_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) UNIQUE NOT NULL  -- admin, teacher, parent, student, etc.
);

INSERT INTO roles (name)
VALUES ('admin'), ('teacher'), ('parent'), ('student');

CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    
    -- account identifiers
    phone VARCHAR(20) NOT NULL UNIQUE,
    email VARCHAR(100) UNIQUE DEFAULT NULL,
    
    -- login username OPTIONAL because phone is the main credential
    username VARCHAR(50) UNIQUE NULL,
    
    -- hashed password
    password_hash VARCHAR(255) NOT NULL,
    is_password_temporary BOOLEAN DEFAULT TRUE,
    
    -- names stored properly
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    
    -- account lifecycle
    status ENUM('active','disabled','pending_verification','locked') DEFAULT 'pending_verification',
    phone_verified BOOLEAN DEFAULT FALSE,
    
    -- logging
    last_login DATETIME NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, -- fixed line
    
    -- admin accountability
    created_by INT NULL,
    updated_by INT NULL,
    deleted_at DATETIME NULL,
    
    FOREIGN KEY (created_by) REFERENCES users(user_id) ON DELETE SET NULL,
    FOREIGN KEY (updated_by) REFERENCES users(user_id) ON DELETE SET NULL
);

CREATE TABLE user_roles (
    user_id INT NOT NULL,
    role_id INT NOT NULL,
    PRIMARY KEY (user_id, role_id),
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (role_id) REFERENCES roles(role_id) ON DELETE CASCADE
);

CREATE TABLE otp_verification (
    otp_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    otp VARCHAR(10) NOT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    expires_at DATETIME NOT NULL,
    verified BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

CREATE TABLE password_resets (
    reset_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    reset_token VARCHAR(100) NOT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    expires_at DATETIME NOT NULL,
    used BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

CREATE TABLE login_attempts (
    attempt_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NULL,
    phone_attempted VARCHAR(20),
    reason ENUM('wrong_password','otp_failed','account_locked','success') DEFAULT 'success',
    ip_address VARCHAR(50),
    success BOOLEAN,
    attempted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE user_profiles (
    user_id INT PRIMARY KEY,
    address TEXT NULL,
    profile_picture VARCHAR(255),
    date_of_birth DATE NULL,
    emergency_contact VARCHAR(20),
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

CREATE INDEX idx_user_role ON user_roles(user_id, role_id);
CREATE UNIQUE INDEX idx_users_phone ON users(phone);
CREATE UNIQUE INDEX idx_users_username ON users(username);