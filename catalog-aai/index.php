<?php
require 'db_aai.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['title'])) {
    $title = $mysqli->real_escape_string($_POST['title']);
    $mysqli->query("INSERT INTO items_aai (title) VALUES ('$title')");
    header("Location: index.php"); 
    exit;
}


if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];
    $mysqli->query("DELETE FROM items_aai WHERE id=$id");
    header("Location: index.php");
    exit;
}


$result = $mysqli->query("SELECT id, title, created_at FROM items_aai ORDER BY created_at DESC LIMIT 10");


$count_result = $mysqli->query("SELECT COUNT(*) AS c FROM items_aai");
$count = $count_result->fetch_assoc()['c'];
?>
<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <title>My List – aai</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>My List – aai</h1>

    <form method="post">
        <input type="text" name="title" placeholder="عنوان آیتم" required>
        <button type="submit">ثبت</button>
    </form>

    <ul>
        <?php while ($row = $result->fetch_assoc()): ?>
            <li>
                <?= htmlspecialchars($row['title']) ?> 
                (<?= $row['created_at'] ?>)
                <a href="?delete=<?= $row['id'] ?>">حذف</a>
            </li>
        <?php endwhile; ?>
    </ul>

    <p>تعداد کل آیتم‌ها: <?= $count ?></p>
</body>
</html>
