
<?php
require_once 'db.php';

// Fetch all events
$stmt = $pdo->query("SELECT * FROM events ORDER BY event_date DESC");
$events = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Events | TechConnect</title>
    <style>
.event-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 1.5rem;
    padding: 1rem;
}

.event-card {
    background: #fff;
    padding: 1.5rem;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.05);
    transition: transform 0.2s ease;
    color: #333; /* ✅ Make text visible */
}

.event-card h3 {
    color: #111; /* ✅ Darker heading */
    margin-top: 0;
}

.events-list h2 {
    text-align: center;
    margin-bottom: 2rem;
    color: #fff; /* ✅ Visible on dark background */
}

body.events-page {
   
    background-color: #0e1a2b;
}

.navbar {
    position: sticky;
    top: 0;
    z-index: 999;
    width: 100%;
    background: #fff;
    box-shadow: 0 2px 4px rgba(0,0,0,0.08);
    display: flex;
    align-items: center;
}

body {
    margin: 0;
    font-family: sans-serif;
}

.dashboard-container,
.form-container,
.projects-list,
.events-list {
    margin-top: 90px;
}
</style>

    <link rel="stylesheet" href="../assets/css/styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="events-page">
<style>body {
    padding-top: 0px; /* match navbar height */
}


</style>
    <div id="navbar-container"></div>
    <section class="events-list">
    <h2>Upcoming Events</h2>
    <?php if (empty($events)): ?>
        <p>No events found.</p>
    <?php else: ?>
        <div class="event-grid"> <!-- 👈 Add this -->
        <?php foreach ($events as $event): ?>
            <div class="event-card">
                <h3><?php echo htmlspecialchars($event['title']); ?></h3>
                <p><strong>Date:</strong> <?php echo htmlspecialchars($event['event_date']); ?></p>
                <p><strong>Location:</strong> <?php echo htmlspecialchars($event['location']); ?></p>
                <p><strong>Category:</strong> <?php echo htmlspecialchars($event['category']); ?></p>
                <p><?php echo nl2br(htmlspecialchars($event['description'])); ?></p>
                <?php if (!empty($event['registration_link'])): ?>
                    <p><a href="<?php echo htmlspecialchars($event['registration_link']); ?>" target="_blank">Register Here</a></p>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
        </div> <!-- 👈 Close the grid -->
    <?php endif; ?>
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