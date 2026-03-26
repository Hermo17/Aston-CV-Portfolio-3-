<?php
ini_set('display_errors', 0);
error_reporting(0);

session_start();
require 'db.php';

require 'auth_check.php';

if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    header("Location: index.php");
    exit();
}

$id = (int) $_GET["id"];

try {
    $stmt = $pdo->prepare("SELECT * FROM cvs WHERE id = ?");
    $stmt->execute([$id]);
    $cv = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $cv = null;
}

// Redirect if CV not found or if the user tries to access a CV that doesn't exist 
if (!$cv) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($cv["name"]) ?> - AstonCV</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="dashboard-page">

<div class="dashboard-wrapper">

    <div class="navbar">
        <div class="navbar-brand">Aston<span>CV</span></div>
        <div class="navbar-links">
            <a href="index.php">Browse CVs</a>
            <a href="search.php">Search</a>
            <a href="dashboard.php">My CV</a>
            <a href="logout.php" class="btn-logout">Log Out</a>
        </div>
    </div>

    <a href="index.php" class="back-link">&#8592; Back to all CVs</a>

    <div class="profile-card">

        <div class="profile-header">
            <div class="profile-avatar">
                <?= strtoupper(substr($cv["name"], 0, 1)) ?>
            </div>
            <div class="profile-title">
                <h1><?= htmlspecialchars($cv["name"]) ?></h1>
                <p class="subtitle"><?= htmlspecialchars($cv["email"]) ?></p>
                <?php if (!empty($cv["keyprogramming"])): ?>
                    <span class="cv-lang">
                        <?= htmlspecialchars($cv["keyprogramming"]) ?>
                    </span>
                <?php endif; ?>
            </div>
            <?php if ($_SESSION["user_id"] == $cv["id"]): ?>
                <a href="dashboard.php" class="btn-view">Edit My CV &#8594;</a>
            <?php endif; ?>
        </div>

        <?php if (!empty($cv["profile"])): ?>
            <div class="cv-section">
                <h3>Profile</h3>
                <p><?= nl2br(htmlspecialchars($cv["profile"])) ?></p>
            </div>
        <?php endif; ?>

        <?php if (!empty($cv["education"])): ?>
            <div class="cv-section">
                <h3>Education</h3>
                <p><?= nl2br(htmlspecialchars($cv["education"])) ?></p>
            </div>
        <?php endif; ?>

        <?php if (!empty($cv["URLlinks"])): ?>
            <div class="cv-section">
                <h3>Links</h3>
                <p>
                    <?php
                    $links = explode(",", $cv["URLlinks"]);
                    foreach ($links as $link):
                        $link = trim(htmlspecialchars($link));
                    ?>
                        <a href="<?= $link ?>" target="_blank"
                            class="cv-link"><?= $link ?></a>
                    <?php endforeach; ?>
                </p>
            </div>
        <?php endif; ?>

    </div>

</div>

</body>
</html>
