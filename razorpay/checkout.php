<?php
include "C:/xampp/htdocs/obss/dbconn.php";

// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Check if 'uid' is passed in the URL
if (!isset($_GET['uid'])) {
    die("Error: Missing 'uid' parameter in URL.");
}

$uid = $_GET['uid'];

// Validate that the user ID is a valid integer
if (!is_numeric($uid)) {
    die("Error: Invalid user ID.");
}

// Fetch the total amount from URL parameters, default to 0 if not set
$Amount = isset($_GET['total']) && is_numeric($_GET['total']) ? (int)$_GET['total'] : 0;

// Validate the amount
if ($Amount <= 0) {
    die("Error: Invalid amount. Please provide a valid total.");
}

// Fetch the user details from the database using 'uid'
$hidname = mysqli_query($conn, "SELECT * FROM signup WHERE id='$uid'");
$hidusernameout = mysqli_fetch_assoc($hidname);

if ($hidusernameout) {
    // Successfully fetched user data
    $u_hidname = $hidusernameout['firstname'];
    $u_hidemail = $hidusernameout['email'];
    $u_hidnumber = $hidusernameout['phone'];
} else {
    // User not found, handle error
    die("Error: User not found!");
}

// Handle COD payment (Cash on Delivery)
if (isset($_GET['payment_method']) && $_GET['payment_method'] === 'COD') {
    // Generate a unique pay_id for COD
    $pay_id = 'COD_' . uniqid();

    // Insert payment details into the database with status "pending"
    $insertPaymentQuery = "INSERT INTO payment (name, amount, pay_id, pay_status, uid) 
                           VALUES ('$u_hidname', '$Amount', '$pay_id', 'pending', '$uid')";

    if (mysqli_query($conn, $insertPaymentQuery)) {
        // Insert order details into the orders table
        $insertOrderQuery = "INSERT INTO orders (name, amount, pay_id, pay_status, uid) 
                             VALUES ('$u_hidname', '$Amount', '$pay_id', 'pending', '$uid')";

        if (mysqli_query($conn, $insertOrderQuery)) {
            // Redirect to the success page
            header("Location: success.php?status=pending&amount=$Amount&uid=$uid&pay_id=$pay_id");
            exit;
        } else {
            echo "Error in order insertion: " . mysqli_error($conn);
        }
    } else {
        echo "Error in payment insertion: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <style>
        body {
            font-family: Arial;
            font-size: 17px;
            padding: 8px;
        }
        .container {
            background-color: #f2f2f2;
            padding: 20px;
            border: 1px solid lightgrey;
            border-radius: 3px;
        }
        input[type=text] {
            width: 100%;
            margin-bottom: 20px;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }
        label {
            margin-bottom: 10px;
            display: block;
        }
        .btn, .payment-btn {
            background-color: #4CAF50;
            color: white;
            padding: 12px;
            border: none;
            width: 100%;
            border-radius: 3px;
            cursor: pointer;
            font-size: 17px;
            margin-bottom: 10px;
        }
        .btn:hover, .payment-btn:hover {
            background-color: #45a049;
        }
        .option-container {
            display: flex;
            justify-content: space-around;
            margin-top: 20px;
        }
        .option-container button {
            width: 45%;
        }
    </style>
</head>
<body>
<div class="container">
    <form>
        <h3 style="text-align: center;">Checkout Form</h3>
        <label for="fname"><i class="fa fa-user"></i> Full Name</label>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($u_hidname); ?>" readonly>
        <label for="email"><i class="fa fa-envelope"></i> Email</label>
        <input type="text" id="email" name="email" value="<?php echo htmlspecialchars($u_hidemail); ?>" readonly>
        <label for="mobile"><i class="fa fa-mobile"></i> Mobile</label>
        <input type="text" id="mobile" name="mobile" value="<?php echo htmlspecialchars($u_hidnumber); ?>" readonly>
        <input type="hidden" id="amount" value="<?php echo htmlspecialchars($Amount); ?>">

        <div class="option-container">
            <button type="button" class="payment-btn" 
                    onclick="window.location.href='credit_card_payment.php?uid=<?php echo htmlspecialchars($uid); ?>&amount=<?php echo htmlspecialchars($Amount); ?>'">
                Pay via Credit Card
            </button>
            <button type="button" class="payment-btn" onclick="COD()">Cash on Delivery</button>
        </div>
    </form>
</div>

<script>
    function COD() {
        const name = document.getElementById("name").value;
        const email = document.getElementById("email").value;
        const mobile = document.getElementById("mobile").value;
        const amount = document.getElementById("amount").value;
        const uid = <?php echo json_encode($uid); ?>;

        console.log(`UID: ${uid}, Amount: ${amount}`);  // Debugging output

        if (!uid) {
            alert('User ID is missing.');
            return;
        }

        if (!amount || isNaN(amount) || parseFloat(amount) <= 0) {
            alert('Invalid amount. Please check your input.');
            return;
        }

        // Redirect to checkout with parameters
        window.location.href = `checkout.php?uid=${encodeURIComponent(uid)}&payment_method=COD&total=${encodeURIComponent(amount)}`;
    }
</script>
</body>
</html>