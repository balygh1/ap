<?php
require('../../include/db.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // حذف الوجهة من قاعدة البيانات
    $sql = "DELETE FROM `destinations` WHERE `DestinationID` = :id";
    $query = $conn->prepare($sql);
    $query->execute(array(':id' => $id));

    if ($query->rowCount() > 0) {
        echo "<div class='alert alert-success'>Destination deleted successfully!</div>";
    } else {
        echo "<div class='alert alert-danger'>Failed to delete destination.</div>";
    }

    // إعادة التوجيه إلى صفحة إدارة الوجهات بعد الحذف
    header("Location: ../package.php");
    exit();
} else {
    echo "<div class='alert alert-danger'>Invalid request.</div>";
}
?>