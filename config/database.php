<?php
// config/database.php สำหรับ Localhost
$server = "localhost";
$user = "root";
$password = "";
$db_name = "luangprabang_heritage";
$port = 3306;

$connect = mysqli_connect($server, $user, $password, $db_name, $port);

if (!$connect) {
    die("ການເຊື່ອມຕໍ່ຖານຂໍ້ມູນລົ້ມເຫຼວ: " . mysqli_connect_error());
}

mysqli_set_charset($connect, "utf8mb4");
?>