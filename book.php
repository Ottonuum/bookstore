<?php

require_once('connect.php');

$id = $_GET['id'];

$stmt = $pdo->prepare('SELECT * FROM books WHERE id = :id');
$stmt->execute(['id' => $id ]);
$books = $stmt->fetch();

var_dump($book);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1><?= $book['title'] ?></h1>
    <span style="font-size 18px;">Aaasta</span><span style="font size 32px">1988</span>
</body>
</html>
