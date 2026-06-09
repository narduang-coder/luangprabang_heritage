<?php
include_once __DIR__ . '/../config/database.php';

// ข้อมูลตัวอย่าง (หรืออ่านจาก JSON)
$heritage_data = [
    ['qr_code' => 'TEST001', 'name_lo' => 'ເຮືອນມໍລະດົກ 1', 'name_en' => 'Heritage House 1'],
    ['qr_code' => 'TEST002', 'name_lo' => 'ເຮືອນມໍລະດົກ 2', 'name_en' => 'Heritage House 2'],
];

foreach ($heritage_data as $item) {
    $qr = mysqli_real_escape_string($connect, $item['qr_code']);
    $lo = mysqli_real_escape_string($connect, $item['name_lo']);
    $en = mysqli_real_escape_string($connect, $item['name_en']);
    
    $sql = "INSERT INTO heritage (qr_code, name_lo, name_en) 
            VALUES ('$qr', '$lo', '$en')
            ON DUPLICATE KEY UPDATE name_lo='$lo', name_en='$en'";
    
    if (mysqli_query($connect, $sql)) {
        echo "✔ ເພີ່ມ/ອັບເດດ: $lo<br>";
    } else {
        echo "✖ ຜິດພາດ: " . mysqli_error($connect) . "<br>";
    }
}

mysqli_close($connect);
?>