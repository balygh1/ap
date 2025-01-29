<?php
/* session_start();
require "../include/db.php"; // تأكد من أن هذا الملف يحتوي على اتصال بقاعدة البيانات

// تعريف المتغيرات
$_SESSION['error'] = []; // مصفوفة لتخزين الأخطاء
$_SESSION['success'] = ""; // رسالة النجاح

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // استقبال البيانات من النموذج
    $destination = $_POST['destination'];
    $num_people = $_POST['num_people'];
    $arrival_date = $_POST['arrival_date'];
    $leaving_date = $_POST['leaving_date'];

    // 1. التحقق من أن الحقول ليست فارغة
    if (empty($destination) || empty($num_people) || empty($arrival_date) || empty($leaving_date)) {
        $_SESSION['error']['Empty'] = "<div id='error-message' class='message-box'><h4 class='alert alert-danger'>Please fill in all fields.</h4></div>";
    }

    // 2. التحقق من أن تاريخ المغادرة بعد تاريخ الوصول
    else if (strtotime($leaving_date) <= strtotime($arrival_date)) {
        $_SESSION['error']['ErrorDate'] = "<div id='error-message' class='message-box'><h4 class='alert alert-danger'>Leaving date must be after arrival date.</h4></div>";
    }

    // 3. إذا لم يكن هناك أخطاء، يتم إدخال البيانات في قاعدة البيانات
    else {
        // حساب السعر الإجمالي (يمكن تعديله حسب منطقك)
        $total_price = $num_people * 500; // مثال: 500 دولار لكل شخص

        // إدخال البيانات في قاعدة البيانات
        try {
            $sqlInsertBooking = "INSERT INTO `bookings` (`Destination`, `NumPeople`, `ArrivalDate`, `LeavingDate`, `TotalPrice`) 
                                 VALUES (:destination, :num_people, :arrival_date, :leaving_date, :total_price)";
            $queryInsertBooking = $conn->prepare($sqlInsertBooking);

            // ربط القيم بالاستعلام
            $queryInsertBooking->execute(array(
                ':destination' => $destination,
                ':num_people' => $num_people,
                ':arrival_date' => $arrival_date,
                ':leaving_date' => $leaving_date,
                ':total_price' => $total_price
            ));

            // التحقق من نجاح الإدخال
            if ($queryInsertBooking->rowCount() > 0) {
                $_SESSION['success'] = "<div id='success-message' class='message-box'><h4 class='alert alert-success'>Booking Added Successfully</h4></div>";
            } else {
                $_SESSION['error']['inserted'] = "<div id='error-message' class='message-box'><h4 class='alert alert-danger'>Booking Not Added</h4></div>";
            }
        } catch (PDOException $e) {
            $_SESSION['error']['database'] = "<div id='error-message' class='message-box'><h4 class='alert alert-danger'>Error: " . $e->getMessage() . "</h4></div>";
        }
    }

    // إعادة التوجيه إلى الصفحة الرئيسية بعد المعالجة
    header("Location: ../index.php");
    exit();
}
*/?>