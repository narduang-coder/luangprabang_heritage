<?php
// ใช้ Environment Variables จาก Railway โดยตรง
$server = getenv("MYSQLHOST") ?: "mysql.railway.internal";
$user = getenv("MYSQLUSER") ?: "root";
$password = getenv("MYSQLPASSWORD") ?: "";
$db_name = getenv("MYSQLDATABASE") ?: "railway";
$port = (int)(getenv("MYSQLPORT") ?: 3306);

// เปิด error report (ปิดตอน production ก็ได้)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// เชื่อมต่อ MySQL
$connect = mysqli_connect($server, $user, $password, $db_name, $port);

// ตั้งค่าชุดตัวอักษร
if ($connect) {
    mysqli_set_charset($connect, "utf8mb4");
}

// ตรวจสอบการเชื่อมต่อ
if (!$connect) {
    header('Content-Type: application/json');
    echo json_encode([
        "success" => false,
        "message" => "ເຊື່ອມຕໍ່ຖານຂໍ້ມູນລົ້ມເຫຼວ: " . mysqli_connect_error()
    ]);
    exit;
}

// ถ้าต้องการตรวจสอบว่าตารางมีอยู่จริง
// $check_table = mysqli_query($connect, "SHOW TABLES LIKE 'heritage'");
// if (mysqli_num_rows($check_table) == 0) {
//     echo json_encode(["success" => false, "message" => "ຍັງບໍ່ມີຕາຕະລາງໃນຖານຂໍ້ມູນ"]);
//     exit;
// }
?>