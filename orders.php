<?php
session_start();
$uid = $_GET['uid'];
include "dbconn.php"; // Using database connection file here
?>

<?php
if (!isset($_SESSION['uname'])) {
    echo "You are logged out. Please login again.";
    header('location: userlogin.php');
    exit(); // Make sure the script stops after the header redirect
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Wishlist Profile</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

<div class="container padding-bottom-3x mb-2">
    <div class="row">
        <div class="col-lg-4">
            <aside class="user-info-wrapper">
                <div class="user-cover" style="background-image: url(https://bootdey.com/img/Content/bg1.jpg);">
                    <div class="info-label" data-toggle="tooltip" title="" data-original-title="You currently have 290 Reward Points to spend"><i class="icon-medal"></i>290 points</div>
                </div>
                <div class="user-info">
                    <div class="user-avatar">
                        <a class="edit-avatar" href="imageupdate.php"></a><img src="user_images/<?php echo $_SESSION['image']; ?>" alt="User">
                    </div>
                    <div class="user-data">
                        <h4>
                        <?php
                            if (isset($_SESSION['uname'])) {
                                echo $_SESSION['uname'];
                            }
                        ?>
                        </h4><span>Joined February 06, 2017</span>
                    </div>
                </div>
            </aside>
            <nav class="list-group">
                <a class="list-group-item with-badge active" href=""><i class=" fa fa-th"></i>Orders<span class="badge badge-primary badge-pill">
                    <?php
                    $cartnum = mysqli_query($conn, "SELECT * FROM orders WHERE uid='$uid'");
                    $cartnumdata = mysqli_num_rows($cartnum);
                    echo $cartnumdata;
                    ?>
                </span></a>
                <a class="list-group-item" href="account.php"><i class="fa fa-user"></i>Profile</a>
                <a class="list-group-item with-badge" href="Wishlist_profile.php?uid=<?php echo $uid ?>"><i class="fa fa-heart"></i>Wishlist<span class="badge badge-primary badge-pill">3</span></a>
            </nav>
        </div>

        <div class="col-lg-8">
            <div class="padding-top-2x mt-2 hidden-lg-up"></div>
            <!-- Wishlist Table-->
            <div class="table-responsive wishlist-table margin-bottom-none">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Product Name</th>
                        </tr>
                    </thead>
                    <tbody>

                    <?php 
                    // Fetch orders for the specific user using the 'orders' table
                    $records = mysqli_query($conn, "SELECT orders.*, products.* FROM orders INNER JOIN products ON orders.book_id = products.bookid WHERE orders.uid='$uid'");

                    while ($data = mysqli_fetch_array($records)) {
                        $price = $data['qty'] * $data['book_price'];
                    ?>
                        <tr>
                            <td>
                                <div class="product-item">
                                    <a class="product-thumb" href="http://localhost/obss/product-details.php?bookid=<?php echo $data['bookid']?>&uid=<?php echo $uid ?>"><img src="book_image/<?php echo $data['book_image']; ?>" alt="Product"></a>
                                    <div class="product-info">
                                        <h4 class="product-title"><a href="http://localhost/obss/product-details.php?bookid=<?php echo $data['bookid']?>&uid=<?php echo $uid ?>"><?php echo $data['book_name']; ?></a></h4>
                                        <div class="text-lg text-medium text-muted">₹<?php echo $data['book_price'] ?></div>
                                        <div>Quantity:
                                            <div class="d-inline text-success"><?php echo $data['qty'] ?></div>
                                        </div>
                                        <div>Paid:
                                            <div class="d-inline text-primary"><?php echo $price?></div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center"><a class="remove-from-cart" href="#" data-toggle="tooltip" title="Remove item"><i class="icon-cross"></i></a></td>
                        </tr>
                    <?php
                    }
                    ?>
                        
                    </tbody>
                </table>
            </div>
            <hr class="mb-4">
        </div>
    </div>
</div>

<style type="text/css">
body{margin-top:20px;}

.user-info-wrapper {
    position: relative;
    width: 100%;
    margin-bottom: -1px;
    padding-top: 90px;
    padding-bottom: 30px;
    border: 1px solid #e1e7ec;
    border-top-left-radius: 7px;
    border-top-right-radius: 7px;
    overflow: hidden
}

.user-info-wrapper .user-cover {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 120px;
    background-position: center;
    background-color: #f5f5f5;
    background-repeat: no-repeat;
    background-size: cover
}

.user-info-wrapper .user-cover .tooltip .tooltip-inner {
    width: 230px;
    max-width: 100%;
    padding: 10px 15px
}

.user-info-wrapper .info-label {
    display: block;
    position: absolute;
    top: 18px;
    right: 18px;
    height: 26px;
    padding: 0 12px;
    border-radius: 13px;
    background-color: #fff;
    color: #606975;
    font-size: 12px;
    line-height: 26px;
    box-shadow: 0 1px 5px 0 rgba(0, 0, 0, 0.18);
    cursor: pointer
}

.user-info-wrapper .info-label>i {
    display: inline-block;
    margin-right: 3px;
    font-size: 1.2em;
    vertical-align: middle
}

.user-info-wrapper .user-info {
    display: table;
    position: relative;
    width: 100%;
    padding: 0 18px;
    z-index: 5
}

.user-info-wrapper .user-info .user-avatar,
.user-info-wrapper .user-info .user-data {
    display: table-cell;
    vertical-align: top
}

.user-info-wrapper .user-info .user-avatar {
    position: relative;
    width: 115px
}

.user-info-wrapper .user-info .user-avatar>img {
    display: block;
    width: 100%;
    border: 5px solid #fff;
    border-radius: 50%
}

.user-info-wrapper .user-info .user-avatar .edit-avatar {
    display: block;
    position: absolute;
    top: -2px;
    right: 2px;
    width: 36px;
    height: 36px;
    transition: opacity .3s;
    border-radius: 50%;
    background-color: #fff;
    color: #606975;
    line-height: 34px;
    box-shadow: 0 1px 5px 0 rgba(0, 0, 0, 0.2);
    cursor: pointer;
    opacity: 0;
    text-align: center;
    text-decoration: none
}

.user-info-wrapper .user-info .user-avatar .edit-avatar::before {
    font-family: feather;
    font-size: 17px;
    content: '\e058'
}

.user-info-wrapper .user-info .user-avatar:hover .edit-avatar {
    opacity: 1
}

.user-info-wrapper .user-info .user-data {
    padding-top: 48px;
    padding-left: 12px
}

.user-info-wrapper .user-info .user-data h4 {
    margin-bottom: 2px
}

.user-info-wrapper .user-info .user-data span {
    display: block;
    color: #9da9b9;
    font-size: 13px
}

.user-info-wrapper+.list-group .list-group-item:first-child {
    border-radius: 0
}

.user-info-wrapper+.list-group .list-group-item:first-child {
    border-radius: 0;
}
.list-group-item:first-child {
    border-top-left-radius: 7px;
    border-top-right-radius: 7px;
}
.list-group-item:first-child {
    border-top-left-radius: .25rem;
    border-top-right-radius: .25rem;
}

</style>

<script type="text/javascript">
    // You can add custom JS here if needed
</script>
</body>
</html>
