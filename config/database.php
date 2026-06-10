<?php
// XAMPP Database Configuration
$host = "localhost";        // หรือ 127.0.0.1
$user = "root";             // XAMPP ใช้ root
$password = "";             // XAMPP ไม่มีรหัสผ่าน (เว้นว่าง)
$database = "luangprabang_heritage";
$port = 3306;

$connect = mysqli_connect($host, $user, $password, $database, $port);

if (!$connect) {
    die("❌ ການເຊື່ອມຕໍ່ຖານຂໍ້ມູນລົ້ມເຫຼວ: " . mysqli_connect_error());
}

mysqli_set_charset($connect, "utf8mb4");

echo "<!-- ເຊື່ອມຕໍ່ຖານຂໍ້ມູນສຳເລັດ -->";
?>