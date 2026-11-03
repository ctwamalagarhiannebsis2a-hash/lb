<?php
require_once "config.php";
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $username = trim($_POST['uname']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        if ($user['status'] !== 'approved') {
            $errors[] = "Your account is still waiting for admin approval.";
        } else {
            $_SESSION['user_id']  = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role']     = $user['role'];
            header("Location: dashboard.php");
            exit;
        }
    } else {
        $errors[] = "Invalid username or password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In | Rhi's Lutong Bahay</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="top">Rhi’s Lutong Bahay</div>
    <h1>Welcome back!</h1>
    <div class="card">
        <?php foreach ($errors as $e): ?>
            <p class="error"><?= h($e) ?></p>
        <?php endforeach; ?>
        <form action="" method="post">
            <input type="text" name="uname" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="submit" value="Sign In">
        </form>
        <p class="small">No account yet? <a href="register.php">Register</a></p>
    </div>
</body>
</html>
