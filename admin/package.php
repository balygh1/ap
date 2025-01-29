<?php include('include/header.php') ?>
<?php require('../include/db.php') ?>

<div id="page-wrapper">
    <div id="page-inner">
        <div class="row">
            <div class="col-md-12">
                <h2><i class="fa fa-suitcase"></i> Destinations</h2>
            </div>
        </div>
        <?php 
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'];
            if (empty($name)) {
                $error['nameEmpty'] = "<div class='alert alert-danger'>The destination name is empty</div>";
            } else if (is_numeric($name)) {
                $error['nameNumeric'] = "<div class='alert alert-danger'>The destination name should be letters</div>";
            } else {
                $name = trim($name);
                $name = htmlspecialchars($name);
            }

            $description = $_POST['description'];
            if (empty($description)) {
                $error['descriptionEmpty'] = "<div class='alert alert-danger'>The description is empty</div>";
            }
            $price = $_POST['Price'];
            if (empty($price)) {
                $error['priceEmpty'] = "<div class='alert alert-danger'>The price is empty</div>";
            } else if (!is_numeric($price)) {
                $error['priceNumeric'] = "<div class='alert alert-danger'>The price should be a number</div>";
            }
            $location = $_POST['location'];
            if (empty($location)) {
                $error['locationEmpty'] = "<div class='alert alert-danger'>The location is empty</div>";
            }

            if (empty($_FILES['image']['name'])) {
                $error['imageEmpty'] = "<div class='alert alert-danger'>Destination image is required</div>";
            } else {
                $image_name = $_FILES['image']['name'];
                $image_tmp = $_FILES['image']['tmp_name'];
                $image_type = $_FILES['image']['type'];
                $image_size = $_FILES['image']['size'];

                $allowed_types = array("jpg", "jpeg", "png", "gif");
                $ext = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));

                if (!in_array($ext, $allowed_types)) {
                    $error['imageType'] = "<div class='alert alert-danger'>Only JPG, JPEG, PNG, and GIF files are allowed</div>";
                } else if ($image_size > 2000000) {
                    $error['imageSize'] = "<div class='alert alert-danger'>Image size must be less than 2MB</div>";
                } else {
                    $upload_path = "../img/destinations/" . $image_name;
                    if (move_uploaded_file($image_tmp, $upload_path)) {
                        // Successfully uploaded
                    } else {
                        $error['imageUpload'] = "<div class='alert alert-danger'>Failed to upload image</div>";
                    }
                }
            }
            
        
            if (empty($_FILES['image2']['name'])) {
                $error['imageEmpty'] = "<div class='alert alert-danger'>Destination image is required</div>";
            } else {
                $image2_name = $_FILES['image2']['name'];
                $image2_tmp = $_FILES['image2']['tmp_name'];
                $image2_type = $_FILES['image2']['type'];
                $image2_size = $_FILES['image2']['size'];
            
                $ext = strtolower(pathinfo($image2_name, PATHINFO_EXTENSION));
            
                if (!in_array($ext, $allowed_types)) {
                    $error['image2Type'] = "<div class='alert alert-danger'>Only JPG, JPEG, PNG, and GIF files are allowed</div>";
                } else if ($image2_size > 2000000) {
                    $error['image2Size'] = "<div class='alert alert-danger'>Image size must be less than 2MB</div>";
                } else {
                    $upload_path = "../img/destinations/" . $image2_name;
                    if (move_uploaded_file($image2_tmp, $upload_path)) {
                        // Successfully uploaded
                    } else {
                        $error['image2Upload'] = "<div class='alert alert-danger'>Failed to upload image 2</div>";
                    }
                }
            }
        
        
            if (empty($_FILES['image3']['name'])) {
                $error['imageEmpty'] = "<div class='alert alert-danger'>Destination image is required</div>";
            } else {
                $image3_name = $_FILES['image3']['name'];
                $image3_tmp = $_FILES['image3']['tmp_name'];
                $image3_type = $_FILES['image3']['type'];
                $image3_size = $_FILES['image3']['size'];
            
                $ext = strtolower(pathinfo($image3_name, PATHINFO_EXTENSION));
            
                if (!in_array($ext, $allowed_types)) {
                    $error['image3Type'] = "<div class='alert alert-danger'>Only JPG, JPEG, PNG, and GIF files are allowed</div>";
                } else if ($image3_size > 2000000) {
                    $error['image3Size'] = "<div class='alert alert-danger'>Image size must be less than 2MB</div>";
                } else {
                    $upload_path = "../img/destinations/" . $image3_name;
                    if (move_uploaded_file($image3_tmp, $upload_path)) {
                        // Successfully uploaded
                    } else {
                        $error['image3Upload'] = "<div class='alert alert-danger'>Failed to upload image 3</div>";
                    }
                }
            }
        
            if (empty($_FILES['image4']['name'])) {
                $error['imageEmpty'] = "<div class='alert alert-danger'>Destination image is required</div>";
            } else {
                $image4_name = $_FILES['image4']['name'];
                $image4_tmp = $_FILES['image4']['tmp_name'];
                $image4_type = $_FILES['image4']['type'];
                $image4_size = $_FILES['image4']['size'];
            
                $ext = strtolower(pathinfo($image4_name, PATHINFO_EXTENSION));
            
                if (!in_array($ext, $allowed_types)) {
                    $error['image4Type'] = "<div class='alert alert-danger'>Only JPG, JPEG, PNG, and GIF files are allowed</div>";
                } else if ($image4_size > 2000000) {
                    $error['image4Size'] = "<div class='alert alert-danger'>Image size must be less than 2MB</div>";
                } else {
                    $upload_path = "../img/destinations/" . $image4_name;
                    if (move_uploaded_file($image4_tmp, $upload_path)) {
                        // Successfully uploaded
                    } else {
                        $error['image4Upload'] = "<div class='alert alert-danger'>Failed to upload image 4</div>";
                    }
                }
            }
         

            if (empty($error)) {
                // Insert into database
                $sql = "INSERT INTO `destinations` (`DestinationName`, `Description`, `Location`, `destinationsImage`,`imag2`,`imag3`,`imag4`,`Price`) 
                        VALUES (:name, :description, :location, :image, :image2, :image3, :image4, :price)";
                $query = $conn->prepare($sql);
                $query->execute(array(
                    ':name' => $name,
                    ':description' => $description,
                    ':location' => $location,
                    ':image' => $image_name,
                    ':image2' => $image2_name,
                    ':image3' => $image3_name,
                    ':image4' => $image4_name,
                    ':price' => $price
                ));

                if ($query->rowCount() > 0) {
                    echo "<div class='alert alert-success'>Destination added successfully!</div>";
                } else {
                    echo "<div class='alert alert-danger'>Error: Failed to add destination</div>";
                }
            }
        }
        ?>
        <hr />
        <div class="row">
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-plus-circle"></i> Add New Destination
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" role="form" enctype="multipart/form-data" method="POST">
                                    <div class="form-group">
                                        <label>Destination Name</label>
                                        <input type="text" placeholder="Enter Destination Name" class="form-control" name="name">
                                        <?php 
                                        if (isset($error['nameEmpty'])) {
                                            echo $error['nameEmpty'];
                                        } else if (isset($error['nameNumeric'])) {
                                            echo $error['nameNumeric'];
                                        }
                                        ?>
                                    </div>
                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea class="form-control" placeholder="Enter Description" name="description" rows="3"></textarea>
                                        <?php 
                                        if (isset($error['descriptionEmpty'])) {
                                            echo $error['descriptionEmpty'];
                                        }
                                        ?>
                                    </div>
                                    <div class="form-group">
                                        <label>Location</label>
                                        <input type="text" placeholder="Enter Location" class="form-control" name="location">
                                        <?php 
                                        if (isset($error['locationEmpty'])) {
                                            echo $error['locationEmpty'];
                                        }
                                        ?>
                                    </div>
                                    <div class="form-group">
                                        <label>Price</label>
                                        <input type="text" placeholder="Enter Price" class="form-control" name="Price">
                                        <?php 
                                        if (isset($error['PriceEmpty'])) {
                                            echo $error['PriceEmpty'];
                                        }else if (isset($error['PriceNumeric'])) {
                                            echo $error['PriceNumeric'];
                                        }
                                        ?>
                                    </div>
                                    <div class="form-group">
                                        <label>Destination Image</label><br>
                                        <input type="file" class="form-control" name="image">
                                        <?php 
                                        if (isset($error['imageEmpty'])) {
                                            echo $error['imageEmpty'];
                                        } else if (isset($error['imageType'])) {
                                            echo $error['imageType'];
                                        } else if (isset($error['imageSize'])) {
                                            echo $error['imageSize'];
                                        } else if (isset($error['imageUpload'])) {
                                            echo $error['imageUpload'];
                                        }
                                        ?>
                                    </div>
                                    <div class="form-group">
                                        <label>Destination Image2</label><br>
                                        <input type="file" class="form-control" name="image2">
                                        <?php 
                                        if (isset($error['image2Empty'])) {
                                            echo $error['image2Empty'];
                                        } else if (isset($error['image2Type'])) {
                                            echo $error['image2Type'];
                                        } else if (isset($error['image2Size'])) {
                                            echo $error['image2Size'];
                                        } else if (isset($error['image2Upload'])) {
                                            echo $error['image2Upload'];
                                        }
                                        ?>
                                    </div>
                                    <div class="form-group">
                                        <label>Destination Image3</label><br>
                                        <input type="file" class="form-control" name="image3">
                                        <?php 
                                        if (isset($error['image3Empty'])) {
                                            echo $error['image3Empty'];
                                        } else if (isset($error['image3Type'])) {
                                            echo $error['image3Type'];
                                        } else if (isset($error['image3Size'])) {
                                            echo $error['image3Size'];
                                        } else if (isset($error['image3Upload'])) {
                                            echo $error['image3Upload'];
                                        }
                                        ?>
                                    </div>
                                    <div class="form-group">
                                        <label>Destination Image4</label><br>
                                        <input type="file" class="form-control" name="image4">
                                        <?php 
                                        if (isset($error['image4Empty'])) {
                                            echo $error['image4Empty'];
                                        } else if (isset($error['image4Type'])) {
                                            echo $error['image4Type'];
                                        } else if (isset($error['image4Size'])) {
                                            echo $error['image4Size'];
                                        } else if (isset($error['image4Upload'])) {
                                            echo $error['image4Upload'];    
                                        }
                                        ?>
                                    </div>
                                    <div style="float:right;">
                                        <button type="submit" class="btn btn-primary">Add Destination</button>
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
                        <i class="fa fa-suitcase"></i> Destinations List
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Location</th>
                                        <th>Image</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = "SELECT * FROM `destinations`";
                                    $result = $conn->query($sql);
                                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                        echo "<tr class='odd gradeX'>
                                                <td>{$row['DestinationName']}</td>
                                                <td>{$row['Description']}</td>
                                                <td>{$row['Location']}</td>
                                                <td><img src='../img/destinations/{$row['destinationsImage']}' alt='Destination Image' style='width: 100px; height: auto;'></td>
                                                <td>
                                                    <a href='edit_destination.php?id={$row['DestinationID']}' class='btn btn-success'>Edit</a>
                                                    <a href='packages/delete_destination.php?id={$row['DestinationID']}' class='btn btn-danger' onclick='return confirm(\"Are you sure you want to delete this destination?\")'>Delete</a>
                                                </td>
                                              </tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>