-- CREATE DATABASE
CREATE DATABASE IF NOT EXISTS nigey_academy_improved;

-- SWICTH TO CORRECT DB
USE nigey_academy_improved;

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


-- ACADEMIC LEVELS AND STREAMS
CREATE TABLE class_levels (
    level_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(20) NOT NULL UNIQUE  -- e.g. 'Form 1', 'Lower 6', etc.
);

CREATE TABLE class_types (
    type_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE   -- e.g. 'Science', 'Commercial', etc.
);

-- TEACHERS TABLE
CREATE TABLE teachers (
    teacher_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    hire_date DATE,
    qualification VARCHAR(100),
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);

-- CLASSES TABLE
CREATE TABLE classes (
    class_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,         -- e.g. 'Form 3 West'
    teacher_id INT NOT NULL,           -- class tutor / form teacher
    level_id INT NOT NULL,
    type_id INT NOT NULL,
    FOREIGN KEY (teacher_id) REFERENCES teachers(teacher_id),
    FOREIGN KEY (level_id) REFERENCES class_levels(level_id),
    FOREIGN KEY (type_id) REFERENCES class_types(type_id)
);

-- STUDENTS TABLE
CREATE TABLE students (
    student_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    class_id INT NULL,
    gender ENUM('male','female') NULL,
    national_id VARCHAR(20) UNIQUE NULL,
    address TEXT NULL,
    date_of_birth DATE NULL,
    date_enrolled DATE DEFAULT (CURRENT_DATE),
    status ENUM('active','transferred','suspended','graduated') DEFAULT 'active',
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    FOREIGN KEY (class_id) REFERENCES classes(class_id)
);

-- SUBJECTS TABLE
CREATE TABLE subjects (
    subject_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    code VARCHAR(20) UNIQUE NOT NULL    -- e.g. 'ENG', 'MATH', 'AGR'
);

-- ACADEMIC TERMS
CREATE TABLE academic_terms (
    term_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(30) NOT NULL,      -- e.g. Term 1, Term 2
    year INT NOT NULL,
    start_date DATE,
    end_date DATE,
    UNIQUE (name, year)
);

-- GRADES / MARKS TABLE
CREATE TABLE grades (
    grade_id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    subject_id INT NOT NULL,
    term_id INT NOT NULL,
    score DECIMAL(6,2) NOT NULL,     -- numeric marks
    grade VARCHAR(5) NULL,           -- e.g. A, B, 1, etc.
    exam_type ENUM('term test','mock','final','assignment') DEFAULT 'term test',
    remarks TEXT NULL,
    FOREIGN KEY (student_id) REFERENCES students(student_id),
    FOREIGN KEY (subject_id) REFERENCES subjects(subject_id),
    FOREIGN KEY (term_id) REFERENCES academic_terms(term_id)
);

-- ATTENDANCE TABLE 
CREATE TABLE attendance (
    attendance_id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    class_id INT NOT NULL,
    date DATE NOT NULL,
    status ENUM('present','absent','late','excused') NOT NULL,
    remarks TEXT NULL,
    FOREIGN KEY (student_id) REFERENCES students(student_id),
    FOREIGN KEY (class_id) REFERENCES classes(class_id),
    UNIQUE (student_id, date)
);

-- FEES STRUCTURE TABLE
CREATE TABLE fees (
    fee_id INT AUTO_INCREMENT PRIMARY KEY,
    term_id INT NOT NULL,
    class_level_id INT NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    description VARCHAR(255) NULL,
    FOREIGN KEY (term_id) REFERENCES academic_terms(term_id),
    FOREIGN KEY (class_level_id) REFERENCES class_levels(level_id)
);

-- FEES PAYMENTS TABLE
CREATE TABLE payments (
    payment_id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    term_id INT NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    payment_date DATE DEFAULT (CURRENT_DATE),
    method VARCHAR(50) NULL,     -- Cash, Swipe, Ecocash, etc.
    balance_before DECIMAL(10,2) NULL,
    balance_after DECIMAL(10,2) NULL,
    receipt_number VARCHAR(50) UNIQUE NULL,
    FOREIGN KEY (student_id) REFERENCES students(student_id),
    FOREIGN KEY (term_id) REFERENCES academic_terms(term_id)
);

-- ANOUNCEMENTS TABLE
CREATE TABLE announcements (
    announcement_id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    message TEXT NOT NULL,
    audience ENUM('everyone','teachers','students','parents') DEFAULT 'everyone',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- MESSAGES TABLE
CREATE TABLE messages (
    message_id INT AUTO_INCREMENT PRIMARY KEY,
    sender_id INT NOT NULL,
    receiver_id INT NOT NULL,
    title VARCHAR(200),
    content TEXT NOT NULL,
    type ENUM('inbox','notice','system','fee_reminder') DEFAULT 'inbox',
    sent_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (sender_id) REFERENCES users(user_id),
    FOREIGN KEY (receiver_id) REFERENCES users(user_id)
);

-- CHATBOT FAQ TABLE
CREATE TABLE chatbot_faq (
    faq_id INT AUTO_INCREMENT PRIMARY KEY,
    question TEXT NOT NULL,
    answer TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE rate_limits (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ip VARCHAR(50) NOT NULL,
    endpoint VARCHAR(100) NOT NULL,
    attempts INT DEFAULT 0,
    last_attempt DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE activity_log (
    log_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NULL,
    action VARCHAR(255) NOT NULL,
    details TEXT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE SET NULL
);
