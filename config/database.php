<?php
// Railway ຈະສົ່ງຄ່າເຫຼົ່ານີ້ມາໃຫ້ເວັບໄຊທ໌ໂດຍອັດຕະໂນມັດ
$hostname = getenv('MYSQLHOST') ?: 'mysql-1kri.railway.internal



';
$username = getenv('MYSQLUSER') ?: 'root';
$password = getenv('MYSQLPASSWORD') ?: '';
$database = getenv('MYSQLDATABASE') ?: 'railway';
$port     = getenv('MYSQLPORT') ?: '3306';

// ສ້າງການເຊື່ອມຕໍ່ໂດຍໃສ່ຮູບແບບ Port ເຂົ້າໄປນຳ
$conn = new mysqli($hostname, $username, $password, $database, $port);

if ($conn->connect_error) {
    die("ການເຊື່ອມຕໍ່ຜິດພາດ: " . $conn->connect_error);
}
// ຖ້າເຊື່ອມຕໍ່ສຳເລັດ ລະບົບຈະເຮັດວຽກຕໍ່ໄປ...
?>