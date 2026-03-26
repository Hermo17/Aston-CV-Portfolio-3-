<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

// SECURITY 1: Session management
session_start();
require 'db.php';

// SECURITY method no 2: Require login to search, as i have mentioned on index.php, i don't want to show the list of CVs to unauthenticated users or users who are not members of the platform. This protects user data and ensures only authorized access to CVs.
require 'auth_check.php';

$results  = [];
$searched = false;
$query    = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $searched = true;

    // SECURITY: HTML Injection Prevention 
    $query = trim(htmlspecialchars($_POST["query"]));

    if (!empty($query)) {
        try {
            // SECURITY: SQL Injection Prevention
            // LIKE with ? placeholder safely handles wildcard searches
            $stmt = $pdo->prepare("
                SELECT id, name, email, keyprogramming
                FROM cvs
                WHERE name LIKE ?
                   OR keyprogramming LIKE ?
                ORDER BY name ASC
            ");
            $like = "%" . $query . "%";
            $stmt->execute([$like, $like]);
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $results = [];
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search - AstonCV</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="dashboard-page">

<div class="dashboard-wrapper">

    <div class="navbar">
        <div class="navbar-brand">Aston<span>CV</span></div>
        <div class="navbar-links">
            <a href="index.php">Browse CVs</a>
            <a href="dashboard.php">My CV</a>
            <a href="logout.php" class="btn-logout">Log Out</a>
        </div>
    </div>

    <div class="page-header">
        <div>
            <h1>Search CVs</h1>
            <p class="subtitle">Find developers by name or programming language</p>
        </div>
    </div>

    <div class="search-card">
        <form method="POST" action="search.php">
            <div class="search-row">
                <input type="text" name="query"
                    placeholder="e.g. Python, JavaScript, John..."
                    value="<?= htmlspecialchars($query) ?>" required>
                <button type="submit">Search &#8594;</button>
            </div>
        </form>
    </div>

    <?php if ($searched): ?>
        <div class="results-header">
            <?php if (empty($results)): ?>
                <p class="subtitle">
                    No results found for
                    "<strong><?= htmlspecialchars($query) ?></strong>"
                </p>
            <?php else: ?>
                <p class="subtitle">
                    <?= count($results) ?>
                    result<?= count($results) !== 1 ? 's' : '' ?> for
                    "<strong><?= htmlspecialchars($query) ?></strong>"
                </p>
            <?php endif; ?>
        </div>

        <?php if (!empty($results)): ?>
            <div class="cv-grid">
                <?php foreach ($results as $cv): ?>
                    <a href="view.php?id=<?= $cv["id"] ?>" class="cv-card">
                        <div class="cv-avatar">
                            <?= strtoupper(substr($cv["name"], 0, 1)) ?>
                        </div>
                        <div class="cv-info">
                            <h3><?= htmlspecialchars($cv["name"]) ?></h3>
                            <p class="cv-email">
                                <?= htmlspecialchars($cv["email"]) ?>
                            </p>
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
    <?php endif; ?>

</div>

</body>
</html>