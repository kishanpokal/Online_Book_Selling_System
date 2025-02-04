<?php
// Include database connection
include "C:/xampp/htdocs/obss/dbconn.php";

// Fetch the GET parameters with validation
$uid = isset($_GET['uid']) ? intval($_GET['uid']) : 0; // Ensure uid is an integer
$name = isset($_GET['name']) ? mysqli_real_escape_string($conn, $_GET['name']) : ''; // Escape to prevent SQL injection
$email = isset($_GET['email']) ? mysqli_real_escape_string($conn, $_GET['email']) : '';
$mobile = isset($_GET['mobile']) ? mysqli_real_escape_string($conn, $_GET['mobile']) : '';
$amount = isset($_GET['amount']) ? floatval($_GET['amount']) : 0; // Ensure amount is a float
$status = isset($_GET['status']) ? mysqli_real_escape_string($conn, $_GET['status']) : '';
$payment_id = isset($_GET['payment_id']) ? mysqli_real_escape_string($conn, $_GET['payment_id']) : '';

$order_message = "Thanks for using our website for book buying.";

// Debugging: Uncomment the following lines only for debugging and remove them afterward
// echo '<pre>';
// print_r($_GET);
// echo '</pre>';

// Insert order details into the database if status is success
if ($uid && $status === 'success') {
    // Prepare SQL query to avoid SQL injection
    $query = $conn->prepare("INSERT INTO `orders` (`name`, `email`, `mobile`, `amount`, `pay_id`, `pay_status`, `uid`) 
                             VALUES (?, ?, ?, ?, ?, ?, ?)");
    $query->bind_param("sssdsis", $name, $email, $mobile, $amount, $payment_id, $status, $uid);

    // Execute the query
    if ($query->execute()) {
        $order_message = "Your order has been placed successfully!";
    } else {
        $order_message = "There was an issue with your order. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Payment Success</title>
    <link href='https://fonts.googleapis.com/css?family=Lato:300,400|Montserrat:700' rel='stylesheet' type='text/css'>
    <style>
        @import url(//cdnjs.cloudflare.com/ajax/libs/normalize/3.0.1/normalize.min.css);
        @import url(//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css);
    </style>
    <link rel="stylesheet" href="https://2-22-4-dot-lead-pages.appspot.com/static/lp918/min/default_thank_you.css">
    <script src="https://2-22-4-dot-lead-pages.appspot.com/static/lp918/min/jquery-1.9.1.min.js"></script>
    <script src="https://2-22-4-dot-lead-pages.appspot.com/static/lp918/min/html5shiv.js"></script>
</head>
<body>

<header class="site-header" id="header">
    <h1 class="site-header__title" data-lead-id="site-header-title">Order Success!</h1>
</header>

<div class="main-content">
    <i class="fa fa-check main-content__checkmark" id="checkmark"></i>
    <p class="main-content__body" data-lead-id="main-content-body">
        <?php echo $order_message; ?>
    </p>
    <p>Order Details:</p>
    <ul>
        <li><strong>Name:</strong> <?php echo htmlspecialchars($name); ?></li>
        <li><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></li>
        <li><strong>Mobile:</strong> <?php echo htmlspecialchars($mobile); ?></li>
        <li><strong>Amount:</strong> ₹<?php echo htmlspecialchars($amount); ?></li>
        <li><strong>Payment Status:</strong> <?php echo htmlspecialchars($status); ?></li>
        <li><strong>Payment ID:</strong> <?php echo htmlspecialchars($payment_id); ?></li>
    </ul>
</div>

<p>You will be redirected in <span id="counter">5</span> second(s).</p>
<script type="text/javascript">
function countdown() {
    var i = document.getElementById('counter');
    if (parseInt(i.innerHTML) <= 0) {
        location.href = 'http://localhost/obss/product.php?uid=<?php echo htmlspecialchars($uid); ?>';
    }
    if (parseInt(i.innerHTML) != 0) {
        i.innerHTML = parseInt(i.innerHTML) - 1;
    }
}
setInterval(function() { countdown(); }, 1000);
</script>

</body>
</html>
