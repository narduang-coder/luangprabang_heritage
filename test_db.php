<?php
// ຟາຍ: test_db.php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>🔍 ວິນິດໄສລະບົບ</h1>";

// 1. ກວດສອບການເຊື່ອມຕໍ່ຖານຂໍ້ມູນ
echo "<h2>1. ການເຊື່ອມຕໍ່ຖານຂໍ້ມູນ</h2>";

// ລອງໃຊ້ຄ່າຕ່າງໆ ເພື່ອກວດຫາບັນຫາ
$db_host = getenv('MYSQL_HOST') ?: 'localhost';
$db_user = getenv('MYSQL_USER') ?: 'root';
$db_pass = getenv('MYSQL_PASSWORD') ?: '';
$db_name = getenv('MYSQL_DATABASE') ?: 'luangprabang_heritage';

echo "<p>Host: " . $db_host . "</p>";
echo "<p>User: " . $db_user . "</p>";
echo "<p>Database: " . $db_name . "</p>";

$connect = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

if (!$connect) {
    echo "<p style='color:red'>❌ ເຊື່ອມຕໍ່ລົ້ມເຫຼວ: " . mysqli_connect_error() . "</p>";
} else {
    echo "<p style='color:green'>✅ ເຊື່ອມຕໍ່ສຳເລັດ!</p>";
    
    // 2. ກວດສອບວ່າມີຕາຕະລາງ heritage_houses ບໍ່
    echo "<h2>2. ກວດສອບຕາຕະລາງ heritage_houses</h2>";
    $result = mysqli_query($connect, "SHOW TABLES LIKE 'heritage_houses'");
    if (mysqli_num_rows($result) > 0) {
        echo "<p style='color:green'>✅ ພົບຕາຕະລາງ heritage_houses</p>";
        
        // 3. ນັບຈຳນວນຂໍ້ມູນ
        $count_result = mysqli_query($connect, "SELECT COUNT(*) as total FROM heritage_houses");
        $row = mysqli_fetch_assoc($count_result);
        echo "<p>ຈຳນວນຂໍ້ມູນ: <strong>" . $row['total'] . "</strong> ຫຼັງ</p>";
        
        if ($row['total'] > 0) {
            // 4. ສະແດງລາຍຊື່ QR Code
            $qr_result = mysqli_query($connect, "SELECT qr_code, house_name_lo FROM heritage_houses");
            echo "<h3>ລາຍຊື່ QR Code ທີ່ມີ:</h3>";
            echo "<ul>";
            while ($qr = mysqli_fetch_assoc($qr_result)) {
                echo "<li><code>" . htmlspecialchars($qr['qr_code']) . "</code> - " . htmlspecialchars($qr['house_name_lo']) . "</li>";
            }
            echo "</ul>";
        } else {
            echo "<p style='color:red'>❌ ຕາຕະລາງມີແຕ່ບໍ່ມີຂໍ້ມູນ! ກະລຸນາເພີ່ມຂໍ້ມູນ.</p>";
        }
    } else {
        echo "<p style='color:red'>❌ ບໍ່ພົບຕາຕະລາງ heritage_houses! ກະລຸນາສ້າງຕາຕະລາງກ່ອນ.</p>";
    }
    
    mysqli_close($connect);
}

// 5. ສະແດງ Environment Variables (ສຳລັບ Railway)
echo "<h2>3. Environment Variables (ສຳລັບ Railway)</h2>";
echo "<pre>";
echo "MYSQL_HOST: " . (getenv('MYSQL_HOST') ?: '(not set)') . "\n";
echo "MYSQL_USER: " . (getenv('MYSQL_USER') ?: '(not set)') . "\n";
echo "MYSQL_DATABASE: " . (getenv('MYSQL_DATABASE') ?: '(not set)') . "\n";
echo "RAILWAY_ENVIRONMENT: " . (getenv('RAILWAY_ENVIRONMENT') ?: '(not set)') . "\n";
echo "</pre>";
?>