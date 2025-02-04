<?php
session_start();

// User must be logged in
if (!isset($_SESSION['uname'])) {
    echo "You are logged out. Please login again.";
    header('location: userlogin.php');
    exit();
}

include "dbconn.php"; // Database connection file

$uid = isset($_GET['uid']) ? $_GET['uid'] : null;
$username = $_SESSION['uname'];

// Handle quantity update or item removal when the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action'])) {
        $book_id = $_POST['book_id'];
        $action = $_POST['action'];

        // Get the current quantity of the item
        $query = "SELECT qty FROM cart WHERE book_id='$book_id' AND userid='$uid'";
        $result = mysqli_query($conn, $query);
        if (!$result) {
            die("Error fetching item: " . mysqli_error($conn));
        }
        $item = mysqli_fetch_assoc($result);

        $new_quantity = $item['qty'];

        if ($action == 'increase') {
            $new_quantity++;
        } elseif ($action == 'decrease' && $new_quantity > 1) {
            $new_quantity--;
        }

        // Update the quantity in the cart
        $update_query = "UPDATE cart SET qty='$new_quantity' WHERE book_id='$book_id' AND userid='$uid'";
        if (!mysqli_query($conn, $update_query)) {
            die("Error updating quantity: " . mysqli_error($conn));
        }
    }

    if (isset($_POST['remove_item'])) {
        $book_id = $_POST['remove_item'];

        // Remove the item from the cart
        $remove_query = "DELETE FROM cart WHERE book_id='$book_id' AND userid='$uid'";
        if (!mysqli_query($conn, $remove_query)) {
            die("Error removing item: " . mysqli_error($conn));
        }
    }

    // Redirect to refresh the page after the action
    header("Location: cart.php?uid=$uid");
    exit();
}

// Fetch the cart items for the user, joining with the product table to get book details
$query = "SELECT c.book_id, c.qty, p.bookid, p.book_name, p.book_price, p.book_image, s.username
          FROM cart c 
          JOIN products p ON c.book_id = p.bookid
          JOIN signup s ON c.userid = s.id 
          WHERE c.userid = '$uid'";
$cartItems = mysqli_query($conn, $query);
if (!$cartItems) {
    die("Error fetching cart items: " . mysqli_error($conn));
}

// Initialize variables
$cartCount = mysqli_num_rows($cartItems);
$totalAmount = 0;

// Calculate total amount
while ($item = mysqli_fetch_array($cartItems)) {
    $itemTotal = $item['qty'] * $item['book_price']; // Price * Quantity
    $totalAmount += $itemTotal; // Add to total amount
}
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

    <title>Cart - OBSS</title>
    <style>
        /* Your existing styles here */
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

        .cart-section {
            padding: 30px;
            max-width: 1200px;
            margin: auto;
        }

        .cart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .cart-header h2 {
            color: #76ff03;
            font-size: 2rem;
        }

        .cart-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background-color: rgba(0, 0, 0, 0.8);
            margin-bottom: 15px;
            padding: 15px;
            border-radius: 10px;
        }

        .cart-item img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 8px;
        }

        .cart-item-info {
            flex: 1;
            margin-left: 20px;
        }

        .cart-item-info h4 {
            color: #fff;
            margin: 0;
        }

        .cart-item-info p {
            margin: 5px 0;
        }

        .cart-item-actions {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .quantity-btn {
            padding: 5px 10px;
            border: 1px solid #76ff03;
            background-color: transparent;
            color: #76ff03;
            font-size: 1rem;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
        }

        .quantity-btn:hover {
            background-color: #76ff03;
            color: #000;
        }

        .remove-btn {
            padding: 8px 15px;
            border: none;
            background-color: red;
            color: white;
            font-size: 1rem;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
        }

        .remove-btn:hover {
            background-color: darkred;
        }

        .checkout-btn {
            padding: 10px 20px;
            background-color: #76ff03;
            color: #000;
            font-size: 1.2rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
            text-align: center;
            margin: auto;
            display: block;
        }

        .checkout-btn:hover {
            background-color: #5cb85c;
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
        <div>
            <?php
            if (isset($_SESSION['uname'])) {
                echo "<span>Welcome, {$_SESSION['uname']}</span>";
            }
            ?>
        </div>
        <div class="menu">
            <ul class="nav-list">
                <li class="nav-item"><a href="product.php?uid=<?php echo $uid; ?>" class="nav-link">Home</a></li>
                <li class="nav-item"><a href="#about" class="nav-link">About</a></li>
                <li class="nav-item"><a href="contact1.php" class="nav-link">Contact</a></li>
                <li class="nav-item"><a href="Wishlist_profile.php?uid=<?php echo $uid; ?>" class="nav-link">Account</a></li>
                <li class="nav-item"><a href="logout.php" class="nav-link icon"><i class="bx bx-log-out"></i></a></li>
            </ul>
        </div>
    </nav>

    <!-- Cart Section -->
    <section class="cart-section">
        <div class="cart-header">
            <h2>Your Cart</h2>
            <p>Total Items: <?php echo $cartCount; ?></p>
            <h3>Total Amount: Rs. <?php echo $totalAmount; ?></h3>
        </div>

        <?php if ($cartCount > 0) : ?>
            <?php
            mysqli_data_seek($cartItems, 0); // Reset the pointer to fetch items again
            while ($item = mysqli_fetch_array($cartItems)) : ?>
                <div class="cart-item">
                    <img src="book_image/<?php echo isset($item['book_image']) ? $item['book_image'] : 'default.jpg'; ?>" alt="Book Image">
                    <div class="cart-item-info">
                        <h4><?php echo isset($item['book_name']) ? $item['book_name'] : 'Unknown Book'; ?></h4>
                        <p>Price: Rs. <?php echo isset($item['book_price']) ? $item['book_price'] : 'N/A'; ?></p>
                    </div>
                    <div class="cart-item-actions">
                        <form method="post" style="display:inline;">
                            <input type="hidden" name="book_id" value="<?php echo $item['book_id']; ?>">
                            <button type="submit" class="quantity-btn" name="action" value="decrease">-</button>
                            <span><?php echo isset($item['qty']) ? $item['qty'] : '1'; ?></span>
                            <button type="submit" class="quantity-btn" name="action" value="increase">+</button>
                        </form>

                        <form method="post" style="display:inline;">
                            <input type="hidden" name="remove_item" value="<?php echo $item['book_id']; ?>">
                            <button type="submit" class="remove-btn">Remove</button>
                        </form>
                    </div>
                </div>
            <?php endwhile; ?>
            <button class="checkout-btn" 
                onclick="window.location.href='razorpay/checkout.php?uid=<?php echo $uid; ?>&total=<?php echo $totalAmount; ?>'">
                Proceed to Checkout
            </button>
        <?php else : ?>
            <h4>No items in your cart</h4>
        <?php endif; ?>
    </section>
</body>
</html>
