<?php
require_once('connect.php');

$id = $_GET['id'];
$ba_ids = [];

if (isset($_POST['book_submit']) && $_POST['book_submit'] == 'Salvesta') {
 
    $stmt = $pdo->prepare('UPDATE books SET title = :title, release_date = :release_date, type = :type WHERE id = :id');
    $stmt->execute(['title' => $_POST['title'], 'id' => $id, 'release_date' => $_POST['year'], 'type' => $_POST['type']]);
    header("Location: book.php?id=$id");
}

if (isset($_POST['author_submit']) && $_POST['author_submit'] == 'Salvesta') {
    $author_id = $_POST['author']; 
    $stmt = $pdo->prepare('INSERT INTO book_authors (book_id, author_id) VALUES (:book_id, :author_id)');
    $stmt->execute(['author_id' => $author_id, 'book_id' => $id]);
    header("Location: edit.php?id=$id");
}


if (isset($_POST['delete_author']) && $_POST['delete_author'] == 'Delete Author') {
    $stmt = $pdo->prepare('DELETE FROM book_authors WHERE id = :id');
    $stmt->execute(['id' => $_POST['book_authors_id']]);
    header("Location: edit.php?id=$id");
}


$stmt = $pdo->prepare('SELECT * FROM books WHERE books.id = :id');
$stmt->execute(['id' => $id]);
$book = $stmt->fetch();

$stmt_author = $pdo->query('SELECT * FROM authors');

$stmt_book_author = $pdo->prepare('SELECT ba.id as  book_authors_id,  a.* FROM book_authors ba LEFT JOIN authors a ON ba.author_id = a.id WHERE book_id = :id');
$stmt_book_author->execute(['id' => $id ]);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Muuda</h1>


    <form action="edit.php?id=<?= $id ;?>" method="post">
        Title: <input type="text" name="title" value="<?= $book['title']; ?>">
        Year: <input type="number" name="year" value="<?= $book['release_date']; ?>">
      
        <select name="type">
            <option value="ebook">ebook</option>
            <option value="new">new</option>
            <option value="used">used</option>
        </select>
        <input type="submit" name="book_submit" value="Salvesta">
    </form>

    <ul>
    <?php
    while ($row = $stmt_book_author->fetch()) {
        $ba_ids[] = $row['id'];
?>
    <li>
        
        <?=$row['first_name']?><?=$row['last_name']?>
        <form action="edit.php?id=<?= $id ;?>" method="post" style="display:inline;">
                <input type="submit" name="delete_author" value="Delete Author">
                <input type="hidden" name="book_authors_id" value="<?=$row['book_authors_id']?>">
            </form>
        
    </li>   

<?php
}
?>
</ul>

    <form action="edit.php?id=<?= $id ;?>" method="post">
        <select name="author">
            <?php while ($row = $stmt_author->fetch()) {
                    if ( !in_array($row['id'], $ba_ids) ){ 
                ?>
                <option value="<?=$row['id'];?>">
                    <?=$row['first_name'];?> <?=$row['last_name'];?>
                </option>
            <?php }} ?>
        </select>
        <input type="submit" name="author_submit" value="Salvesta">
    </form>
</body>
</html>
