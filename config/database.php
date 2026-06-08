<?php
// config/database.php
// ສຳລັບ Railway (MySQL)
$host = getenv('MYSQLHOST') ?: 'localhost';
$username = getenv('MYSQLUSER') ?: 'root';
$password = getenv('MYSQLPASSWORD') ?: '';
$database = getenv('MYSQLDATABASE') ?: 'heritage_db';
$port = getenv('MYSQLPORT') ?: '3306';

// ສ້າງການເຊື່ອມຕໍ່
$connect = mysqli_connect($host, $username, $password, $database, $port);

// ກວດສອບການເຊື່ອມຕໍ່
if (!$connect) {
    // ບັນທຶກ error ໄວ້
    error_log("Connection failed: " . mysqli_connect_error());
    
    // ສະແດງຂໍ້ຄວາມທີ່ເປັນມິດກັບຜູ້ໃຊ້
    die(json_encode([
        'success' => false, 
        'message' => 'ບໍ່ສາມາດເຊື່ອມຕໍ່ຖານຂໍ້ມູນໄດ້. ກະລຸນາກວດສອບການຕັ້ງຄ່າ.'
    ]));
}

// ຕັ້ງຄ່າ charset
mysqli_set_charset($connect, 'utf8mb4');

// ສຳລັບການທົດສອບ
// echo "Connected successfully";
?>