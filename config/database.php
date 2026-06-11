<?php
// config/database.php สำหรับ Railway
$server = "acela.proxy.rlwy.net";
$user = "root";
$password = "tTFPdYKTjSRhiQJugkkJqtYVnMPHDQNu";
$db_name = "railway";
$port = 19814;

$connect = mysqli_connect($server, $user, $password, $db_name, $port);

if (!$connect) {
    die("ການເຊື່ອມຕໍ່ຖານຂໍ້ມູນລົ້ມເຫຼວ: " . mysqli_connect_error());
}

mysqli_set_charset($connect, "utf8mb4");
?>