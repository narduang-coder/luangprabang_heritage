<?php
header('Content-Type: application/json');
include_once __DIR__ . '/../config/database.php';

$sql = "SELECT * FROM heritage";
$result = mysqli_query($connect, $sql);

if (!$result) {
    echo json_encode([
        "success" => false,
        "message" => "查询失败: " . mysqli_error($connect)
    ]);
    exit;
}

if (mysqli_num_rows($result) > 0) {
    $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
    echo json_encode([
        "success" => true,
        "data" => $data
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "ບໍ່ພົບຂໍ້ມູນເຮືອນມໍລະດົກ",
        "data" => null
    ]);
}

mysqli_close($connect);
?>