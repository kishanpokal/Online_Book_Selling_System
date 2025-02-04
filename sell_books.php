      <?php
session_start();
if (!isset($_SESSION['uname'])) {
    echo "You are logged out. Please log in again.";
    header('location: userlogin.php');
    exit();
}
include "dbconn.php"; // Using database connection file here
$uid = $_GET['uid'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sell Books</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(120deg, #6c63ff, #5edfff);
            font-family: 'Arial', sans-serif;
        }

        .form-container {
            max-width: 700px;
            margin: 50px auto;
            background: #fff;
            padding: 20px 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
        }

        .form-container h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #6c63ff;
        }

        label {
            font-weight: bold;
        }

        .btn-primary {
            background-color: #6c63ff;
            border: none;
        }

        .btn-primary:hover {
            background-color: #5edfff;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="form-container">
            <h2>Sell Your Book</h2>
            <form action="http://localhost/obss/sell_books_code.php?uid=<?php echo $uid ?>" method="POST" enctype="multipart/form-data">
                <?php if (isset($_SESSION['uname'])): ?>
                    <div class="alert alert-success text-center">
                        Welcome, <?php echo $_SESSION['uname']; ?>!
                    </div>
                <?php endif; ?>

                <div class="mb-3">
                    <label for="product_name" class="form-label">Book Name</label>
                    <input type="text" id="product_name" name="product_name" class="form-control" placeholder="Enter the book name" required>
                </div>

                <div class="mb-3">
                    <label for="genre" class="form-label">Genre</label>
                    <select class="form-select" name="genre" id="genre" required>
                        <option value="">Choose a genre</option>
                        <option value="Art/architecture">Art/architecture</option>
      <option value="Alternate history">Alternate history</option>
      <option value="Autobiography">Autobiography</option>
      <option value="Anthology">Anthology</option>
      <option value="Biography">Biography</option>
      <option value="Business/economics">Business/economics</option>
      <option value="Children's">Children's</option>
      <option value="Crafts/hobbies">Crafts/hobbies</option>
      <option value="Classic">Classic</option>
      <option value="Comedy">Comedy</option>
      <option value="Cookbook">Cookbook</option>
      <option value="Comic book">Comic book</option>
      <option value="Diary">Diary</option>
      <option value="Coming-of-age">Coming-of-age</option>
      <option value="Dictionary">Dictionary</option>
      <option value="Crime">Crime</option>
      <option value="Encyclopedia">Encyclopedia</option>
      <option value="Drama">Drama</option>
      <option value="Guide">Guide</option>
      <option value="Fairytale">Fairytale</option>
      <option value="Health/fitness">Health/fitness</option>
      <option value="Fantasy">Fantasy</option>
      <option value="History">History</option>
      <option value="Graphic novel">Graphic novel</option>
      <option value="Home and garden">Home and garden</option>
      <option value="Historical fiction">Historical fiction</option>
      <option value="Horror">Horror</option>
      <option value="Humor">Humor</option>
      <option value="Journal">Journal</option>
      <option value="Memoir">Memoir</option>
      <option value="Manga">Manga</option>
      <option value="Mystery">Mystery</option>
      <option value="Paranormal">Paranormal</option>
      <option value="Philosophy">Philosophy</option>
      <option value="Poetry">Poetry</option>
      <option value="Political">Political</option>
      <option value="Religion/spirituality">Religion/spirituality</option>
      <option value="Romance">Romance</option>
      <option value="Satire">Satire</option>
      <option value="Science fiction">Science fiction</option>
      <option value="Self-help">Self-help</option>
      <option value="Short story">Short story</option>
      <option value="Sports">Sports</option>
      <option value="Thriller">Thriller</option>
      <option value="Travel">Travel</option>
      <option value="True crime">True crime</option>
      <option value="Western">Western</option>
      <option value="Young adult">Young adult</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="available_quantity" class="form-label">Available Quantity</label>
                    <input type="number" id="available_quantity" name="available_quantity" class="form-control" placeholder="Enter the quantity" required>
                </div>

                <div class="mb-3">
                    <label for="product_description" class="form-label">Description</label>
                    <textarea id="product_description" name="product_description" class="form-control" rows="4" placeholder="Describe your book" required></textarea>
                </div>

                <div class="mb-3">
                    <label for="price" class="form-label">Price</label>
                    <input type="number" id="price" name="price" class="form-control" placeholder="Enter the price" required>
                </div>

                <div class="mb-3">
                    <label for="author" class="form-label">Author</label>
                    <input type="text" id="author" name="author" class="form-control" placeholder="Enter the author's name" required>
                </div>

                <div class="mb-3">
                    <label for="bookimage" class="form-label">Upload Book Image</label>
                    <input type="file" id="bookimage" name="bookimage" class="form-control" required>
                </div>

                <div class="d-grid">
                    <button type="submit" name="sell" class="btn btn-primary">Add Book</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
