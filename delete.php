<?php
require_once('connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['book_id'])) {
    $book_id = $_POST['book_id'];

    $stmt = $pdo->prepare('DELETE FROM books WHERE id = :book_id');
    $stmt->execute(['book_id' => $book_id]);

    // Redirect to a confirmation page or any other appropriate location after deletion
    header('Location: confirmation.php');
    exit();
} else {
    // Handle cases where the request method is not POST or book_id is not set
    // Redirect to an error page or any other appropriate action
    header('Location: error.php');
    exit();
}
?>
