<?php require('../include/db.php')?>
<?php
session_start();


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // استعلام للتحقق من المستخدم
    $sql = "SELECT `id`, `username`, `email`, `password`, `Role` FROM `users` WHERE `UserName` = :username";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array(':username' => $username));
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['UserName'];
        $_SESSION['role'] = $user['Role'];

        // توجيه المستخدم بناءً على الدور
        if ($user['Role'] == 1) {
            header("Location: ../admin/index.php");
        } else {
            header("Location: ../users/index.php");
        }
        exit();
    } else {
        echo "<h4 class='alert alert-danger'>Invalid username or password</h4>";
    }
}
?>

<!doctype html>
<html lang="en"> 
 <head> 
  <meta charset="UTF-8"> 
  <title>Travel</title> 
  <link rel="stylesheet" href="./style.css"> 
  <script>
    function askToSaveCredentials(username, password) {
        if (confirm("هل تريد حفظ بيانات تسجيل الدخول؟")) {
            localStorage.setItem('savedUsername', username);
            localStorage.setItem('savedPassword', password);
            alert("تم حفظ بيانات تسجيل الدخول.");
        }
    }

    window.onload = function() {
        const savedUsername = localStorage.getItem('savedUsername');
        const savedPassword = localStorage.getItem('savedPassword');
        if (savedUsername && savedPassword) {
            document.querySelector('input[name="username"]').value = savedUsername;
            document.querySelector('input[name="password"]').value = savedPassword;
        }
    }
  </script>
 </head> 
 <body> <!-- partial:index.partial.html --> 

  <section> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> 

   <div class="signin"> 
    <div class="content"> 
     <h2>Sign In</h2> 
     <form action="<?php echo $_SERVER['PHP_SELF'];?>" method='Post' onsubmit="askToSaveCredentials(this.username.value, this.password.value)">
     <div class="form"> 
      <div class="inputBox"> 
       <input type="text" name="username" required> <i>Username</i> 
      </div> 
      <div class="inputBox"> 
       <input type="password" name="password" required> <i>Password</i> 
      </div> 
      <div class="links"> <a href="#">Forgot Password</a> <a href="SignUp.php">Signup</a> 
      </div> 
      <div class="inputBox"> 
       <input type="submit" value="Login"> 
      </div> 

   </div> 
   </form>
</div> 
   </div> 
  </section> <!-- partial --> 
 </body>
</html>