<?php
session_start(); // بدء الجلسة
require('../../include/db.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // حذف الوجهة من قاعدة البيانات
    $sql = "DELETE FROM `users` WHERE `id` = :id";
    $query = $conn->prepare($sql);
    $query->execute(array(':id' => $id));

    if ($query->rowCount() > 0) {
        $_SESSION['delete_message'] = "<h4 style='text-align: center;' class='alert alert-success'>User deleted successfully!</h4>";
    } else {
        $_SESSION['delete_message'] = "<div style='text-align: center;' class='alert alert-danger'>Failed to delete user.</div>";
    }

    // إعادة التوجيه إلى صفحة إدارة الوجهات بعد الحذف
    header("Location: ../users.php");
    exit();
} else {
    echo "<div class='alert alert-danger'>Invalid request.</div>";
}
?>