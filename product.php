<?php
session_start();
if (!isset($_SESSION['uname'])) {
    echo "You are logged out. Please login again.";
    header('location: userlogin.php');
    exit();
}
include "dbconn.php"; // Using database connection file here

$uid = isset($_GET['uid']) ? $_GET['uid'] : null;
$search = isset($_GET['search']) ? $_GET['search'] : '';
$sort = isset($_GET['sort']) ? $_GET['sort'] : '';

$query = "SELECT * FROM products";
if ($search) {
    $query .= " WHERE book_name LIKE '%$search%' OR author_name LIKE '%$search%'";
}
if ($sort == 'name') {
    $query .= " ORDER BY book_name ASC";
} elseif ($sort == 'price') {
    $query .= " ORDER BY book_price ASC";
}

$records = mysqli_query($conn, $query);
$val = mysqli_num_rows($records);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="./images/favicon.ico" type="image/x-icon">

    <!-- Font Awesome -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/39380151d6.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css" />

    <title>OBSS</title>
    <style>
        /* CSS content remains unchanged */
        /* Copy all the CSS styles from your original code here */
        body {
            background-image: url('images/background2.jpg');
            background-attachment: fixed;
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            color: white;
            margin: 0;
            font-family: 'Lato', sans-serif;
        }

        .nav {
            background-color: rgba(0, 0, 0, 0.9);
            padding: 15px 20px;
            position: sticky;
            top: 0;
            z-index: 100;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .nav .logo h1 {
            color: #76ff03;
            font-size: 2.5rem;
            margin: 0;
        }

        .nav .nav-list {
            list-style-type: none;
            display: flex;
            margin: 0;
            padding: 0;
        }

        .nav .nav-item {
            margin-left: 20px;
        }

        .nav .nav-link {
            color: #fff;
            text-decoration: none;
            font-size: 1.2rem;
            padding: 10px 20px;
            transition: background-color 0.3s;
            border-radius: 5px;
        }

        .nav .nav-link:hover {
            background-color: #575757;
        }

        .search-container {
            display: flex;
            align-items: center;
            padding: 5px 15px;
            border-radius: 30px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .search-input {
            border: none;
            outline: none;
            font-size: 1rem;
            width: 200px;
        }

        .search-btn .fas {
            color: #5cbdbb;
            margin-left: 10px;
            cursor: pointer;
        }

        .sort-container {
            margin: 10px 0;
            text-align: right;
            color: white;
        }

        .sort-container select {
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
        }

        .all-products {
            padding: 20px;
        }

        .all-products .container {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            padding: 20px;
        }

        .product {
            background-color: rgba(0, 0, 0, 0.8);
            border-radius: 8px;
            padding: 15px;
            text-align: center;
            transition: transform 0.3s;
        }

        .product:hover {
            transform: scale(1.05);
        }

        .product img {
            max-width: 100%;
            height: 250px;
            object-fit: cover;
            border-radius: 8px;
        }

        .product h4 {
            color: #76ff03;
            font-size: 1.2rem;
            margin: 10px 0;
            word-wrap: break-word;
            white-space: normal;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .product p {
            color: #fff;
            font-size: 1rem;
            margin: 5px 0;
        }

        .product-icons {
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        .product-icons a {
            color: #fff;
            font-size: 1.5rem;
            transition: color 0.3s;
        }

        .product-icons a:hover {
            color: #76ff03;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="nav">
        <div class="logo">
            <h1>OBSS</h1>
        </div>
        <div>
            <?php
            if (isset($_SESSION['uname'])) {
                echo "<span>Welcome, {$_SESSION['uname']}</span>";
            }
            ?>
        </div>
        <div class="menu">
            <ul class="nav-list">
                <li class="nav-item">
                    <a href="product.php?uid=<?php echo $uid; ?>" class="nav-link">Home</a>
                </li>
                <li class="nav-item">
                    <form action="" method="GET" style="display: inline;">
                        <div class="search-container">
                            <input type="text" name="search" placeholder="Search by book or author..." class="search-input" pattern="[a-zA-Z0-9\s]+">
                            <input type="hidden" name="uid" value="<?php echo $uid; ?>">
                            <button type="submit" class="search-btn" name="searchb"><i class="fas fa-search"></i></button>
                        </div>
                    </form>
                </li>
                <li class="nav-item">
                    <a href="#about" class="nav-link">About</a>
                </li>
                <li class="nav-item">
                    <a href="contact1.php" class="nav-link">Contact</a>
                </li>
                <li class="nav-item">
                    <a href="Wishlist_profile.php?uid=<?php echo $uid; ?>" class="nav-link">Account</a>
                </li>
                <li class="nav-item">
                    <a href="sell_books.php?uid=<?php echo $uid; ?>" class="nav-link">Sell Books</a>
                </li>
                <li class="nav-item">
                    <a href="cart.php?uid=<?php echo $uid; ?>" class="nav-link icon">
                        <i class="bx bx-shopping-bag"></i>
                        <span class="cart-basket">
                            <?php
                            $cartnum = mysqli_query($conn, "SELECT * FROM cart WHERE userid='$uid'");
                            echo mysqli_num_rows($cartnum);
                            ?>
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="logout.php" class="nav-link icon"><i class="bx bx-log-out"></i></a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Sorting -->
    <div class="sort-container">
        <form action="" method="GET">
            <input type="hidden" name="uid" value="<?php echo $uid; ?>">
            <input type="hidden" name="search" value="<?php echo $search; ?>">
            <label for="sort">Sort by:</label>
            <select name="sort" id="sort" onchange="this.form.submit()">
                <option value="">Default</option>
                <option value="name" <?php if ($sort == 'name') echo 'selected'; ?>>Name</option>
                <option value="price" <?php if ($sort == 'price') echo 'selected'; ?>>Price</option>
            </select>
        </form>
    </div>

    <!-- All Products -->
    <section class="all-products" id="products">
        <div class="container">
            <?php
            if ($val > 0) {
                while ($data = mysqli_fetch_array($records)) {
            ?>
                <div class="product">
                    <img src="book_image/<?php echo $data['book_image']; ?>" alt="">
                    <h4><?php echo $data['book_name']; ?></h4>
                    <p>Author: <?php echo $data['author_name']; ?></p>
                    <p>Rs. <?php echo $data['book_price']; ?></p>
                    <div class="product-icons">
                        <a href="wish_list_backend.php?bookid=<?php echo $data['bookid']; ?>&book_price=<?php echo $data['book_price']; ?>&uid=<?php echo $uid; ?>"><i class="bx bx-heart"></i></a>
                        <a href="cartbackend.php?bookid=<?php echo $data['bookid']; ?>&book_price=<?php echo $data['book_price']; ?>&uid=<?php echo $uid; ?>"><i class="bx bx-shopping-bag"></i></a>
                        <a href="product-details.php?bookid=<?php echo $data['bookid']; ?>&uid=<?php echo $uid; ?>"><i class="bx bx-search"></i></a>
                    </div>
                </div>
            <?php
                }
            } else {
                echo "<h4>Sorry, no books available</h4>";
            }
            ?>
        </div>
    </section>
</body>
</html>