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

-- CLASSES TABLE
CREATE TABLE IF NOT EXISTS classes (
  class_id INT AUTO_INCREMENT PRIMARY KEY,
  class_name VARCHAR(50),
  teacher_id INT,
  FOREIGN KEY (teacher_id) REFERENCES users(user_id)
);

--  STUDENTS TABLE
CREATE TABLE IF NOT EXISTS students (
  student_id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT, -- linked to users (role = student)
  parent_id INT, -- linked to users (role = parent)
  class_id INT,
  dob DATE,
  FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
  FOREIGN KEY (parent_id) REFERENCES users(user_id) ON DELETE SET NULL,
  FOREIGN KEY (class_id) REFERENCES classes(class_id)
);

-- ATTENDANCE TABLE 
CREATE TABLE IF NOT EXISTS attendance (
  attendance_id INT AUTO_INCREMENT PRIMARY KEY,
  student_id INT,
  class_id INT,
  date DATE,
  status ENUM('present','absent','late'),
  FOREIGN KEY (student_id) REFERENCES students(student_id),
  FOREIGN KEY (class_id) REFERENCES classes(class_id)
);

-- GRADES TABLE 
CREATE TABLE IF NOT EXISTS grades (
  grade_id INT AUTO_INCREMENT PRIMARY KEY,
  student_id INT,
  class_id INT,
  subject VARCHAR(50),
  grade VARCHAR(5),
  date_recorded DATE,
  FOREIGN KEY (student_id) REFERENCES students(student_id),
  FOREIGN KEY (class_id) REFERENCES classes(class_id)
);

-- PAYMENTS TABLE
CREATE TABLE IF NOT EXISTS payments (
  payment_id INT AUTO_INCREMENT PRIMARY KEY,
  student_id INT,
  amount DECIMAL(10,2),
  payment_date DATE,
  method ENUM('cash','paypal','stripe','bank'),
  status ENUM('pending','completed','failed'),
  reference_code VARCHAR(100),
  FOREIGN KEY (student_id) REFERENCES students(student_id)
);

-- FEES TABLE
CREATE TABLE IF NOT EXISTS fees (
  fee_id INT AUTO_INCREMENT PRIMARY KEY,
  class_id INT,
  amount DECIMAL(10,2),
  academic_year VARCHAR(10),
  term VARCHAR(10),
  FOREIGN KEY (class_id) REFERENCES classes(class_id)
);

-- MESSAGES TABLE
CREATE TABLE IF NOT EXISTS messages (
  message_id INT AUTO_INCREMENT PRIMARY KEY,
  sender_id INT,
  receiver_id INT,
  subject VARCHAR(100),
  body TEXT,
  sent_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  is_read BOOLEAN DEFAULT 0,
  FOREIGN KEY (sender_id) REFERENCES users(user_id),
  FOREIGN KEY (receiver_id) REFERENCES users(user_id)
);

-- ANNOUNCEMENTS TABLE
CREATE TABLE IF NOT EXISTS announcements (
  announcement_id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(100),
  body TEXT,
  posted_by INT,
  posted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (posted_by) REFERENCES users(user_id)
);

-- CHATBOT FAQ TABLE
CREATE TABLE IF NOT EXISTS chatbot_faq (
  faq_id INT AUTO_INCREMENT PRIMARY KEY,
  question VARCHAR(255),
  answer TEXT
);