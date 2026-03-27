<?php
ini_set('display_errors', 0);
error_reporting(0);

session_start();
require 'db.php';

require 'auth_check.php';

// SECURITY CSRF Protection via Tokens
if (empty($_SESSION["csrf_token"])) {
    $_SESSION["csrf_token"] = bin2hex(random_bytes(32));
}

$error   = "";
$success = "";

// sql query to get the current user's CV data to pre-fill the form
$stmt = $pdo->prepare("SELECT * FROM cvs WHERE id = ?");
$stmt->execute([$_SESSION["user_id"]]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

   
    if (!isset($_POST["csrf_token"]) || $_POST["csrf_token"] !== $_SESSION["csrf_token"]) {
        die("Invalid CSRF token. Request blocked.");
    }

    $name           = trim(htmlspecialchars($_POST["name"]));
    $keyprogramming = trim(htmlspecialchars($_POST["keyprogramming"]));
    $profile        = trim(htmlspecialchars($_POST["profile"]));
    $education      = trim(htmlspecialchars($_POST["education"]));
    $URLlinks       = trim(htmlspecialchars($_POST["URLlinks"]));

    
    if (empty($name)) {
        $error = "Name cannot be empty.";
    } else {
        try {
            
            $stmt = $pdo->prepare("
                UPDATE cvs
                SET name           = ?,
                    keyprogramming = ?,
                    profile        = ?,
                    education      = ?,
                    URLlinks       = ?
                WHERE id = ?
            ");
            $stmt->execute([
                $name,
                $keyprogramming,
                $profile,
                $education,
                $URLlinks,
                $_SESSION["user_id"]
            ]);

            $_SESSION["user_name"] = $name;
            $success = "Your CV has been updated successfully!";

            $stmt = $pdo->prepare("SELECT * FROM cvs WHERE id = ?");
            $stmt->execute([$_SESSION["user_id"]]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
           $error = $e->getMessage();   
            $error = "Something went wrong. Please try again.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - AstonCV</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="dashboard-page">

<div class="dashboard-wrapper">

    <div class="navbar">
        <div class="navbar-brand">Aston<span>CV</span></div>
        <div class="navbar-links">
            <a href="index.php">Browse CVs</a>
            <a href="search.php">Search</a>
            <a href="logout.php" class="btn-logout">Log Out</a>
        </div>
    </div>

    <div class="dashboard-header">
        <div>
            <h1>Welcome, <?= htmlspecialchars($_SESSION["user_name"]) ?></h1>
            <p class="subtitle">Update your CV — visible to everyone on AstonCV.</p>
        </div>
        <a href="view.php?id=<?= $_SESSION["user_id"] ?>" class="btn-view">View My CV &#8594;</a>
    </div>

    <?php if ($error): ?>
        <div class="error"><?= $error ?></div>
    <?php endif; ?>
    <?php if ($success): ?>
        <div class="success"><?= $success ?></div>
    <?php endif; ?>

    <div class="dashboard-card">
        <form method="POST" action="dashboard.php">
            <input type="hidden" name="csrf_token"
                value="<?= $_SESSION["csrf_token"] ?>">

            <div class="form-section">
                <h3>Basic Information</h3>
                <div class="form-grid">
                    <div>
                        <label>Full Name</label>
                        <input type="text" name="name"
                            placeholder="Your full name"
                            value="<?= htmlspecialchars($user["name"]) ?>" required>
                    </div>
                    <div>
                        <label>Key Programming Language</label>
                        <input type="text" name="keyprogramming"
                            placeholder="e.g. Python, JavaScript, PHP"
                            value="<?= htmlspecialchars($user["keyprogramming"] ?? '') ?>">
                    </div>
                </div>
            </div>

            <div class="form-section">
                <h3>Profile Summary</h3>
                <textarea name="profile" rows="4"
                    placeholder="Write a short summary about yourself..."><?= htmlspecialchars($user["profile"] ?? '') ?></textarea>
            </div>

            <div class="form-section">
                <h3>Education</h3>
                <textarea name="education" rows="4"
                    placeholder="e.g. BSc Computer Science, Aston University, 2021-2024"><?= htmlspecialchars($user["education"] ?? '') ?></textarea>
            </div>

            <div class="form-section">
                <h3>URL Links</h3>
                <input type="text" name="URLlinks"
                    placeholder="e.g. https://github.com/yourname"
                    value="<?= htmlspecialchars($user["URLlinks"] ?? '') ?>">
            </div>

            <button type="submit">Save CV &#8594;</button>

        </form>
    </div>

</div>

</body>
</html>
