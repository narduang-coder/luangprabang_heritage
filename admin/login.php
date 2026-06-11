<?php
session_start();

// ກວດສອບການສົ່ງຟອມ
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include 'config/database.php';
    
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($connect, $query);
    
    if ($row = mysqli_fetch_assoc($result)) {
        if (password_verify($password, $row['password'])) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['username'] = $row['username'];
            header('Location: dashboard.php');
            exit();
        } else {
            $error = 'ລະຫັດຜ່ານບໍ່ຖືກຕ້ອງ';
        }
    } else {
        $error = 'ບໍ່ພົບຊື່ຜູ້ໃຊ້ນີ້';
    }
}
?>

<!-- ສ່ວນ HTML ຟອມຕ້ອງປ່ຽນ method ເປັນ POST ແລະ ລຶບ AJAX -->
<form method="POST">
    <!-- ສ່ວນທີ່ເຫຼືອຄືເກົ່າ -->
</form>