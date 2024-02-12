<?php
require_once('connect.php');

if(isset($_GET['search'])) {
    $search = '%' . $_GET['search'] . '%';
    $stmt = $pdo->prepare('SELECT * FROM books WHERE title LIKE :title OR type LIKE :type');
    $stmt->bindParam(':title', $search, PDO::PARAM_STR);
    $stmt->bindParam(':type', $search, PDO::PARAM_STR);
    $stmt->execute();
} else {
    $stmt = $pdo->query('SELECT * FROM books');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Real</title>
</head>
<body>
    <form action="" method="GET">
        <input type="text" name="search" placeholder="Search...">
        <button type="submit">Search</button>
    </form>
    
    <ul>
        <?php
        while ($row = $stmt->fetch()) {
        ?>
            <li>
                <a href="book.php?id=<?= $row['id']; ?>">
                    <?= $row['title']; ?>
                    <?= $row['release_date']; ?>
                    <?= $row['type']; ?>
                </a>
            </li>   
        <?php
        }
        ?>
    </ul>
</body>
</html>
