<?php
require_once "config.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

if ($_SESSION['role'] === 'admin' && isset($_GET['approve'])) {
    $id = (int) $_GET['approve'];
    $stmt = $conn->prepare("UPDATE users SET status = 'approved' WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Rhi's Lutong Bahay</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="top">Rhi’s Lutong Bahay</div>
    <h1>Kumusta, <?= h($_SESSION['username']) ?>!</h1>
    <div class="card">
        <p>You are signed in as <b><?= h($_SESSION['role']) ?></b>.</p>

        <?php if ($_SESSION['role'] === 'admin'): ?>
            <h3>Accounts waiting for approval</h3>
            <?php
            $res = $conn->query("SELECT id, username, created_at FROM users WHERE status = 'pending'");
            if ($res->num_rows === 0) {
                echo "<p class='small'>No pending accounts.</p>";
            }
            while ($row = $res->fetch_assoc()):
            ?>
                <p><?= h($row['username']) ?>
                   <a class="btn" href="dashboard.php?approve=<?= (int)$row['id'] ?>">Approve</a></p>
            <?php endwhile; ?>
        <?php endif; ?>

        <a class="btn" href="logout.php">Logout</a>
    </div>
</body>
</html>
