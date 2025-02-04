<?php
session_start();

?>

<?php
if (!isset($_SESSION['name'])) {
    header('Location: adminlogin.php');
    exit; // Stop execution after redirection
}

if (isset($_GET['aid'])) {
    $aid = $_GET['aid'];
} 
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OBSS Admin</title>

    <link rel="shortcut icon" href="/images/logo-mb.png" type="image/png">
    <!-- GOOGLE FONT -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900&display=swap" rel="stylesheet">
    <!-- BOXICONS -->
    <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet">

    <!-- APP CSS -->
    <link rel="stylesheet" href="./css/grid.css">
    <link rel="stylesheet" href="./css/app.css">

    <link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
</head>

<body>

    <!-- SIDEBAR -->
    <div class="sidebar">
        <div class="sidebar-logo">
            <img src="./images/logo-lg.png" alt="Company logo">
            <div class="sidebar-close" id="sidebar-close">
                <i class="bx bx-left-arrow-alt"></i>
            </div>
        </div>
        <div class="sidebar-user">
            <div class="sidebar-user-info">
                <img src="images\abhijith.jpg" alt="User picture" class="profile-image">
                <div class="sidebar-user-name">
                <?php
                    if (isset($_SESSION['name'])) {
                        echo $_SESSION['name'];
                    }
                ?>
                </div>
            </div>
            <a href="adminlogout.php">
                <button class="btn btn-outline">
                    <i class="bx bx-log-out bx-flip-horizontal"></i>
                </button>
            </a>
        </div>
        <!-- SIDEBAR MENU -->
        <ul class="sidebar-menu">
            <li>
                <a href="admin-panel.php?aid=<?php echo $aid ?>">
                    <i class="bx bx-home"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="total_sales.php?aid=<?php echo $aid ?>">
                    <i class="bx bx-shopping-bag"></i>
                    <span>Sales</span>
                </a>
            </li>
            <li>
                <a href="total_users.php?aid=<?php echo $aid ?>">
                    <i class="bx bx-user-circle"></i>
                    <span>Users</span>
                </a>
            </li>
            <li class="sidebar-submenu active">
                <a href="#" class="sidebar-menu-dropdown">
                    <i class="bx bx-category"></i>
                    <span>E-commerce</span>
                    <div class="dropdown-icon"></div>
                </a>
                <ul class="sidebar-menu sidebar-menu-dropdown-content">
                    <li>
                        <a href="list.php?aid=<?php echo $aid ?>">
                            List Product
                        </a>
                    </li>
                    <li>
                        <a href="add_product.php?aid=<?php echo $aid ?>" class="active">
                            Add Product
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="user_added_books.php?aid=<?php echo $aid ?>">
                    <i class="bx bx-check-double"></i>
                    <span>Allow Products</span>
                </a>
            </li>
            <li class="sidebar-submenu">
                <a href="#" class="sidebar-menu-dropdown">
                    <i class="bx bx-cog"></i>
                    <span>Settings</span>
                    <div class="dropdown-icon"></div>
                </a>
                <ul class="sidebar-menu sidebar-menu-dropdown-content">
                    <li>
                        <a href="#" class="darkmode-toggle" id="darkmode-toggle">
                            Darkmode
                            <span class="darkmode-switch"></span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
        <!-- END SIDEBAR MENU -->
    </div>
    <!-- END SIDEBAR -->

    <!-- MAIN CONTENT -->
    <div class="main">
        <div class="main-content">
            <form action="http://localhost/obss/add_product_code.php?aid=<?php echo $aid ?>" method="POST" enctype="multipart/form-data" class="form-horizontal">
                <fieldset>
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="product_name">BOOK NAME</label>  
                        <div class="col-md-4">
                            <input id="product_name" name="product_name" placeholder="PRODUCT NAME" class="form-control input-md" required type="text">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="product_categorie">PRODUCT CATEGORY</label>
                        <div class="col-md-4">
                            <label for="genre">Choose a genre:</label>
                            <select required name="genre" id="genre" class="form-control">
                                <option value="Action and adventure">Action and adventure</option>
                                <option value="Art/architecture">Art/architecture</option>
                                <option value="Alternate history">Alternate history</option>
                                <option value="Autobiography">Autobiography</option>
                                <option value="Anthology">Anthology</option>
                                <option value="Biography">Biography</option>
                                <option value="Business/economics">Business/economics</option>
                                <option value="Children's">Children's</option>
                                <option value="Crafts/hobbies">Crafts/hobbies</option>
                                <option value="Classic">Classic</option>
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
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="available_quantity">AVAILABLE QUANTITY</label>  
                        <div class="col-md-4">
                            <input id="available_quantity" name="available_quantity" placeholder="AVAILABLE QUANTITY" class="form-control input-md" required type="number">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="product_description">PRODUCT DESCRIPTION</label>
                        <div class="col-md-4">                     
                            <textarea required class="form-control" id="product_description" name="product_description"></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="online_date">PRICE</label>  
                        <div class="col-md-4">
                            <input id="online_date" name="price" placeholder="ONLINE PRICE" class="form-control input-md" required type="number">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="author">AUTHOR</label>  
                        <div class="col-md-4">
                            <input id="author" name="author" placeholder="AUTHOR" class="form-control input-md" required type="text">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="filebutton">Book image</label>
                        <div class="col-md-4">
                            <input required id="filebutton" name="bookimage" class="input-file" type="file">
                        </div>
                    </div>

                    <div class="form-group">
                        <center>
                            <button id="singlebutton" name="singlebutton" class="btn btn-primary">ADD</button>
                        </center>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
    <!-- END MAIN CONTENT -->

    <div class="overlay"></div>

    <script src="javascript/app.js"></script>
    <script>
        document.getElementById('singlebutton').addEventListener('click', function(event) {
            event.preventDefault();
            alert('Button clicked! Ensure the backend is correctly handling the form submission.');
            this.closest('form').submit();
        });
    </script>
</body>

</html>