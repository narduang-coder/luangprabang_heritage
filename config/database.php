<?php
// config/database.php
// รองรับ Railway environment variables

// Railway จะ inject ตัวแปรเหล่านี้โดยอัตโนมัติ
$server = getenv('MYSQLHOST') ?: 'localhost';
$user = getenv('MYSQLUSER') ?: 'root';
$password = getenv('MYSQLPASSWORD') ?: '';
$port = getenv('MYSQLPORT') ?: '3306';
$db_name = getenv('MYSQLDATABASE') ?: 'railway';

// ถ้าใช้ MYSQL_URL (format mysql://user:pass@host:port/db)
$mysql_url = getenv('MYSQL_URL');
if ($mysql_url) {
    $url = parse_url($mysql_url);
    $server = $url['host'];
    $user = $url['user'];
    $password = $url['pass'];
    $db_name = ltrim($url['path'], '/');
    $port = isset($url['port']) ? $url['port'] : '3306';
}

// สร้างการเชื่อมต่อแบบมี port
$connect = mysqli_connect($server, $user, $password, $db_name, $port);

// ตั้งค่า charset เป็น utf8mb4
if ($connect) {
    mysqli_set_charset($connect, "utf8mb4");
} else {
    // Log error แต่ไม่แสดงรายละเอียดใน production
    error_log("Database connection failed: " . mysqli_connect_error());
    die("ການເຊື່ອມຕໍ່ຖານຂໍ້ມູນລົ້ມເຫຼວ, ກະລຸນາລອງໃໝ່ພາຍຫຼັງ");
}
?>