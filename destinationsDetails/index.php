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
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet"href="https://unpkg.com/swiper@8/swiper-bundle.min.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
</head>
<?php
session_start();
require "../include/db.php";

// استقبال معرف الوجهة من الرابط
if (isset($_GET['id'])) {
    $destination_id = $_GET['id'];

    // جلب تفاصيل الوجهة من قاعدة البيانات
    $sql = "SELECT * FROM destinations WHERE DestinationID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$destination_id]);
    $destination = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($destination) {
        $name = $destination['DestinationName'];
        $description = $destination['Description'];
        $location = $destination['Location'];
        $image = $destination['destinationsImage'];
        $price = $destination['Price'];
    } else {
        // إذا لم يتم العثور على الوجهة
        $name = "الوجهة غير موجودة";
        $description = "لا يوجد وصف متاح.";
        $location = "غير معروف";
        $image = "default.jpg"; // صورة افتراضية
        $price = "0.00";
    }
} else {
    // إذا لم يتم تقديم معرف الوجهة
    $name = "معرف غير صالح";
    $description = "لا يوجد وصف متاح.";
    $location = "غير معروف";
    $image = "default.jpg"; // صورة افتراضية
    $price = "0.00";
}
?>
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
            <a href="../login/index.php">Login</a>
            <a href="../login/signup.php">Signup</a>
        </nav>
        <div class="icon">
            <i class="fas fa-search" onclick="showbar()" id="search-btn"></i>
            
        </div>
        <form action="" class="search-form">
            <input type="search" id="search-bar" placeholder="What you looking for...">
            <label for="search-bar" class="fas fa-search"></label>
        </form>
    </header> 

    <div class="small-container single-product">
    <div class="row">
        <div class="col-2">
            <img src="../img/destinations/<?php echo $image; ?>" width="100%" id="productImg" class="product-image">
            <div class="small-img-row">
                <div class="small-img-col">
                    <img src="../img/destinations/<?php echo $image; ?>" width="100%" class="small-img">
                </div>
            </div>
        </div>
        <div class="col-2">
            <h1><?php echo $name; ?></h1>
            <p><?php echo $description; ?></p>
            <p>Location: <?php echo $location; ?></p>
            <p>Price: $<?php echo $price; ?></p>
            <a class="btn" href="">Check Out</a>
        </div>
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