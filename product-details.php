<?php
session_start();
?>

<?php
$uid = $_GET['uid'];
if (!isset($_SESSION['uname'])) {
  echo "You are logged out. Please log in again.";
  header('location: userlogin.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="shortcut icon" href="./images/favicon.ico" type="image/x-icon">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css" />
  <link rel="stylesheet" href="css/cart.css" />
  <title>OBSS</title>
  <style>
    /* General Styles */
    body {
      background-image: url('images/background2.jpg');
      background-size: cover;
      background-attachment: fixed;
      background-repeat: no-repeat;
      background-position: center;
      color: white;
      font-family: Arial, sans-serif;
    }

    /* Navigation Bar */
    .nav {
      background: rgba(0, 0, 0, 0.8);
      color: white;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 15px 30px;
      position: fixed;
      top: 0;
      width: 100%;
      z-index: 1000;
    }

    .nav .logo h1 {
      color: #00ff00;
      font-size: 2rem;
    }

    .nav .nav-list {
      display: flex;
      gap: 20px;
      list-style: none;
    }

    .nav .nav-item a {
      color: white;
      text-decoration: none;
      font-size: 1.2rem;
      padding: 10px 15px;
      transition: color 0.3s ease, background 0.3s ease;
    }

    .nav .nav-item a:hover {
      color: black;
      background: #00ff00;
      border-radius: 5px;
    }

    .nav .cart-icon {
      color: white;
      font-size: 1.5rem;
      text-decoration: none;
    }

    /* Product Details Section */
    .product-detail {
      margin-top: 120px;
      padding: 20px;
      display: flex;
      gap: 20px;
      align-items: flex-start;
    }

    .product-detail .left img {
      width: 450px;
      border-radius: 10px;
      box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.5);
    }

    .product-detail .right h1 {
      color: #00ff00;
      font-size: 2.2rem;
      margin-bottom: 10px;
    }

    .product-detail .right h2 {
      color: #cccccc;
      font-size: 1.5rem;
      margin-bottom: 10px;
    }

    .product-detail .right .price {
      color: white;
      font-size: 1.8rem;
      margin-bottom: 20px;
    }

    .addCart {
      display: inline-block;
      background: #00ff00;
      color: #000;
      padding: 12px 25px;
      text-decoration: none;
      border-radius: 5px;
      font-size: 1.2rem;
      font-weight: bold;
      transition: background 0.3s ease;
    }

    .addCart:hover {
      background: #008000;
      color: white;
    }

    /* Related Products Section */
    .featured .top h1 {
      color: #00ff00;
      font-size: 2rem;
    }

    .featured .product-center {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 20px;
      margin-top: 20px;
    }

    .featured .product {
      background: rgba(0, 0, 0, 0.7);
      padding: 15px;
      border-radius: 10px;
      text-align: center;
      color: white;
    }

    .featured .product img {
      max-width: 100%;
      border-radius: 10px;
      margin-bottom: 10px;
    }

    .featured .product h3 {
      color: #00ff00;
      font-size: 1.3rem;
      margin-bottom: 10px;
    }

    .featured .product .price {
      color: white;
      font-size: 1.4rem;
    }

    .featured .product .icons span {
      display: inline-block;
      margin: 5px;
      cursor: pointer;
      color: #00ff00;
      font-size: 1.5rem;
    }

    .featured .product .icons span:hover {
      color: white;
    }
  </style>
</head>

<body>
  <!-- Navigation -->
  <nav class="nav">
    <div class="logo">
      <h1>OBSS</h1>
    </div>
    <?php
    if (isset($_SESSION['uname'])) {
      echo "<span>Welcome, " . $_SESSION['uname'] . "</span>";
    }
    ?>
    <ul class="nav-list">
      <li class="nav-item">
        <a href="product.php?uid=<?php echo $uid; ?>">Home</a>
      </li>
      <li class="nav-item">
        <a href="#about">About</a>
      </li>
      <li class="nav-item">
        <a href="contact1.php">Contact</a>
      </li>
      <li class="nav-item">
        <a href="Wishlist_profile.php">Account</a>
      </li>
      <li class="nav-item">
        <a href="cart.php" class="icon"><i class="bx bx-shopping-bag"></i></a>
      </li>
      <li class="nav-item">
        <a href="logout.php" class="icon"><i class="bx bx-log-out"></i></a>
      </li>
    </ul>
  </nav>

  <!-- Product Details Section -->
  <section class="section product-detail">
    <div class="details container-md">
      <div class="left">
        <?php
        include "dbconn.php";
        $id = $_GET['bookid'];
        $records = mysqli_query($conn, "SELECT * FROM products WHERE bookid ='$id'") or die(mysqli_error($conn));
        while ($data = mysqli_fetch_array($records)) {
          $author = $data['author_name'];
        ?>
          <div class="main">
            <img src="book_image/<?php echo $data['book_image']; ?>" alt="">
          </div>
      </div>
      <div class="right">
        <h1><?php echo $data['book_name']; ?></h1>
        <h2>Author Name: <?php echo $data['author_name']; ?></h2>
        <div class="price">Price: Rs. <?php echo $data['book_price']; ?></div>
        <a href="cartbackend.php?bookid=<?php echo $data['bookid']; ?>&book_price=<?php echo $data['book_price']; ?>&uid=<?php echo $uid; ?>" class="addCart">Add To Cart</a>
        <h3>Product Details</h3>
        <p><?php echo $data['description']; ?></p>
      </div>
    <?php
        }
    ?>
    </div>
  </section>

  <!-- Related Products -->
  <section class="section featured">
    <div class="top container">
      <h1>All Books</h1>
    </div>
    <div class="product-center container">
      <?php
      $relatedRecords = mysqli_query($conn, "SELECT * FROM products WHERE author_name = '$author'");
      while ($related = mysqli_fetch_array($relatedRecords)) {
      ?>
        <div class="product">
          <img src="book_image/<?php echo $related['book_image']; ?>" alt="">
          <h3><?php echo $related['book_name']; ?></h3>
          <div class="price">Rs. <?php echo $related['book_price']; ?></div>
        </div>
      <?php
      }
      ?>
    </div>
  </section>
</body>

</html>
