<?php
// config/database.php สำหรับ Railway

// ดึงค่าจาก Environment Variables ที่ Railway กำหนดให้
$server = getenv('MYSQLHOST') ?: 'localhost';
$user = getenv('MYSQLUSER') ?: 'root';
$password = getenv('MYSQLPASSWORD') ?: '';
$db_name = getenv('MYSQLDATABASE') ?: 'luangprabang_heritage';
$port = getenv('MYSQLPORT') ?: 3306;

// สร้างการเชื่อมต่อ
$connect = mysqli_connect($server, $user, $password, $db_name, $port);

if (!$connect) {
    die("ການເຊື່ອມຕໍ່ຖານຂໍ້ມູນລົ້ມເຫຼວ: " . mysqli_connect_error());
}

mysqli_set_charset($connect, "utf8mb4");
?>