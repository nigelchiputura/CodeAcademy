-- CREATE DATABASE
CREATE DATABASE IF NOT EXISTS nigey_academy;

-- SWICTH TO CORRECT DB
USE nigey_academy;

-- USERS TABLE
CREATE TABLE IF NOT EXISTS users (
  user_id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) UNIQUE,
  password VARCHAR(255),
  role ENUM('admin','teacher','parent','student'),
  email VARCHAR(100) DEFAULT NULL,
  phone VARCHAR(20) NOT NULL UNIQUE,
  full_name VARCHAR(100),
  last_login DATETIME NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- PASSWORD RESET TABLE
CREATE TABLE IF NOT EXISTS password_resets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    otp VARCHAR(6) NOT NULL,
    created_at DATETIME NOT NULL,
    expires_at DATETIME NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

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
    user_id INT NOT NULL,   -- FK to users table in your auth system
    hire_date DATE,
    qualification VARCHAR(100),
    FOREIGN KEY (user_id) REFERENCES users(id)
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

--  STUDENTS TABLE
CREATE TABLE students (
    student_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    class_id INT NULL,
    gender ENUM('male','female') NULL,
    national_id VARCHAR(20) UNIQUE NULL,
    address TEXT NULL,
    date_of_birth DATE NULL,
    date_enrolled DATE DEFAULT CURRENT_DATE,
    status ENUM('active','transferred','suspended','graduated') DEFAULT 'active',
    FOREIGN KEY (user_id) REFERENCES users(id),
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
    payment_date DATE DEFAULT CURRENT_DATE,
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
    FOREIGN KEY (sender_id) REFERENCES users(id),
    FOREIGN KEY (receiver_id) REFERENCES users(id)
);

-- CHATBOT FAQ TABLE
CREATE TABLE chatbot_faq (
    faq_id INT AUTO_INCREMENT PRIMARY KEY,
    question TEXT NOT NULL,
    answer TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);