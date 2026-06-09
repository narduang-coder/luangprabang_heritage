<?php
// config/database.php
$server = 'mysql-1kri.railway.internal';  // หรือใช้ 'mysql-1kri.up.railway.app'
$user = 'root';
$password = 'tTFPdYKTjSRhiQJugkkJqtYVnMPHDQNu';  // ใช้ตัวที่ถูกต้อง
$db_name = 'railway';
$port = 3306;

$connect = mysqli_connect($server, $user, $password, $db_name, $port);
mysqli_set_charset($connect, "utf8mb4");

if (!$connect) {
    die("ການເຊື່ອມຕໍ່ຖານຂໍ້ມູນລົ້ມເຫຼວ: " . mysqli_connect_error());
}
?>