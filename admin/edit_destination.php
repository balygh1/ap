<?php
require('../include/db.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // جلب بيانات الوجهة من قاعدة البيانات
    $sql = "SELECT * FROM `destinations` WHERE `DestinationID` = :id";
    $query = $conn->prepare($sql);
    $query->execute(array(':id' => $id));
    $destination = $query->fetch(PDO::FETCH_ASSOC);

    if (!$destination) {
        echo "<div class='alert alert-danger'>Destination not found.</div>";
        exit();
    }
} else {
    echo "<div class='alert alert-danger'>Invalid request.</div>";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $location = $_POST['location'];

    // التحقق من الحقول الفارغة
    if (empty($name)) {
        $error['nameEmpty'] = "<div class='alert alert-danger'>The destination name is empty</div>";
    }
    if (empty($description)) {
        $error['descriptionEmpty'] = "<div class='alert alert-danger'>The description is empty</div>";
    }
    if (empty($location)) {
        $error['locationEmpty'] = "<div class='alert alert-danger'>The location is empty</div>";
    }

    // معالجة صورة الوجهة
    $image_name = $destination['destinationsImage']; // الصورة الحالية
    if (!empty($_FILES['image']['name'])) {
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
                // تم تحميل الصورة بنجاح
            } else {
                $error['imageUpload'] = "<div class='alert alert-danger'>Failed to upload image</div>";
            }
        }
    }

    if (empty($error)) {
        // تحديث بيانات الوجهة في قاعدة البيانات
        $sql = "UPDATE `destinations` 
                SET `DestinationName` = :name, 
                    `Description` = :description, 
                    `Location` = :location, 
                    `destinationsImage` = :image 
                WHERE `DestinationID` = :id";
        $query = $conn->prepare($sql);
        $query->execute(array(
            ':name' => $name,
            ':description' => $description,
            ':location' => $location,
            ':image' => $image_name,
            ':id' => $id
        ));

        if ($query->rowCount() > 0) {
            echo "<div class='alert alert-success'>Destination updated successfully!</div>";
        } else {
            echo "<div class='alert alert-danger'>Failed to update destination.</div>";
        }


        header("Location: package.php");
        exit();
    }
}
?>
<?php include('include/header.php'); ?>

<div id="page-wrapper">
    <div id="page-inner">
        <div class="row">
            <div class="col-md-12">
                <h2><i class="fa fa-edit"></i> Edit Destination</h2>
            </div>
        </div>
        <hr />

        <div class="row">
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-edit"></i> Edit Destination
                    </div>
                    <div class="panel-body">
                        <form action="<?php echo $_SERVER['PHP_SELF'] . '?id=' . $id; ?>" method="POST" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>Destination Name</label>
                                <input type="text" placeholder="Enter Destination Name" class="form-control" name="name" value="<?php echo $destination['DestinationName']; ?>">
                                <?php 
                                if (isset($error['nameEmpty'])) {
                                    echo $error['nameEmpty'];
                                }
                                ?>
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <textarea class="form-control" placeholder="Enter Description" name="description" rows="3"><?php echo $destination['Description']; ?></textarea>
                                <?php 
                                if (isset($error['descriptionEmpty'])) {
                                    echo $error['descriptionEmpty'];
                                }
                                ?>
                            </div>
                            <div class="form-group">
                                <label>Location</label>
                                <input type="text" placeholder="Enter Location" class="form-control" name="location" value="<?php echo $destination['Location']; ?>">
                                <?php 
                                if (isset($error['locationEmpty'])) {
                                    echo $error['locationEmpty'];
                                }
                                ?>
                            </div>
                            <div class="form-group">
                                <label>Destination Image</label><br>
                                <img src="../img/destinations/<?php echo $destination['destinationsImage']; ?>" alt="Current Image" style="width: 100px; height: auto;"><br><br>
                                <input type="file" class="form-control" name="image">
                                <?php 
                                if (isset($error['imageType'])) {
                                    echo $error['imageType'];
                                } else if (isset($error['imageSize'])) {
                                    echo $error['imageSize'];
                                } else if (isset($error['imageUpload'])) {
                                    echo $error['imageUpload'];
                                }
                                ?>
                            </div>
                            <div style="float:right;">
                                <button type="submit" class="btn btn-primary">Update Destination</button>
                                <a href="package.php" class="btn btn-danger">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
