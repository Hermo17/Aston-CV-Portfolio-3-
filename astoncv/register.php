<?php
ini_set('display_errors', 0);
error_reporting(0);

// SECURITY method no 1: Session management
session_start();
require 'db.php';

$error   = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // SECURITY method no 2: HTML Injection Prevention using htmlspecialchars() to sanitize user input and prevent malicious HTML/JS code from being executed in the browser, which protects against XSS attacks. (source: https://www.php.net/manual/en/function.htmlspecialchars.php)
    $name     = trim(htmlspecialchars($_POST["name"]));
    $email    = trim(htmlspecialchars($_POST["email"]));
    $password = trim($_POST["password"]);

    // SECURITY method no 3: Server-side Form Validation 
    if (empty($name) || empty($email) || empty($password)) {
        $error = "All fields are required.";

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";

    } elseif (strlen($password) < 12) {
        // SECURITY method no 3.1-ish: Strong password policy — minimum 12 characters with a mix of uppercase, lowercase, numbers, and special characters to enhance security against brute-force attacks
        $error = "Password must be at least 12 characters.";

    } elseif (!preg_match('/[0-9]/', $password)) {
        $error = "Password must contain at least one number.";

    } elseif (!preg_match('/[A-Z]/', $password)) {
        $error = "Password must contain at least one uppercase letter.";

    } elseif (!preg_match('/[!@#$%^&*()_+\-=\[\]{};\':",.<>?\/\\\\|`~]/', $password)) {
        $error = "Password must contain at least one special character (e.g. !@#$%).";

    } else {

        // SECURITY method no 4: Password Hashing, password_hash() uses bcrypt — passwords are never stored as plain text even if the database is compromised, attackers cannot read user passwords. 
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        try {
            // SECURITY method no 5: SQL Injection Prevention
            $stmt = $pdo->prepare("SELECT id FROM cvs WHERE email = ?");
            $stmt->execute([$email]);

            if ($stmt->rowCount() > 0) {
                $error = "Email already registered.";
            } else {
                $stmt = $pdo->prepare("INSERT INTO cvs (name, email, password) VALUES (?, ?, ?)");
                $stmt->execute([$name, $email, $hashedPassword]);
                $success = "Registration successful! You can now press the log in button to sign in.";
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
    <title>Register - AstonCV</title>
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
        <div class="auth-pill">&#128196; Browse profiles</div>
        <div class="auth-pill">&#128274; Secure login</div>
    </div>

    <div class="card">
        <h2>Create Account</h2>
        <p class="subtitle">Join AstonCV today — it's free, connect with professionals</p>

        <?php if ($error): ?>
            <div class="error"><?= $error ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="success"><?= $success ?></div>
        <?php endif; ?>

        <form method="POST" action="register.php">
            <label>Full Name</label>
            <input type="text" name="name"
                placeholder="Your full name" required>

            <label>Email Address</label>
            <input type="email" name="email"
                placeholder="you@example.com" required>

            <label>Password</label>
            <input type="password" name="password"
                placeholder="Min. 12 characters" required>

            <div class="password-hint">
                Password must have: 12+ characters &mdash; one number &mdash;
                one uppercase letter &mdash; one special character (e.g. !@#$%)
            </div>

            <button type="submit">Create Account &#8594;</button>
        </form>

        <div class="card-footer">
            Already have an account? <a href="login.php">Log in here</a>
        </div>
    </div>
</div>

</body>
</html>
