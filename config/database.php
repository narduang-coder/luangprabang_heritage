<?php
// config/database.php

// ກວດສອບວ່າ extension mysqli ຖືກໂຫຼດຫຼືບໍ່
if (!extension_loaded('mysqli')) {
    die("❌ PHP extension 'mysqli' is not loaded. Please check your PHP configuration.");
}

// ໃຊ້ Environment Variables ຂອງ Railway (ຫຼື ຄ່າເລີ່ມຕົ້ນສຳລັບ local)
$db_host = getenv('MYSQL_HOST') ?: 'localhost';
$db_user = getenv('MYSQL_USER') ?: 'root';
$db_pass = getenv('MYSQL_PASSWORD') ?: '';
$db_name = getenv('MYSQL_DATABASE') ?: 'luangprabang_heritage';

// ສ້າງການເຊື່ອມຕໍ່
$connect = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

if (!$connect) {
    die("ການເຊື່ອມຕໍ່ຖານຂໍ້ມູນລົ້ມເຫຼວ: " . mysqli_connect_error());
}

mysqli_set_charset($connect, "utf8mb4");
date_default_timezone_set('Asia/Vientiane');
?>