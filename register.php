<?php
require_once "config.php";
$errors = [];
$success = "";

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $username  = trim($_POST['uname']);
    $password  = $_POST['password'];
    $password2 = $_POST['password2'];

    if (strlen($username) < 3) {
        $errors[] = "Username must be at least 3 characters.";
    }
    if (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters.";
    }
    if ($password !== $password2) {
        $errors[] = "Passwords should match.";
    }

    if (!$errors) {
        // Is the username already taken?
        $check = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $check->bind_param("s", $username);
        $check->execute();
        if ($check->get_result()->num_rows > 0) {
            $errors[] = "That username is already taken.";
        } else {
            // Save with a hashed password. Status defaults to 'pending'.
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            $stmt->bind_param("ss", $username, $hash);
            if ($stmt->execute()) {
                $success = "Registered successfully! Please wait for the admin approval of your account.";
            } else {
                $errors[] = "Something went wrong. Please try again later.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Rhi's Lutong Bahay</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="top">Rhi’s Lutong Bahay</div>
    <h1>Join our tasty community!</h1>
    <div class="card">
        <?php foreach ($errors as $e): ?>
            <p class="error"><?= h($e) ?></p>
        <?php endforeach; ?>
        <?php if ($success): ?>
            <p class="success"><?= h($success) ?></p>
        <?php endif; ?>
        <form action="" method="post">
            <input type="text" name="uname" placeholder="Username" required>
            <input type="password" name="password" placeholder="Create Password" required>
            <input type="password" name="password2" placeholder="Confirm Password" required>
            <input type="submit" value="Register">
        </form>
        <p class="small">Already have an account? <a href="index.php">Sign In</a></p>
    </div>
</body>
</html>
