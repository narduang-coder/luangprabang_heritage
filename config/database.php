<?php
// ສ່ວນເຊື່ອມຕໍ່ (ຄືຂອງທ່ານ)
$hostname = getenv('MYSQLHOST') ?: 'mysql-1kri.railway.internal';
$username = getenv('MYSQLUSER') ?: 'root';
$password = getenv('MYSQLPASSWORD') ?: '';
$database = getenv('MYSQL_DATABASE') ?: 'heritage_houses';
$port     = getenv('MYSQLPORT') ?: '3306';

$conn = new mysqli($hostname, $username, $password, $database, $port);

if ($conn->connect_error) {
    die("ການເຊື່ອມຕໍ່ຜິດພາດ: " . $conn->connect_error);
}

// ຕັ້ງຄ່າ encoding (ແນະນຳ)
$conn->set_charset("utf8mb4");

// ເຮັດວຽກກັບຖານຂໍ້ມູນ...
$sql = "SELECT * FROM houses";
$result = $conn->query($sql);

// ປິດການເຊື່ອມຕໍ່ເມື່ອສຳເລັດ
$conn->close();
?>