<?php include('include/header.php') ?>


<?php 
               if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $cost = $_POST['cost'];
                if(empty($cost)){
                    $error['costEmpty'] = "<b5 style='color:red;'>Product Cost Can't be Empty</b5>";
                }else if (!is_numeric($cost)){
                    $error['costNum'] = "<b5 style='color:red;'>Product Cost Must be Numeric</b5>";
                }else{
                    $cost =trim($cost);
                    $cost = htmlspecialchars($cost);
                    echo $cost;
                }


                $tname = $_POST['tname'];
                if(empty($tname)){
                    $error['tnameEmpty'] = "<b5 style='color:red;'>Product Name Can't be Empty</b5>";
                }else if (is_numeric($tname)){
                    $error['tnameNum'] = "<b5 style='color:red;'>Product Name Must be Numeric</b5>";
                }else{
                    $tname =trim($tname);
                    $tname = htmlspecialchars($tname);
                    echo $tname;
                }


                $ename = $_POST['ename'];
                if(empty($ename)){
                    $error['enameEmpty'] = "<b5 style='color:red;'>Product Name Can't be Empty</b5>";
                }else if (is_numeric($ename)){
                    $error['enameNum'] = "<b5 style='color:red;'>Product Name Must be Numeric</b5>";
                }else{
                    $ename =trim($ename);
                    $ename = htmlspecialchars($ename);
                    echo $ename;
                }
                $category = $_POST['category'];
                if (empty($category)){
                    $error['categoryEmpty'] = "<b5 style='color:red;'>Product Category Can't be Empty</b5>";
                }

                if(empty($_FILES['image1']['name'])){
                    $error['imageEmpty'] = "<b5 style='color:red;'>Product Image Can't be Empty</b5>";
                }else{
                        $name = $_FILES['image1']['name'];
                        $mytypes= array("jpg","jpeg","png","gif");
                        $ext= explode(".",$name);
                        $ext=end($ext);
                        $ext= strtolower($ext);
                        if(in_array($ext,$mytypes)){
                            if($_FILES['image1']['size'] > 2000000){
                                if (move_uploaded_file($_FILES['image1']['tmp_name'], "../img/$name")) {
                                    echo "success";
                                    echo "<img src = '../img/$name' width ='100px'>";
                                }else{
                                    $error['imageUpload'] = "<b5 style='color:red;'>Product Image Can't be Empty</b5>";
                                }
                        }else{
                            $error['imageSize'] = "<b5 style='color:red;'>Product Image Can't be Empty</b5>";
                        }
                    }else {
                        $error['imageType'] = "<b5 style='color:red;'>Product Image Can't be Empty</b5>";
                    }
                }
               }
               
                ?>

        <div id="page-wrapper">
            <div id="page-inner">

                <div class="row">
                    <div class="col-md-12">
                        <h2><i class="fa fa-bars"></i> Product</h2>
                    </div>
                </div>
                
                <hr />
                <div class="row">
                    <div class="col-md-8">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <i class="fa fa-plus-circle"></i> Add New product
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>"  role="form" enctype="multipart/form-data" method="POST">
                                            <div class="form-group">
                                                <input type="hidden" name="user_id" value="">
                                                <label>Thai Name</label>
                                                <input type="text" placeholder="Please Enter your Name " class="form-control" name="tname">
                                                <?php 
                                                if (isset($error['tnameEmpty'])) {
                                                    echo $error['tnameEmpty'];
                                                }else if(isset($error['tnameNum'])){
                                                    echo $error['tnameNum'];
                                                }
                                                ?>
                                                
                                            </div>
                                            <div class="form-group">
                                                <label>English Name</label>
                                                <input type="text" placeholder="Please Enter your Name " class="form-control" name="ename">
                                                <?php
                                                if(isset($error['enameEmpty'])){
                                                    echo $error['enameEmpty'];
                                                }else if(isset($error['enameNum'])){
                                                    echo $error['enameNum'];
                                                }
                                                ?>
                                            </div>
                                            <div class="form-group">
                                                <label>Product image 1</label><br>
                                                <input type="file" class="form-control" name="image1">
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
                                                <label>Cost</label>
                                                <input type="text" class="form-control" placeholder="Please Enter your Cost" name="cost">
                                                <?php 
                                                if (isset($error['costEmpty'])) {
                                                    echo $error['costEmpty'];
                                                }else if(isset($error['costNum'])){
                                                    echo $error['costNum'];
                                                }
                                                ?>
                                            </div>
                                            <div class="form-group">
                                                <label>Product Category</label>
                                                <select class="form-control" name="category">
                                                    <option></option>
                                                    <option value="1">Category 1</option>
                                                    <option value="2">Category 2</option>
                                                </select>
                                                <?php
                                                 if(isset($error['categoryEmpty'])){
                                                    echo $error['categoryEmpty'];
                                                 }
                                                 ?>
                                            </div>
                                            <div style="float:right;">
                                                <button type="submit" class="btn btn-primary">Add Product</button>
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
                                <i class="fa fa-bars"></i> Product
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                        <thead>
                                            <tr>
                                                <th>Thai Name</th>
                                                <th>English Name</th>
                                                <th>Image</th>
                                                <th>Cost</th>
                                                <th>Category</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="odd gradeX">
                                                <td>Product 1</td>
                                                <td>Product 1 EN</td>
                                                <td><img src="../img/image1.jpg" alt="image1" style="border: none; width: 100px; border-radius: 50px; height: 100px; object-fit: fill; transition: none;"></td>
                                                <td>10$</td>
                                                <td>Category 1</td>
                                                <td>
                                                    <a href="#" class='btn btn-success'>Edit</a>
                                                    <a href="#" class='btn btn-danger'>Delete</a>
                                                    <a href="#" class='btn btn-warning'>Active</a>
                                                </td>
                                            </tr>
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