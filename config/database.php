<?php
// config/database.php
$host = getenv("MYSQLHOST");
$port = getenv("MYSQLPORT");
$user = getenv("MYSQLUSER");
$password = getenv("MYSQLPASSWORD");
$database = getenv("MYSQLDATABASE");

$connect = mysqli_connect($host, $user, $password, $database, $port);

if (!$connect) {
    die("ການເຊື່ອມຕໍ່ຖານຂໍ້ມູນລົ້ມເຫຼວ: " . mysqli_connect_error());
}
?>