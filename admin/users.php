<?php include('include/header.php') ?>
<?php require('../include/db.php') ?>
<?php
session_start(); // بدء الجلسة
if (isset($_SESSION['delete_message'])) {
    echo $_SESSION['delete_message'];
    unset($_SESSION['delete_message']); 
}
?>

        <div id="page-wrapper">
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                        <h2><i class="fa fa-users"></i> Users</h2>
                    </div>
                </div>
                <?php 
                if($_SERVER['REQUEST_METHOD'] == 'POST'){
                    $name = $_POST['name'];
                    
                    if (empty($name)){
                        $error['nameEmpty'] =  "<b5 style = 'color:red;'>The name is empty </b5>";
                    }else if (is_numeric($name)){
                        $error['nameNumeric'] =  "<b5 style = 'color:red;'>The name is letters </b5>";

                    }else if(!preg_match("/^[a-zA-Z0-9\s,.'-]+$/", $name)){
                        $error['nameInvalid'] = "<b5 style='color:red;'>Username must be one word and contain only English letters and numbers.</b5>";
                    }else{
                        $name = trim($name);
                        $name = htmlspecialchars($name);
                    }

                    $email = $_POST['email'];
                    if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
                        $error['email'] =  "<b5 style = 'color:red;'>The email is not valid </b5>";
                    }else{
                        $sql_check_email = "SELECT * FROM `users` WHERE `email` = :email";
                        $query_check_email = $conn->prepare($sql_check_email);
                        $query_check_email->execute([':email' => $email]);
                        if ($query_check_email->rowCount() > 0) {
                            $error['emailExists'] = "<b5 style='color:red;'>Email already exists</b5>";
                        }
                    }

                    $category = $_POST['role_id'];
                    if (empty($category)){
                        $error['categoryEmpty'] = "<b5 style='color:red;'>Product Category Can't be Empty</b5>";
                    }

                    if (empty($error)) {
                    if (empty($_FILES['image']['name'])) {
                        $error['imageEmpty'] = "<b5 style='color:red;'>User Image Can't be Empty</b5>";
                    } else {
                        $image_name = $_FILES['image']['name'];
                        $image_tmp = $_FILES['image']['tmp_name'];
                        $image_type = $_FILES['image']['type'];
                        $image_size = $_FILES['image']['size'];
                        $upload_path = "../img/" . uniqid() . "_" . $image_name;
                    
                        $allowed_types = array("jpg", "jpeg", "png", "gif");
                        $ext = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));
                    
                        if (!in_array($ext, $allowed_types)) {
                            $error['imageType'] = "<b5 style='color:red;'>Only JPG, JPEG, PNG, and GIF files are allowed</b5>";
                        } elseif ($image_size > 2000000) {
                            $error['imageSize'] = "<b5 style='color:red;'>Image size must be less than 2MB</b5>";
                            
                        } elseif (move_uploaded_file($image_tmp, $upload_path)) {
                                $uploaded_image_name = basename($upload_path); // تخزين اسم الصورة
                            } else {
                                $error['imageUpload'] = "<b5 style='color:red;'>Failed to upload image</b5>";
                            }
                        }
                    }


                    if(empty($_POST['password'])){
                        $error['passEmpty'] = "<b5 style='color:red;'>Password Can't be Empty</b5>";
                    }else{
                        $pass = $_POST['password'];
                        if(strlen($pass) < 8){
                            $error['passLength'] = "<b5 style='color:red;'>Password must be more than 8 characters </b5>";
                        }
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
                            $sql_check_phone = "SELECT * FROM `users` WHERE `Phone` = :phone";
                            $query_check_phone = $conn->prepare($sql_check_phone);
                            $query_check_phone->execute([':phone' => $phone]);
                            if ($query_check_phone->rowCount() > 0) {
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
                    $role_id = $_POST['role_id'];
                    if (empty($role_id)) {
                        $error['roleEmpty'] = "<b5 style='color:red;'>User Role Can't be Empty</b5>";
                    } elseif (!in_array($role_id, [1, 2])) {
                        $error['roleInvalid'] = "<b5 style='color:red;'>Invalid Role Selected</b5>";
                    } 
                    
                    if (empty($error)) {
                        $sql = "INSERT INTO `users` (`username`, `email`, `UserImage`, `password`, `Address`, `Phone`, `role`) 
                                VALUES (:name, :email, :image, :password, :address, :phone, :role)";
                        $query = $conn->prepare($sql);
                        $query->execute([
                            ':name' => $name,
                            ':email' => $email,
                            ':image' => $uploaded_image_name, // تأكد من أن هذه القيمة تم تعيينها بشكل صحيح
                            ':password' => password_hash($pass, PASSWORD_DEFAULT), // تشفير كلمة المرور
                            ':address' => $address,
                            ':phone' => $phone,
                            ':role' => $role_id
                        ]);
                    
                        if ($query->rowCount() > 0) {
                            echo "<div class='alert alert-success'>User added successfully!</div>";
                        } else {
                            echo "<div class='alert alert-danger'>Error: Failed to add user</div>";
                        }
                    }
                }
                ?>
                <hr />
                <div class="row">
                    <div class="col-md-8">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <i class="fa fa-plus-circle"></i> Add New User
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <form  action="<?php $_SERVER['PHP_SELF']; ?>" role="form" enctype="multipart/form-data" method="POST">
                                            <div class="form-group">
                                                <input type="hidden" name="user_id" value="">
                                                <label>Name</label>
                                                <input type="text" placeholder="Please Enter your Name" class="form-control" name="name">
                                                <?php 
                                                if(isset($error['nameEmpty'])){
                                                    echo $error['nameEmpty'];
                                                }else if (isset($error['nameNumeric'])) {
                                                    echo $error['nameNumeric'];
                                                }else if (isset($error['nameExists'])) {
                                                    echo $error['nameExists'];
                                                }
                                                ?>
                                            </div>
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input type="email" placeholder="Please Enter your Email" class="form-control" name="email">
                                                <?php 
                                                if(isset($error['email'])){
                                                    echo $error['email'];
                                                }else if(isset($error['emailExists'])){
                                                    echo $error['emailExists'];
                                                }
                                                ?>
                                            </div>
                                            <div class="form-group">
                                                <label>User Image</label><br>
                                                <img src="../../../images/default.jpg" alt="User Image" style="border: none; width: 100px; border-radius: 50px; height: 100px; object-fit: fill;">
                                                <input type="file" class="form-control" name="image">
                                                <?php 
                                                if (isset($error['imageEmpty'])) {
                                                    echo $error['imageEmpty'];
                                                }else if (isset($error['imageUpload'])) {
                                                    echo $error['imageUpload'];
                                                }else if (isset($error['imageSize'])) { 
                                                    echo $error['imageSize'];
                                                }else if (isset($error['imageType'])) {
                                                    echo $error['imageType'];
                                                }
                                                ?>
                                            </div>
                                            <div class="form-group">
                                                <label>Password</label>
                                                <input type="password" class="form-control" placeholder="Please Enter password" name="password" >
                                                <?php
                                                if(isset($error['passEmpty'])) {
                                                    echo $error['passEmpty'];
                                                }else if(isset($error['passLength'])){
                                                    echo $error['passLength'];
                                                }
                                                ?>
                                            </div>
                                            <div class="form-group">
                                                <label>Address</label>
                                                <input type="text" class="form-control" placeholder="Please Enter address" name="address" >
                                                <?php 
                                                if(isset($error['addressEmpty'])){
                                                    echo $error['addressEmpty'];
                                                }else if(isset($error['addressLen'])){
                                                    echo $error['addressLen'];
                                                }else if(isset($error['addressFormat'])){
                                                    echo $error['addressFormat'];
                                                }else if(isset($error['addressNumeric'])){
                                                    echo $error['addressNumeric'];
                                                }
                                                ?>
                                            </div>
                                            <div class="form-group">
                                                <label>Phone</label>
                                                <input type="tel" class="form-control" placeholder="Please Enter your phone" name="phone" >
                                                <?php 
                                                if(isset($error['phoneEmpty'])){
                                                    echo $error['phoneEmpty'];
                                                }else if(isset($error['phoneDigits'])){
                                                    echo $error['phoneDigits'];
                                                }else if(isset($error['phoneLen'])){
                                                    echo $error['phoneLen'];
                                                }else if(isset($error['phoneExists'])){
                                                    echo $error['phoneExists'];
                                                }
                                                ?>
                                            </div>
                                            <div class="form-group">
                                                <label>User Type</label>
                                                <select class="form-control" name="role_id">
                                                    <option></option>
                                                    <option value="1" <?php echo (isset($role_id) && $role_id == 1) ? 'selected' : ''; ?>>Admin</option>
                                                    <option value="2" <?php echo (isset($role_id) && $role_id == 2) ? 'selected' : ''; ?>>User</option>                                                </select>
                                                 <?php
                                                 if (isset($error['roleEmpty'])) {
                                                     echo $error['roleEmpty'];
                                                 } elseif (isset($error['roleInvalid'])) {
                                                     echo $error['roleInvalid'];
                                                 }
                                                 ?>
                                            </div>
                                            <div style="float:right;">
                                                <button type="submit" class="btn btn-primary">Add User</button>
                                                <button type="reset" onclick="refreshPage()" class="btn btn-danger">Cancel</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr />
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <i class="fa fa-users"></i> Users
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Image</th>
                                                <th>Email</th>
                                                <th>Password</th>
                                                <th>Address</th>
                                                <th>Phone</th>
                                                <th>Role</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $sql = "SELECT * FROM `users`";
                                            $result = $conn->query($sql);
                                            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                                $role = ($row['role'] == 1) ? 'Admin' : 'User';
                                                echo "<tr class='odd gradeX'>
                                                        <td>{$row['username']}</td>
                                                        <td><img src='../img/{$row['UserImage']}' alt='User Image' style='border: none; width: 100px; border-radius: 50px; height: 100px; object-fit: fill;'></td>
                                                        <td>{$row['email']}</td>
                                                        <td>{$row['password']}</td>
                                                        <td>{$row['Address']}</td>
                                                        <td>{$row['Phone']}</td>
                                                        <td>{$role}</td>
                                                        <td>
                                                            <a href='edit_user.php?id={$row['id']}' class='btn btn-success'>Edit</a>
                                                            <a href='users/delete_user.php?id={$row['id']}' class='btn btn-danger' onclick='return confirm(\"Are you sure you want to delete this user?\")'>Delete</a>
                                                        </td>
                                                      </tr>";
                                            }
                                            ?>
                                            <!-- More rows can be added here -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <script src="assets/js/jquery-1.10.2.js"></script>
                <script src="assets/js/bootstrap.min.js"></script>
                <script src="assets/js/jquery.metisMenu.js"></script>
                <script src="assets/js/morris/raphael-2.1.0.min.js"></script>
                <script src="assets/js/morris/morris.js"></script>
                <script src="assets/js/custom.js"></script>
            </div>
        </div>
    </div>
</body>

</html>