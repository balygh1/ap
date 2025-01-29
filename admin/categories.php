<?php include('include/header.php') ?>
<?php require('../include/db.php')?>
        <!-- /. NAV SIDE  -->
        <div id="page-wrapper">
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                        <h2><i class="fa fa-tasks"></i> Categories</h2>
                    </div>
                </div>
                <?php 
                if($_SERVER['REQUEST_METHOD'] == 'POST'){
                    $name = $_POST['name'];
                    if (empty($name)){
                        $error['nameEmpty'] =  "<b5 style = 'color:red;'>The name is empty </b5>";
                    }else if (is_numeric($name)){
                        $error['nameNumeric'] =  "<b5 style = 'color:red;'>The name is letters </b5>";
                    }


                    if(empty($_FILES['image']['name'])){
                        $error['imageEmpty'] = "<b5 style='color:red;'>Product Image Can't be Empty</b5>";
                    }else{
                            $nameImg = $_FILES['image']['name'];
                            $mytypes= array("jpg","jpeg","png","gif");
                            $ext= explode(".",$nameImg);
                            $ext=end($ext);
                            $ext= strtolower($ext);
                            if(in_array($ext,$mytypes)){
                                if($_FILES['image']['size'] > 2000000){
                                    if (move_uploaded_file($_FILES['image']['tmp_name'], "../img/$nameImg")) {
                                        echo "success";
                                        echo "<img src = '../img/$nameImg' width ='100px'>";
                                    }else{
                                        $error['imageUpload'] = "<b5 style='color:red;'>Image Can't be Empty</b5>";
                                    }
                            }else{
                                $error['imageSize'] = "<b5 style='color:red;'>Image Can't be Empty</b5>";
                            }
                        }else {
                            $error['imageType'] = "<b5 style='color:red;'>Image Can't be Empty</b5>";
                        }
                    } 
                    if(empty($error)){
                        if(empty($_POST['C_id'])){
                            $sqlisertCat ="INSERT INTO `Destinations`(`DestinationName`, `destinationsImage`) VALUES (:x1,:x2)";
                            $querySelectCat = $conn->prepare($sqlisertCat);
                            $querySelectCat->execute(array(':x1'=>$name,':x2'=>$nameImg));
                            if($querySelectCat->rowCount() > 0){    
                                echo "<h4 class='alert alert-success'>Category Added Successfully</h4>";                                
                            }else{
                                echo "<h4 class='alert alert-danger'>Category Not Added</h4>";
                            }
                        }
                    }
                }
                ?>
                <hr />
                <div class="row">
                    <div class="col-md-8">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <i class="fa fa-plus-circle"></i> Add New Category
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" role="form" enctype="multipart/form-data" method="POST">
                                            <div class="form-group">
                                                <input type="hidden" name="C_id" value="">
                                                <label>Name</label>
                                                <input type="text" placeholder="Please Enter your Name" class="form-control" name="name">
                                                <?php
                                                if (isset($error['nameEmpty'])) {
                                                    echo $error['nameEmpty'];
                                                }else if (isset($error['nameNumeric'])) {
                                                    echo $error['nameNumeric'];
                                                }
                                                ?>
                                            </div>
                                            <div class="form-group">
                                                <label>Category Image</label><br>
                                                <img src="../../../img/" alt="Category Image" style="border: none; width: 100px; border-radius: 50px; height: 100px; object-fit: fill;">
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
                                            <div style="float:right;">
                                                <button type="submit" class="btn btn-primary">Add Category</button>
                                                <button type="reset" class="btn btn-danger">Cancel</button>
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
                                <i class="fa fa-tasks"></i> Categories
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                        <thead>
                                            <tr>
                                                <th>Number</th>
                                                <th>Name</th>
                                                <th>Image</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>Example Category</td>
                                                <td><img src="../img/default.jpg" align="center" style="border: none; width: 100px; border-radius: 50px; height: 60px; object-fit: fill;"></td>
                                                <td>
                                                    <a href="edit_category.php" class='btn btn-success'>Edit</a>
                                                    <a href="delete_category.php" class='btn btn-danger'>Delete</a>
                                                    <a href="activate_category.php" class='btn btn-warning'>Activate</a>
                                                </td>
                                            </tr>
                                            <!-- More rows can be added here -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /. ROW  -->
                </div>
                <!-- /. PAGE INNER  -->
            </div>
            <!-- /. PAGE WRAPPER  -->
        </div>
    </div>
    <!-- /. WRAPPER  -->
    <!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
    <!-- JQUERY SCRIPTS -->
    <script src="assets/js/jquery-1.10.2.js"></script>
    <!-- BOOTSTRAP SCRIPTS -->
    <script src="assets/js/bootstrap.min.js"></script>
    <!-- METISMENU SCRIPTS -->
    <script src="assets/js/jquery.metisMenu.js"></script>
    <!-- MORRIS CHART SCRIPTS -->
    <script src="assets/js/morris/raphael-2.1.0.min.js"></script>
    <script src="assets/js/morris/morris.js"></script>
    <!-- CUSTOM SCRIPTS -->
    <script src="assets/js/custom.js"></script>
</body>

</html>