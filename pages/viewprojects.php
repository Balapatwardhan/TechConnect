
<?php
require_once 'db.php';
$stmt = $pdo->query("SELECT * FROM projects ORDER BY id DESC");
$projects = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Projects | TechConnect</title>
    <style>
.navbar {
    position: sticky;
    top: 0;
    z-index: 999;
    width: 100%;
    background: #fff;
    box-shadow: 0 2px 4px rgba(0,0,0,0.08);
    display: flex;
    align-items: center;
    padding: 1rem 2rem;
}
body {
    margin: 0;
    font-family: sans-serif;
}
.dashboard-container,
.form-container,
.projects-list,
.events-list {
    margin-top: 90px; /* Adjust if your navbar is taller/shorter */
}

.project-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 2rem;
    padding: 2rem;
    max-width: 1200px;
    margin: 0 auto;
}

.project-card {
    background: white;
    border-radius: 10px;
    padding: 1.5rem;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.08);
    transition: transform 0.2s ease;
}

.project-card:hover {
    transform: translateY(-5px);
}

.projects-list h2 {
    text-align: center;
    margin-top: 2rem;
}
body.projects-page {
    background-color: #f9fafb;
}

</style>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="projects-page">
    <div id="navbar-container"></div>
   <section class="projects-list">
    <h2>Find a Project to Join</h2>
    <?php if (empty($projects)): ?>
        <p>No projects posted yet.</p>
    <?php else: ?>
        <div class="project-grid">
            <?php foreach ($projects as $project): ?>
                <div class="project-card">
                    <h3><?php echo htmlspecialchars($project['title']); ?></h3>
                    <p><strong>Skills Needed:</strong> <?php echo htmlspecialchars($project['skills_needed']); ?></p>
                    <p><?php echo nl2br(htmlspecialchars($project['description'])); ?></p>
                    <p><strong>Contact:</strong> <?php echo htmlspecialchars($project['contact_info']); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>

    <script>
        $(document).ready(function(){
            $("#navbar-container").load("navbar.html");
        });
    </script>
</body>
</html>