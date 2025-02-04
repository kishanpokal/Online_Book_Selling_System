<?php
session_start();
include "dbconn.php"; // Using database connection file here

// Initialize variables for profit calculation
$profit = 0;
$num = mysqli_query($conn, "SELECT * FROM `orders` WHERE MONTH(`date_added`) = MONTH(CURRENT_DATE()) AND YEAR(`date_added`) = YEAR(CURRENT_DATE());");
$num2 = mysqli_query($conn, "SELECT * FROM `orders`");
$numdata = mysqli_num_rows($num);
if ($numdata == 0) {
    $bnum = 0;
} else {
    $bnum = $numdata;
    while ($res = mysqli_fetch_array($num2)) {
        $amt = $res['amount'];
        $profit = $profit + $amt;
    }
}

// Check if the admin is logged in
if (!isset($_SESSION['name'])) {
    echo "You are logged out. Login again.";
    header('location: adminlogin.php');
    exit;
}

// Fetch orders with associated product data
$aid = $_GET['aid'];
$records = mysqli_query($conn, "
    SELECT orders.*, products.book_name, products.book_price, products.book_image 
    FROM orders
    JOIN products ON orders.book_id = products.bookid
");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OBSS Admin</title>
    <link rel="shortcut icon" href="/images/logo-mb.png" type="image/png">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">
    <!-- BoxIcons -->
    <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="./css/grid.css">
    <link rel="stylesheet" href="./css/app.css">
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-logo">
            <img src="./images/logo-lg.png" alt="Company logo">
            <div class="sidebar-close" id="sidebar-close">
                <i class="bx bx-left-arrow-alt"></i>
            </div>
        </div>
        <div class="sidebar-user">
            <div class="sidebar-user-info">
                <img src="images/abhijith.jpg" alt="User picture" class="profile-image">
                <div class="sidebar-user-name">
                    <?php echo $_SESSION['name']; ?>
                </div>
            </div>
            <a href="adminlogout.php">
                <button class="btn btn-outline">
                    <i class="bx bx-log-out bx-flip-horizontal"></i>
                </button>
            </a>
        </div>
        <ul class="sidebar-menu">
            <li><a href="admin-panel.php?aid=<?php echo $aid ?>"><i class="bx bx-home"></i><span>Dashboard</span></a></li>
            <li><a href="total_sales.php?aid=<?php echo $aid ?>"><i class="bx bx-shopping-bag"></i><span>Sales</span></a></li>
            <li><a href="total_order.php?aid=<?php echo $aid ?>" class="active"><i class="bx bx-chart"></i><span>Analytic</span></a></li>
            <li><a href="total_users.php?aid=<?php echo $aid ?>"><i class="bx bx-user-circle"></i><span>Users</span></a></li>
            <li><a href="list.php?aid=<?php echo $aid ?>"><i class="bx bx-category"></i><span>Products</span></a></li>
            <li><a href="user_added_books.php?aid=<?php echo $aid ?>"><i class="bx bx-check-double"></i><span>Allow Products</span></a></li>
            <li><a href="#"><i class="bx bx-cog"></i><span>Settings</span></a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main">
        <div class="main-header">
            <div class="mobile-toggle" id="mobile-toggle">
                <i class="bx bx-menu-alt-right"></i>
            </div>
            <div class="main-title">
                Total Orders
            </div>
        </div>

        <div class="main-content">
            <div class="row">
                <div class="col-12">
                    <!-- Orders Table -->
                    <div class="box">
                        <div class="box-header">
                            Recent Orders
                        </div>
                        <div class="box-body overflow-scroll">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Book ID</th>
                                        <th>Book Name</th>
                                        <th>User ID</th>
                                        <th>Date</th>
                                        <th>Order Status</th>
                                        <th>Payment Status</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Total Paid</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                while ($data = mysqli_fetch_array($records)) {
                                    $price = $data['book_price'] * $data['book_qty'];
                                ?>
                                    <tr>
                                        <td><?php echo $data['book_id'] ?></td>
                                        <td>
                                            <div class="order-owner">
                                                <img src="book_image/<?php echo $data['book_image']; ?>" alt="Book Image">
                                                <span><?php echo $data['book_name']; ?></span>
                                            </div>
                                        </td>
                                        <td><?php echo $data['uid'] ?></td>
                                        <td><?php echo $data['date_added'] ?></td>
                                        <td><span class="order-status order-ready">SUCCESS</span></td>
                                        <td><div class="payment-status payment-paid"><div class="dot"></div><span>SUCCESS</span></div></td>
                                        <td>₹ <?php echo $data['book_price'] ?></td>
                                        <td><?php echo $data['book_qty'] ?> .Pcs</td>
                                        <td>₹ <?php echo $price ?></td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- END Orders Table -->
                </div>
            </div>
        </div>
    </div>
    <!-- END Main Content -->

    <div class="overlay"></div>

    <!-- Script -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="javascript/app.js"></script>

</body>
</html>
