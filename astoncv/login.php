<?php
ini_set('display_errors', 0);
error_reporting(0);

// SECURITY method no 1: Session managements
session_start();
require 'db.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // SECURITY method no 2: HTML Injection Prevention via htmlspecialchars()
    $email    = trim(htmlspecialchars($_POST["email"]));
    $password = trim($_POST["password"]);

    // SECURITY method no 3: Server-side Form of Validation
    if (empty($email) || empty($password)) {
        $error = "All fields are required.";
    } else {
        try {
            // SECURITY method no  4: SQL Injection Prevention via Prepared Statements
            $stmt = $pdo->prepare("SELECT * FROM cvs WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // SECURITY method no 5: Secure Password Verification 
            if ($user && password_verify($password, $user["password"])) {

                // SECURITY method no 6: Authentication via Sessions user data stored server-side — not in the browser
                $_SESSION["user_id"]   = $user["id"];
                $_SESSION["user_name"] = $user["name"];
                header("Location: index.php");
                exit();
            } else {
                $error = "Invalid email or password.";
            }
        } catch (PDOException $e) {
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
    <title>Login - AstonCV</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="auth-wrapper">
    <div class="auth-top">
        <div class="auth-logo">Aston<span>CV</span></div>
        <div class="auth-tagline">Programmer CV Database</div>
    </div>

    <div class="auth-pills">
        <div class="auth-pill">&#128269; Search CVs</div>
        <div class="auth-pill">&#128196; Browse professional profiles</div>
        <div class="auth-pill">&#128274; Secure login</div>
    </div>

    <div class="card">
        <h2>Welcome Back</h2>
        <p class="subtitle">Log in to manage your CV and to view other professionals users' CVs.</p>

        <?php if ($error): ?>
            <div class="error"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST" action="login.php">
            <label>Email Address</label>
            <input type="email" name="email"
                placeholder="you@example.com" required>

            <label>Password</label>
            <input type="password" name="password"
                placeholder="••••••••" required>

            <button type="submit">Log In &#8594;</button>
        </form>

        <div class="card-footer">
            Don't have an account? <a href="register.php">Register here</a>
        </div>
    </div>
</div>

</body>
</html>
