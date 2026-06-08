<?php
session_start();

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) { 
    header('Content-Type: application/json'); 
    echo json_encode(['success' => false, 'message' => 'Unauthorized']); 
    exit; 
}

include_once '../config/database.php';
header('Content-Type: application/json');

// ຟັງຊັນສ້າງ QR Code
function generateQRCode($data, $size = 300) {
    $url1 = "https://api.qrserver.com/v1/create-qr-code/?size={$size}x{$size}&data=" . urlencode($data);
    $qr_image = @file_get_contents($url1);
    if ($qr_image !== false && strlen($qr_image) > 500) return $qr_image;
    
    $url2 = "https://quickchart.io/qr?text=" . urlencode($data) . "&size={$size}";
    $qr_image = @file_get_contents($url2);
    if ($qr_image !== false && strlen($qr_image) > 500) return $qr_image;
    
    return false;
}

// ຟັງຊັນດຶງໂດເມນຈາກສະພາບແວດລ້ອມ
function getBaseUrl() {
    // ກວດສອບວ່າຢູ່ໃນ Railway ຫຼືບໍ່
    if (getenv('RAILWAY_PUBLIC_DOMAIN')) {
        return 'https://' . getenv('RAILWAY_PUBLIC_DOMAIN');
    }
    
    // ກວດສອບວ່າມີການຕັ້ງ URL ໃນ config ຫຼືບໍ່
    if (defined('BASE_URL')) {
        return BASE_URL;
    }
    
    // ດຶງຈາກ server variable (ໃຊ້ກັບ domain ຈິງ)
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
    $host = $_SERVER['HTTP_HOST'];
    
    // ຖ້າເປັນ localhost ຫຼື 127.0.0.1, ຕ້ອງກຳນົດຄ່າເອງ
    if ($host == 'localhost' || $host == '127.0.0.1' || strpos($host, '.local') !== false) {
        // ແກ້ໄຂຕາມໂດເມນຂອງເຈົ້າທີ່ຂຶ້ນຈິງ
        return 'https://your-domain.up.railway.app'; // ປ່ຽນເປັນໂດເມນຈິງຂອງເຈົ້າ
    }
    
    return $protocol . $host;
}

// ອ່ານໂດເມນຈາກໄຟລ໌ config ຖ້າມີ
$config_file = __DIR__ . '/../config/domain.php';
if (file_exists($config_file)) {
    $domain_config = include $config_file;
    if (isset($domain_config['base_url'])) {
        define('BASE_URL', $domain_config['base_url']);
    }
}

$base_url = getBaseUrl();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $house_id = intval($_POST['house_id']);
    
    // ໃຊ້ Prepared Statement ເພື່ອຄວາມປອດໄພ
    $stmt = mysqli_prepare($connect, "SELECT * FROM heritage_houses WHERE house_id = ?");
    mysqli_stmt_bind_param($stmt, "i", $house_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $house = mysqli_fetch_assoc($result);
    
    if (!$house) { 
        echo json_encode(['success' => false, 'message' => 'ບໍ່ພົບຂໍ້ມູນເຮືອນ']); 
        exit; 
    }
    
    // ສ້າງ QR ID ຖ້າຍັງບໍ່ມີ
    if (empty($house['qr_code'])) { 
        $qr_id = 'LP_' . uniqid(); 
        $update_stmt = mysqli_prepare($connect, "UPDATE heritage_houses SET qr_code = ? WHERE house_id = ?");
        mysqli_stmt_bind_param($update_stmt, "si", $qr_id, $house_id);
        mysqli_stmt_execute($update_stmt);
    } else { 
        $qr_id = $house['qr_code']; 
    }
    
    // ສ້າງໂຟນເດີສຳລັບເກັບ QR Code
    if (!is_dir('../qr_codes')) {
        mkdir('../qr_codes', 0777, true);
    }
    
    // ລຶບ QR Code ເກົ່າຖ້າມີ
    $old_qr_path = "../qr_codes/{$qr_id}.png";
    if (file_exists($old_qr_path)) {
        unlink($old_qr_path);
    }
    
    // 🎯 ສ້າງລິ້ງສຳລັບ QR Code (ໃຊ້ໂດເມນຈິງທີ່ຂຶ້ນຢູ່)
    $qr_data = $base_url . '/heritage_detail.php?id=' . $qr_id;
    
    // ສ້າງ QR Code
    $qr_image = generateQRCode($qr_data, 300);
    
    if ($qr_image !== false) { 
        $qr_filename = "qr_codes/{$qr_id}.png"; 
        file_put_contents("../" . $qr_filename, $qr_image); 
        
        echo json_encode([
            'success' => true, 
            'qr_url' => $qr_filename, 
            'qr_id' => $qr_id, 
            'qr_data' => $qr_data,
            'message' => 'ສ້າງ QR Code ສຳເລັດ'
        ]); 
    } else { 
        echo json_encode(['success' => false, 'message' => 'ບໍ່ສາມາດສ້າງ QR Code ໄດ້, ກະລຸນາກວດສອບການເຊື່ອມຕໍ່ອິນເຕີເນັດ']); 
    }
    exit;
}

echo json_encode(['success' => false, 'message' => 'ຄຳຮ້ອງຂໍບໍ່ຖືກຕ້ອງ']);
?>