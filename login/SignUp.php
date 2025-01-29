<?php
require "../include/db.php";

$error = []; // مصفوفة لتخزين الأخطاء
$success = ""; // رسالة النجاح

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role = $_POST['role'];

    if (empty($username)) {
        $error['nameEmpty'] = "<b5 style='color:red;'>Name Can't be Empty</b5>";
    } else if (is_numeric($username)) {
        $error['nameNum'] = "<b5 style='color:red;'>Name Must be Alphabetic</b5>";
    }else if(!preg_match("/^[a-zA-Z0-9\s,.'-]+$/", $username)){
        $error['nameInvalid'] = "<b5 style='color:red;'>Username must be one word and contain only English letters and numbers.</b5>";
    } else {
        $username = trim($username);
        $username = htmlspecialchars($username);
        $sql = "SELECT * FROM users WHERE UserName = :username";
        $stmt = $conn->prepare($sql);
        $stmt->execute([':username' => $username]);
        if ($stmt->rowCount() > 0) {
            $error['nameExists'] = "<b5 style='color:red;'>Username already exists</b5>";
        }
    }

    // التحقق من البريد الإلكتروني
    if (empty($email)) {
        $error['emailEmpty'] = "<b5 style='color:red;'>Email Can't be Empty</b5>";
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error['emailInvalid'] = "<b5 style='color:red;'>Invalid Email Format</b5>";
    } else {
        $email = trim($email);
        $email = htmlspecialchars($email);

        $sql_check_email = "SELECT * FROM users WHERE email = :email";
        $stmt_check_email = $conn->prepare($sql_check_email);
        $stmt_check_email->execute([':email' => $email]);
        if ($stmt_check_email->rowCount() > 0) {
            $error['emailExists'] = "<b5 style='color:red;'>Email already exists</b5>";
        }
    }

    // التحقق من كلمة المرور
    if (empty($password)) {
        $error['passwordEmpty'] = "<b5 style='color:red;'>Password Can't be Empty</b5>";
    } else if (strlen($password) < 6) {
        $error['passwordInvalid'] = "<b5 style='color:red;'>Password must be at least 6 characters long.</b5>";
    } else {
        $password = trim($password);
        $password = htmlspecialchars($password);
    }

    // التحقق من تأكيد كلمة المرور
    if (empty($confirm_password)) {
        $error['confirmPasswordEmpty'] = "<b5 style='color:red;'>Confirm Password Can't be Empty</b5>";
    } else if ($password !== $confirm_password) {
        $error['passwordMismatch'] = "<b5 style='color:red;'>Passwords do not match.</b5>";
    } else {
        $confirm_password = trim($confirm_password);
        $confirm_password = htmlspecialchars($confirm_password);
    }


    if (empty($_POST['phone'])){
        $error['phoneEmpty'] = "<b5 style='color:red;'>Phone Can't be Empty</b5>";
    }else{
        $phone = $_POST['phone'];
        if(!ctype_digit($phone)){
            $error['phoneDigits'] = "<b5 style='color:red;'>Phone number must contain numbers only.</b5>";
        }else if(strlen($phone)> 15){
            $error['phoneLen'] = "<b5 style='color:red;'>Phone number must be 10 Deigits.</b5>";
        }else{
            $sql_check_phone = "SELECT * FROM users WHERE phone = :phone";
            $stmt_check_phone = $conn->prepare($sql_check_phone);
            $stmt_check_phone->execute([':phone' => $phone]);
            if ($stmt_check_phone->rowCount() > 0) {
                $error['phoneExists'] = "<b5 style='color:red;'>Phone number already exists</b5>";
            }
        }
    }


    $address = $_POST['address'];
    if(empty($address)){
        $error['addressEmpty'] = "<b5 style='color:red;'>Address Can't be Empty</b5>";
    }else if (strlen($address)> 20){
        $error['addressLen'] = "<b5 style='color:red;'>Title must be longer than 20 characters</b5>";
    }else if(!preg_match("/^[a-zA-Z0-9\s,.'-]+$/", $address)){
            $error['addressFormat'] = "<b5 style='color:red;'>The title contains invalid characters.</b5>";
    }else if (is_numeric($address)){
            $error['addressNumeric'] =  "<b5 style = 'color:red;'>The address is letters </b5>";

    }else{
        $address = trim($address);
        $address = htmlspecialchars($address);
    }

    // إذا لم تكن هناك أخطاء، قم بإدراج المستخدم في قاعدة البيانات
    if (empty($error)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT); // تشفير كلمة المرور

        // إدراج البيانات في جدول users
        $sql = "INSERT INTO users (UserName, email,address, phone, password, Role) VALUES (:username, :email,:address, :phone, :password, :role)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':username' => $username,
            ':email' => $email,
            ':address' => $address,
            ':phone' => $phone,
            ':password' => $hashed_password,
            ':role' => $role
        ]);

        if ($stmt->rowCount() > 0) {
            // إعادة توجيه المستخدم إلى صفحة المستخدم
            header("Location: ../users/index.php");
            exit(); // تأكد من إيقاف تنفيذ النص البرمجي بعد التوجيه
        } else {
            $error['databaseError'] = "<h4 style='color:red;'>Failed to register user.</h4>";
        }
    }
}
?>
<!doctype html>
<html lang="en"> 
 <head> 
  <meta charset="UTF-8"> 
  <title>Travel</title> 
  <link rel="stylesheet" href="./style.css"> 
 </head> 
 <body> 
<section> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> 

    <div class="signin">
      <div class="content">
        <h2>Sign Up</h2>
        <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
        <div class="form">
            <div class="inputBox">
              <input type="text" name="username" placeholder="Your Username">
              <?php 
              if (isset($error['nameEmpty'])) {
                 echo $error['nameEmpty'];
               }else if(isset($error['nameNum'])){
                 echo $error['nameNum'];
               }else if(isset($error['nameExists'])){
                 echo $error['nameExists'];
               }else if (isset($error['nameInvalid'])) {
                  echo $error['nameInvalid'];
               }
              ?>
            </div>
            <div class="inputBox">
              <input type="email" name="email" placeholder="Your Email">
              <?php 
              if (isset($error['emailEmpty'])) {
                  echo $error['emailEmpty'];
              } else if (isset($error['emailInvalid'])) {
                  echo $error['emailInvalid'];
              }elseif (isset($error['emailExists'])) {
                  echo $error['emailExists'];
              }
              ?>
            </div>
            <div class="inputBox">
              <input type="text" name="address" placeholder="Your Address">
              <?php 
              if (isset($error['addressEmpty'])) {
                  echo $error['addressEmpty'];
              } else if (isset($error['addressInvalid'])) {
                  echo $error['addressInvalid'];
              }
              ?>
            </div>
              <div class="inputBox">
              <input type="tel" name="phone" placeholder="Your Phone">
              <?php 
              if (isset($error['phoneEmpty'])) {
                  echo $error['phoneEmpty'];
              } else if (isset($error['phoneInvalid'])) {
                  echo $error['phoneInvalid'];
              }elseif (isset($error['phoneExists'])) {
                  echo $error['phoneExists'];
              }
              ?>
            </div>
            <div class="inputBox">
              <input type="password" name="password" placeholder="Password">
              <?php 
               if (isset($error['passwordEmpty'])) {
                  echo $error['passwordEmpty'];
              } else if(isset($error['passwordInvalid'])){
                  echo $error['passwordInvalid'];
              }
              ?>
            </div>
            <div class="inputBox">
              <input type="password" name="confirm_password" placeholder="Confirm Password">
              <?php 
              if(isset($error['confirmPasswordEmpty'])){
               echo $error['confirmPasswordEmpty'];
              } else if(isset($error['passwordMismatch'])){
               echo $error['passwordMismatch'];
               }
              ?>
            </div>
            <div class="inputBox">
              <input type="hidden" name="role" value="user"> 
            </div>
            <div class="links"> <a href="#">Forgot Password</a> <a href="./index.php">Login</a> </div>
            <div class="inputBox">
              <input type="submit" value="SignUp"> 
            </div>
        </div>
      </form>
      </div>
    </div>
  </section>
 </body>
</html>