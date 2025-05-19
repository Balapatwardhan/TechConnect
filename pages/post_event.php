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

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $stmt = $pdo->prepare("INSERT INTO events (title, event_date, location, category, description, registration_link, user_id) 
                              VALUES (:title, :event_date, :location, :category, :description, :registration_link, :user_id)");
        
        $stmt->execute([
            'title' => $_POST['event-title'],
            'event_date' => $_POST['event-date'],
            'location' => $_POST['event-location'],
            'category' => $_POST['event-category'],
            'description' => $_POST['event-desc'],
            'registration_link' => $_POST['register-link'] ?: null,
            'user_id' => $_SESSION['user_id']
        ]);
        
        $message = "Event posted successfully!";
        $messageType = "success";
    } catch (PDOException $e) {
        $message = "Error posting event: " . $e->getMessage();
        $messageType = "error";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post an Event | TechConnect</title>
  <style>
/* Reset & Base */
body {
    margin: 0;
    padding: 0;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #0e1a2b;
    color: #ffffff;
}

/* Sticky Navbar */
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

/* Container */
.form-container {
    max-width: 650px;
    margin: 100px auto 40px;
    background-color: #1c2a40;
    padding: 2rem;
    border-radius: 12px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.3);
}

/* Headings */
.form-container h2 {
    text-align: center;
    color: #00d9ff;
    margin-bottom: 1.5rem;
}

/* Form Elements */
label {
    display: block;
    margin-bottom: 6px;
    font-weight: bold;
}

input[type="text"],
input[type="date"],
input[type="url"],
select,
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

/* Dropdown style */
select {
    appearance: none;
    background-color: #e2e8f0;
    padding-right: 1.5rem;
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

/* Message Box */
.message {
    padding: 1rem;
    margin-bottom: 1.5rem;
    border-radius: 8px;
    font-weight: bold;
    text-align: center;
}

.message.success {
    background-color: #c6f6d5;
    color: #22543d;
}

.message.error {
    background-color: #fed7d7;
    color: #742a2a;
}

/* Responsive */
@media (max-width: 600px) {
    .form-container {
        margin: 90px 1rem 30px;
        padding: 1.5rem;
    }
}
</style>

    <link rel="stylesheet" href="../assets/css/styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .message {
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body class="post-event-page">
    <div id="navbar-container"></div>

    <section class="form-container">
        <h2>📢 Post a New Event</h2>
        
        <?php if ($message): ?>
            <div class="message <?php echo $messageType; ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" id="eventForm">
            <label for="event-title">Event Title:</label>
            <input type="text" id="event-title" name="event-title" placeholder="Enter event name" required>

            <label for="event-date">Date:</label>
            <input type="date" id="event-date" name="event-date" required>

            <label for="event-location">Location:</label>
            <input type="text" id="event-location" name="event-location" placeholder="Enter venue or 'Online'" required>

            <label for="event-category">Category:</label>
            <select id="event-category" name="event-category">
                <option value="hackathon">Hackathon</option>
                <option value="conference">Conference</option>
                <option value="workshop">Workshop</option>
                <option value="meetup">Meetup</option>
            </select>

            <label for="event-desc">Event Description:</label>
            <textarea id="event-desc" name="event-desc" placeholder="Write a brief description..." required></textarea>

            <label for="register-link">Registration Link:</label>
            <input type="url" id="register-link" name="register-link" placeholder="Enter registration link (if any)">

            <button type="submit">Post Event 🚀</button>
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