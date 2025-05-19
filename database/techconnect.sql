-- Create the database if it doesn't exist
CREATE DATABASE IF NOT EXISTS techconnect;
USE techconnect;

-- Create users table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(255) NOT NULL,
    bio TEXT,
    profile_picture VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Create events table
CREATE TABLE IF NOT EXISTS events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    event_date DATE NOT NULL,
    location VARCHAR(255) NOT NULL,
    category VARCHAR(50) NOT NULL,
    description TEXT NOT NULL,
    registration_link VARCHAR(255),
    user_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);

-- Create projects table
CREATE TABLE IF NOT EXISTS projects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    skills_needed VARCHAR(255),
    description TEXT NOT NULL,
    contact_info VARCHAR(255),
    technologies VARCHAR(255),
    github_link VARCHAR(255),
    user_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);

-- Create event_registrations table
CREATE TABLE IF NOT EXISTS event_registrations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    event_id INT NOT NULL,
    user_id INT NOT NULL,
    registration_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status ENUM('registered', 'attended', 'cancelled') DEFAULT 'registered',
    FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE KEY unique_registration (event_id, user_id)
);

-- Insert sample users (passwords are hashed versions of 'password123')
INSERT INTO users (email, password, full_name, bio) VALUES
('john@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'John Doe', 'Full-stack developer passionate about web technologies'),
('jane@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Jane Smith', 'UI/UX designer with 5 years of experience'),
('admin@techconnect.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Admin User', 'System administrator');

-- Insert sample events
INSERT INTO events (title, event_date, location, category, description, registration_link, user_id) VALUES
('Web Development Workshop', '2024-04-15', 'Online', 'workshop', 'Learn modern web development techniques', 'https://example.com/register', 1),
('Tech Conference 2024', '2024-05-20', 'Convention Center', 'conference', 'Annual technology conference', 'https://example.com/conf', 2),
('Hackathon 2024', '2024-06-01', 'Innovation Hub', 'hackathon', '24-hour coding competition', 'https://example.com/hackathon', 3);

-- Insert sample projects
INSERT INTO projects (title, description, technologies, github_link, user_id) VALUES
('E-commerce Platform', 'A full-featured e-commerce solution', 'PHP, MySQL, JavaScript', 'https://github.com/example/ecommerce', 1),
('Task Management App', 'Simple and efficient task management', 'React, Node.js, MongoDB', 'https://github.com/example/taskapp', 2);

-- Insert sample event registrations
INSERT INTO event_registrations (event_id, user_id, status) VALUES
(1, 2, 'registered'),
(2, 1, 'registered'),
(3, 1, 'registered'),
(3, 2, 'registered');