<?php
session_start();

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) { 
    header('Content-Type: application/json'); 
    echo json_encode(['success' => false, 'message' => 'Unauthorized']); 
    exit; 
}

include_once '../config/database.php';
header('Content-Type: application/json');

function generateQRCode($data, $size = 300) {
    $url1 = "https://api.qrserver.com/v1/create-qr-code/?size={$size}x{$size}&data=" . urlencode($data);
    $qr_image = @file_get_contents($url1);
    if ($qr_image !== false && strlen($qr_image) > 500) return $qr_image;
    
    $url2 = "https://quickchart.io/qr?text=" . urlencode($data) . "&size={$size}";
    $qr_image = @file_get_contents($url2);
    if ($qr_image !== false && strlen($qr_image) > 500) return $qr_image;
    
    $url3 = "https://goqr.me/api/qr?size={$size}x{$size}&data=" . urlencode($data);
    $qr_image = @file_get_contents($url3);
    if ($qr_image !== false && strlen($qr_image) > 500) return $qr_image;
    
    return false;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $house_id = intval($_POST['house_id']);
    
    // ใช้ Prepared Statement เพื่อความปลอดภัย
    $stmt = mysqli_prepare($connect, "SELECT * FROM heritage_houses WHERE house_id = ?");
    mysqli_stmt_bind_param($stmt, "i", $house_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $house = mysqli_fetch_assoc($result);
    
    if (!$house) { 
        echo json_encode(['success' => false, 'message' => 'House not found']); 
        exit; 
    }
    
    if (empty($house['qr_code'])) { 
        $qr_id = 'LP_' . uniqid(); 
        $update_stmt = mysqli_prepare($connect, "UPDATE heritage_houses SET qr_code = ? WHERE house_id = ?");
        mysqli_stmt_bind_param($update_stmt, "si", $qr_id, $house_id);
        mysqli_stmt_execute($update_stmt);
    } else { 
        $qr_id = $house['qr_code']; 
    }
    
    if (!is_dir('../qr_codes')) {
        mkdir('../qr_codes', 0777, true);
    }
    
    // 🌐 ตั้งค่าโดเมน Railway ของคุณที่นี่ (ไม่ต้องใส่ / ปิดท้าย)
    // เปลี่ยนจาก 'your-project.up.railway.app' เป็นโดเมนจริงของคุณบน Railway
    $railway_domain = "https://your-project.up.railway.app"; 
    
    // 🎯 บังคับให้ลิงก์ใน QR Code วิ่งเข้า Railway เสมอ โดยไม่มีคำว่า localhost หรือชื่อโฟลเดอร์เดิม
    // ผลลัพธ์ที่ได้จะเป็น: https://your-project.up.railway.app/heritage_detail.php?id=LP_xxx
    $qr_data = $railway_domain . '/heritage_detail.php?id=' . $qr_id;
    
    $qr_image = generateQRCode($qr_data, 300);
    
    if ($qr_image !== false) { 
        $qr_filename = "qr_codes/{$qr_id}.png"; 
        file_put_contents("../" . $qr_filename, $qr_image); 
        echo json_encode([
            'success' => true, 
            'qr_url' => $qr_filename, 
            'qr_id' => $qr_id, 
            'qr_data' => $qr_data
        ]); 
    } else { 
        echo json_encode(['success' => false, 'message' => 'Failed to generate QR code']); 
    }
    exit;
}

echo json_encode(['success' => false, 'message' => 'Invalid request']);
?>