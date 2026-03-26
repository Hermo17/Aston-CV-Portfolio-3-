<?php
ini_set('display_errors', 0);
error_reporting(0);

// SECURITY: Session management
session_start();
require 'db.php';

// SECURITY feature: Require login to view this page as i don't want to show the list of CVs to unauthenticated users or users who are not members of the platform. This protects user data and ensures only authorized access to CVs.
require 'auth_check.php';

try {
    // SECURITY: Prepared statement — good practice even without user input to prevent SQL injection and ensure safe database interactions (source: https://www.php.net/manual/en/pdo.prepared-statements.php)
    $stmt = $pdo->query("SELECT id, name, email, keyprogramming FROM cvs ORDER BY name ASC");
    $cvs  = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $cvs = [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AstonCV — Browse Developers</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="dashboard-page">

<div class="dashboard-wrapper">

    <div class="navbar">
        <div class="navbar-brand">Aston<span>CV</span></div>
        <div class="navbar-links">
            <a href="search.php">Search</a>
            <a href="dashboard.php">My CV</a>
            <a href="logout.php" class="btn-logout">Log Out</a>
        </div>
    </div>

    <div class="page-header">
        <div>
            <h1>Browse Developers</h1>
            <p class="subtitle">
                <?= count($cvs) ?> developer<?= count($cvs) !== 1 ? 's' : '' ?>
                registered on AstonCV
            </p>
        </div>
        <a href="search.php" class="btn-view">Search CVs &#8594;</a>
    </div>

    <?php if (empty($cvs)): ?>
        <div class="empty-state">
            <p>No CVs yet. <a href="dashboard.php">Add yours first!</a></p>
        </div>
    <?php else: ?>
        <div class="cv-grid">
            <?php foreach ($cvs as $cv): ?>
                <a href="view.php?id=<?= $cv["id"] ?>" class="cv-card">
                    <div class="cv-avatar">
                        <?= strtoupper(substr($cv["name"], 0, 1)) ?>
                    </div>
                    <div class="cv-info">
                        <h3><?= htmlspecialchars($cv["name"]) ?></h3>
                        <p class="cv-email"><?= htmlspecialchars($cv["email"]) ?></p>
                        <?php if (!empty($cv["keyprogramming"])): ?>
                            <span class="cv-lang">
                                <?= htmlspecialchars($cv["keyprogramming"]) ?>
                            </span>
                        <?php endif; ?>
                    </div>
                    <div class="cv-arrow">&#8594;</div>
                </a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

</div>

</body>
</html>
