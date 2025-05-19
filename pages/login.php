<?php
session_start();
require_once 'db.php'; // Use your existing db.php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Prepare and execute query using PDO
    $stmt = $pdo->prepare("SELECT id, password FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        header("Location: dashboard.html");
        exit();
    } else {
        $error = "Invalid email or password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login | TechConnect</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <style>
/* General Reset */
body {
    margin: 0;
    padding: 0;
    background-color: #0e1a2b;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    color: #ffffff;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

/* Login Container */
.login-container {
    background-color: #1c2a40;
    padding: 2.5rem;
    border-radius: 12px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.3);
    width: 100%;
    max-width: 400px;
    text-align: center;
}

/* Title */
.title {
    font-size: 2rem;
    color: #00d9ff;
    margin-bottom: 2rem;
}

/* Form */
.login-form input {
    width: 100%;
    padding: 0.75rem;
    margin-bottom: 1rem;
    border: none;
    border-radius: 8px;
    background-color: #e2e8f0;
    color: #000;
    font-size: 1rem;
}

.login-form button {
    width: 100%;
    padding: 0.75rem;
    background-color: #00d9ff;
    color: #000;
    border: none;
    border-radius: 8px;
    font-weight: bold;
    font-size: 1rem;
    cursor: pointer;
    transition: background 0.3s ease;
}

.login-form button:hover {
    background-color: #00b3cc;
}

/* Error Message */
p[style*="color:red"] {
    background-color: #fed7d7;
    color: #721c24;
    padding: 0.75rem;
    border-radius: 8px;
    font-weight: bold;
    margin-bottom: 1rem;
}

/* Signup Text */
.signup-text {
    margin-top: 1rem;
    font-size: 0.9rem;
}

.signup-text a {
    color: #00d9ff;
    text-decoration: none;
    font-weight: bold;
}

.signup-text a:hover {
    text-decoration: underline;
}

/* Responsive */
@media (max-width: 500px) {
    .login-container {
        margin: 1rem;
        padding: 2rem 1.5rem;
    }
}
</style>

</head>
<body>
    <div class="login-container">
        <h1 class="title">TechConnect</h1>
        <?php if (isset($error)): ?>
            <p style="color:red;"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
        <form class="login-form" method="POST" action="login.php">
            <input type="email" name="email" placeholder="Enter your email" required>
            <input type="password" name="password" placeholder="Enter your password" required>
            <button type="submit">Login</button>
        </form>
        <p class="signup-text">New here? <a href="signup.php">Sign up</a></p>
    </div>
</body>
</html>
