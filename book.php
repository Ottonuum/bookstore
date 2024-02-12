<?php

require_once('connect.php');

$id = $_GET['id'];

$stmt = $pdo->prepare('SELECT * FROM books WHERE id = :id');
$stmt->execute(['id' => $id ]);
$book = $stmt->fetch();


$stmt = $pdo->prepare('SELECT * FROM book_authors ba LEFT JOIN authors a ON ba.author_id=a.id WHERE book_id = :id');
$stmt->execute(['id' => $id ]);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1><?=$book['title']?></h1>
    <h1><?=$book['release_date']?></h1>
    <h1><?=$book['type']?></h1>
    <br><br>
    <span style></span>

    <ul>
    <?php
    while ($row = $stmt->fetch()) {
?>
    <li>
        <a href="">
            <?=$row['first_name']?><?=$row['last_name']?>
        </a>
    </li>   

<?php
}
?>
</ul>
        <a href="edit.php?id=<?=$id?>">Muuda</a>
        
        <form action="delete.php" method="POST">
        <input type="hidden" name="book_id" value="<?= $id ?>">
        <button type="submit" onclick="return confirm('Are you sure you want to delete this book?')">Delete</button>
    </form>

    <a href="edit.php?id=<?= $id ?>">Muuda</a>
</body>
</html>
