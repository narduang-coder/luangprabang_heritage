<?php
// config/database.php

// ດຶງຄ່າຈາກ Environment Variables ຂອງ Railway
$host = getenv('MYSQLHOST') ?: 'mysql-ravn.railway.internal'; // ໃຊ້ private hostname ສຳຮອງ
$port = getenv('MYSQLPORT') ?: '3306';
$user = getenv('MYSQLUSER') ?: 'root';
$password = getenv('MYSQLPASSWORD') ?: 'VWQXKqUVSUFaxpqvEJPAOAmlXqgMoWmi'; // ປ່ຽນເປັນລະຫັດຜ່ານຂອງເຈົ້າ
$dbname = getenv('MYSQLDATABASE') ?: 'railway';

// ສ້າງການເຊື່ອມຕໍ່
$connect = mysqli_connect($host, $user, $password, $dbname, $port);

// ກວດສອບການເຊື່ອມຕໍ່
if (!$connect) {
    // ສົ່ງຂໍ້ຜິດພາດກັບໄປເປັນ JSON
    http_response_code(500);
    header('Content-Type: application/json');
    echo json_encode([
        "success" => false,
        "message" => "ເຊື່ອມຕໍ່ຖານຂໍ້ມູນລົ້ມເຫຼວ: " . mysqli_connect_error()
    ]);
    exit;
}

// ຕັ້ງຄ່າຊຸດຕົວອັກສອນເປັນ utf8mb4 ເພື່ອຮອງຮັບພາສາລາວ
mysqli_set_charset($connect, "utf8mb4");

// ປິດການລາຍງານຂໍ້ຜິດພາດແບບປົກກະຕິ (optional)
mysqli_report(MYSQLI_REPORT_OFF);
?>