<?php
include "C:/xampp/htdocs/obss/dbconn.php";
$uid = $_GET['uid'];
$amount = $_GET['amount'];

// Payment processing for credit card (simplified)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Insert payment record in payment table
    $pay_id = uniqid(); // You can use a unique ID here
    $pay_status = 'Completed'; // Assuming success
    $name = $_POST['cardname']; // Get the cardholder name from the form

    // Prepare the statement to insert into the payment table
    $stmt = $conn->prepare("INSERT INTO payment (name, amount, pay_id, pay_status, uid) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssi", $name, $amount, $pay_id, $pay_status, $uid);
    $stmt->execute();

    // Insert order details in orders table
    $order_stmt = $conn->prepare("INSERT INTO orders (name, amount, pay_id, pay_status, uid) VALUES (?, ?, ?, ?, ?)");
    $order_stmt->bind_param("ssssi", $name, $amount, $pay_id, $pay_status, $uid);
    $order_stmt->execute();

    // Redirect to success page
    header("Location: success.php?uid=$uid&pay_id=$pay_id&status=$pay_status&amount=$amount");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Credit Card Payment</title>
    <style>
        /* General Styles */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: #ffffff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            width: 400px;
            padding: 30px;
            margin: 20px;
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        label {
            font-size: 14px;
            color: #555;
            margin-bottom: 6px;
            display: block;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            color: #555;
            outline: none;
            box-sizing: border-box;
        }

        input[type="text"]:focus {
            border-color: #6c63ff;
            box-shadow: 0 0 5px rgba(108, 99, 255, 0.5);
        }

        input[type="submit"] {
            background-color: #6c63ff;
            color: white;
            border: none;
            padding: 12px;
            width: 100%;
            font-size: 16px;
            cursor: pointer;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #5a54d8;
        }

        /* Responsive Design */
        @media (max-width: 480px) {
            .container {
                width: 90%;
                padding: 20px;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Credit Card Payment</h2>
    <form method="POST">
        <label for="cardname">Name on Card</label>
        <input type="text" id="cardname" name="cardname" required>

        <label for="cardnumber">Credit Card Number</label>
        <input type="text" id="cardnumber" name="cardnumber" required>

        <label for="expmonth">Exp Month</label>
        <input type="text" id="expmonth" name="expmonth" required>

        <label for="expyear">Exp Year</label>
        <input type="text" id="expyear" name="expyear" required>

        <label for="cvv">CVV</label>
        <input type="text" id="cvv" name="cvv" required>

        <input type="submit" value="Pay Now">
    </form>
</div>

</body>
</html>
