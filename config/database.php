<?php
// config/database.php

// ກວດສອບວ່າກຳລັງລະບົບໃດ (Railway ຫຼື Local)
if (getenv('RAILWAY_ENVIRONMENT')) {
    // ຮູບແບບສຳລັບ Railway (ອ່ານຄ່າຈາກ Environment Variables)
    $db_host = getenv('MYSQL_HOST');
    $db_user = getenv('MYSQL_USER');
    $db_pass = getenv('MYSQL_PASSWORD');
    $db_name = getenv('MYSQL_DATABASE');
} else {
    // ຮູບແບບສຳລັບການທົດສອບໃນຄອມພິວເຕີ (Local)
    $db_host = 'localhost';
    $db_user = 'root';
    $db_pass = '';
    $db_name = 'luangprabang_heritage';
}

// ສ້າງການເຊື່ອມຕໍ່
$connect = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

if (!$connect) {
    die("ການເຊື່ອມຕໍ່ຖານຂໍ້ມູນລົ້ມເຫຼວ: " . mysqli_connect_error());
}

mysqli_set_charset($connect, "utf8mb4");
date_default_timezone_set('Asia/Vientiane');
?>