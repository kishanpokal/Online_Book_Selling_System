<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "kishan12";
$dbname = "obss";
$uid = $_GET['uid'];

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed because " . mysqli_connect_error());
}

if (isset($_POST['sell'])) {
    // Sanitize and retrieve form data
    $bn = mysqli_real_escape_string($conn, $_POST['product_name']);
    $genre = mysqli_real_escape_string($conn, $_POST['genre']);
    $qty = (int)$_POST['available_quantity']; // Cast to integer for safety
    $desc = mysqli_real_escape_string($conn, $_POST['product_description']);
    $price = (float)$_POST['price']; // Cast to float for safety
    $author = mysqli_real_escape_string($conn, $_POST['author']);
    $bookfilename = $_FILES["bookimage"]["name"];
    $tempname = $_FILES["bookimage"]["tmp_name"]; // Corrected key name
    $bookfolder = "C:/xampp/htdocs/obss/book_image/" . $bookfilename;

    // Insert query
    $query = "INSERT INTO user_selled_books (book_name, book_price, book_qty, author_name, genre, book_image, description, uid)
              VALUES ('$bn', '$price', '$qty', '$author', '$genre', '$bookfilename', '$desc', '$uid')";

    // Execute the query and handle file upload
    $data = mysqli_query($conn, $query);

    if ($data && move_uploaded_file($tempname, $bookfolder)) {
        echo '<script language="javascript">';
        echo 'alert("Successfully Updated"); location.href="http://localhost/obss/sell_books.php?uid=' . $uid . '"';
        echo '</script>';
    } else {
        echo '<script language="javascript">';
        echo 'alert("Not Updated"); location.href="http://localhost/obss/sell_books.php?uid=' . $uid . '"';
        echo '</script>';
    }
    mysqli_close($conn);
}
?>
