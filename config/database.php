<?php
$server = "localhost";
$user = "root";
$password = "";
$db_name = "luangprabang_heritage";
$connect = mysqli_connect($server, $user, $password, $db_name);
mysqli_set_charset($connect, "utf8");

if (!$connect) {
    die("ການເຊື່ອມຕໍ່ຖານຂໍ້ມູນລົ້ມເຫຼວ: " . mysqli_connect_error());
}
?>