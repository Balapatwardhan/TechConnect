<?php
session_start();
require_once 'db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $stmt = $pdo->prepare("INSERT INTO projects (title, skills_needed, description, contact_info, user_id) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([
            $_POST['project-title'],
            $_POST['skills-needed'],
            $_POST['project-desc'],
            $_POST['contact-info'],
            $_SESSION['user_id']
        ]);
        $message = "Project posted successfully! You can now find teammates.";
        $messageType = "success";
    } catch (PDOException $e) {
        $message = "Error posting project: " . $e->getMessage();
        $messageType = "error";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post a Project | TechConnect</title>
   <style>
/* Reset & Base */
body {
    margin: 0;
    padding: 0;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #0e1a2b;
    color: #ffffff;
}

/* Sticky navbar */
.navbar {
    position: sticky;
    top: 0;
    z-index: 999;
    width: 100%;
    background: #ffffff;
    color: #000;
    box-shadow: 0 2px 4px rgba(0,0,0,0.08);
    display: flex;
    align-items: center;
    padding: 1rem 2rem;
}

/* Container for the form */
.form-container {
    max-width: 600px;
    background-color: #1c2a40;
    margin: 100px auto 40px;
    padding: 2rem;
    border-radius: 12px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.3);
}

/* Headings and paragraphs */
.form-container h2 {
    text-align: center;
    color: #00d9ff;
    margin-bottom: 1rem;
}

.form-container p {
    text-align: center;
    font-size: 0.95rem;
    margin-bottom: 2rem;
}

/* Labels and inputs */
label {
    display: block;
    margin-bottom: 6px;
    font-weight: bold;
}

input[type="text"],
textarea {
    width: 100%;
    padding: 0.75rem;
    border: none;
    border-radius: 8px;
    margin-bottom: 1.2rem;
    background-color: #e2e8f0;
    color: #000;
    font-size: 0.95rem;
    resize: vertical;
}

/* Submit Button */
button[type="submit"] {
    background-color: #00d9ff;
    color: #000;
    font-weight: bold;
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    width: 100%;
    font-size: 1rem;
    transition: background 0.3s ease;
}

button[type="submit"]:hover {
    background-color: #00b3cc;
}

/* Success & Error messages */
.message {
    padding: 1rem;
    margin-bottom: 1rem;
    border-radius: 8px;
    text-align: center;
    font-weight: bold;
}

.message.success {
    background-color: #c6f6d5;
    color: #22543d;
}

.message.error {
    background-color: #fed7d7;
    color: #742a2a;
}

/* Responsive tweaks */
@media (max-width: 600px) {
    .form-container {
        margin: 90px 1rem 30px;
        padding: 1.5rem;
    }
}
</style>


    <link rel="stylesheet" href="../assets/css/styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="post-project-page">
    <div id="navbar-container"></div>
    <section class="form-container">
        <h2>🔍 Looking for Collaborators?</h2>
        <p>Post your project requirements and find teammates! <strong>Be sure to add your contact info (WhatsApp or Email) so interested users can reach out to you.</strong></p>
        <?php if ($message): ?>
            <div class="message <?php echo $messageType; ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>
        <form action="post_project.php" method="POST" id="projectForm">
            <label for="project-title">Project Title:</label>
            <input type="text" id="project-title" name="project-title" placeholder="Enter project name" required>

            <label for="skills-needed">Skills Needed:</label>
            <input type="text" id="skills-needed" name="skills-needed" placeholder="e.g., Python, React, AI" required>

            <label for="project-desc">Project Description:</label>
            <textarea id="project-desc" name="project-desc" placeholder="Briefly describe your project..." required></textarea>

            <label for="contact-info">Your Contact (WhatsApp / Email):</label>
            <input type="text" id="contact-info" name="contact-info" placeholder="Enter your contact details" required>

            <button type="submit">Post Project 📢</button>
        </form>
    </section>
    

<link rel="stylesheet" href="assets/css/navbar.css"> <!-- if you have separate CSS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function(){
        $("#navbar-container").load("navbar.html", function() {
            document.getElementById('menuToggle').addEventListener('click', function() {
                document.getElementById('navLinks').classList.toggle('active');
            });
        });
    });
</script>
</body>
</html>
