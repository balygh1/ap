<?php 
session_start();
require "../include/db.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WORLD WIDE</title>
    <link rel="stylesheet" href="./style.css">
    <link rel="stylesheet"href="https://unpkg.com/swiper@8/swiper-bundle.min.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
</head>



<body>
    <header>
        <div id="menu-bar" class="fas fa-bars" onclick="showmenu()"></div>
        <a href="" class="logo"><span>W</span>orld<span>W</span>wide</a>
        <nav class="navbar">
            <a href="#home">home</a>
            <a href="#book">book</a>
            <a href="#packages">packages</a>
            <a href="#services">services</a>
            <a href="#gallary">gallary</a>
            <a href="#review">review</a>
            <a href="#contact">contact</a>
            <a href="login/index.php">Login</a>
            <a href="login/signup.php">Signup</a>
        </nav>
        <div class="icon">
            <i class="fas fa-search" onclick="showbar()" id="search-btn"></i>
            
        </div>
        <form action="" class="search-form">
            <input type="search" id="search-bar" placeholder="What you looking for...">
            <label for="search-bar" class="fas fa-search"></label>
        </form>
    </header> 

    <div class="small-container">
        <div class="row">
        <?php
        $sql = "SELECT * FROM `destinations`";
        $result = $conn->query($sql);

        if ($result->rowCount() > 0) {
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $name = $row['DestinationName'];
                $description = $row['Description'];
                $location = $row['Location'];
                $image = $row['destinationsImage'];
                $price = $row['Price'];
                ?>
                <div class="col-4">
                    <img src="../img/destinations/<?php echo $image; ?>" alt="<?php echo $name; ?>">
                    <div class="content">
                        <h3><i class="fas fa-map-marker-alt"></i> <?php echo $name; ?></h3>
                        <p><?php echo $description; ?></p>
                        <div class="price">$<?php echo $price; ?></div>
                        <a href="../Destinationsdetails/index.php?id=<?php echo $row['DestinationID']; ?>" class="btn">check now</a>
                    </div>
                </div>
                <?php
            }
        } else {
            echo "<div class='alert alert-info'>No destinations found.</div>";
        }
        ?>
            <!-- <div class="col-4">
                <a href="productsdetails.html"><img src="../images/p-1.jpg"></a>
                <h4>Product Name 1</h4>
                <p>$50.00</p>
            </div>
            <div class="col-4">
                <a href="productsdetails.html"><img src="../images/p-2.jpg"></a>
                <h4>Product Name 2</h4>
                <p>$50.00</p>
            </div>
            <div class="col-4">
                <a href="productsdetails.html"><img src="../images/p-3.jpg"></a>
                <h4>Product Name 3</h4>
                <p>$50.00</p>
            </div>
            <div class="col-4">
                <a href="productsdetails.html"><img src="../images/p-4.jpg"></a>
                <h4>Product Name 4</h4>
                <p>$50.00</p>
            </div>
            <div class="col-4">
                <a href="productsdetails.html"><img src="../images/paris.jpg"></a>
                <h4>Product Name 5</h4>
                <p>$50.00</p>
            </div>
            <div class="col-4">
                <a href="productsdetails.html"><img src="../images/15.jpg"></a>
                <h4>Product Name 6</h4>
                <p>$50.00</p>
            </div>
            <div class="col-4">
                <a href="productsdetails.html"><img src="../images/p-5.jpg"></a>
                <h4>Product Name 7</h4>
                <p>$50.00</p>
            </div>
            <div class="col-4">
                <a href="productsdetails.html"><img src="../images/g-6.jpg"></a>
                <h4>Product Name 8</h4>
                <p>$50.00</p>
            </div>
            <div class="col-4">
                <a href="productsdetails.html"><img src="../images/g-7.jpg"></a>
                <h4>Product Name 9</h4>
                <p>$50.00</p>
            </div>
            <div class="col-4">
                <a href="productsdetails.html"><img src="../images/g-8.jpg"></a>
                <h4>Product Name 10</h4>
                <p>$50.00</p>
            </div>
            <div class="col-4">
                <a href="productsdetails.html"><img src="../images/g-9.jpg"></a>
                <h4>Product Name 11</h4>
                <p>$50.00</p>
            </div>
            <div class="col-4">
                <a href="productsdetails.html"><img src="../images/g-5.jpg"></a>
                <h4>Product Name 12</h4>
                <p>$50.00</p>
            </div> -->
        </div>
    </div>

    
<section class="footer">
        <div class="box-container">
            <div class="box">
                <h3>about us</h3>
                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Veritatis temporibus quas quasi facere id, aspernatur rem obcaecati maiores inventore expedita.</p>
            </div>
            <div class="box">
                <h3>barnch</h3>
                <a href="#">egypt</a>
                <a href="#">london</a>
                <a href="#">korea</a>
                <a href="#">japan</a>
            </div>
            <div class="box">
                <h3>quick links</h3>
                <a href="#">home</a>
                <a href="#">book</a>
                <a href="#">packages</a>
                <a href="#">services</a>
                <a href="#">gallary</a>
                <a href="#">review</a>
                <a href="#">contact</a>
            </div>
            <div class="box">
                <h3>follow us</h3>
                <a href="#">facebook</a>
                <a href="#">instagram</a>
                <a href="#">twitter</a>
                <a href="#">linkedin</a>
            </div>
        </div>
        <h1 class="created">created by <span>Balygh Tajalden</span> all right reserved</h1>
    </section>






    <script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

    <script src="travel.js"></script>
</body>
<script>
        var MenuItems = document.getElementById("MenuItems");
        MenuItems.style.maxHeight = "0px";
        function menutoggle() {
            if (MenuItems.style.maxHeight == "0px") {
                MenuItems.style.maxHeight = "200px";
            } else {
                MenuItems.style.maxHeight = "0px";
            }
        }
    </script>
</html>