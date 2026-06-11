<?php
header('Content-Type: application/json');
session_start();

// ເຊື່ອມຕໍ່ຖານຂໍ້ມູນ
require_once '../config/database.php';

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    
    if (empty($username) || empty($password)) {
        $response['message'] = 'ກະລຸນາປ້ອນຊື່ຜູ້ໃຊ້ ແລະ ລະຫັດຜ່ານ';
        echo json_encode($response);
        exit;
    }
    
    // ຄົ້ນຫາຜູ້ໃຊ້
    $query = "SELECT * FROM users WHERE username = ?";
    $stmt = mysqli_prepare($connect, $query);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if ($row = mysqli_fetch_assoc($result)) {
        // ກວດສອບລະຫັດຜ່ານ
        if (password_verify($password, $row['password'])) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['fullname'] = $row['fullname_lo'];
            
            $response['success'] = true;
            $response['message'] = 'ເຂົ້າສູ່ລະບົບສຳເລັດ';
        } else {
            $response['message'] = 'ລະຫັດຜ່ານບໍ່ຖືກຕ້ອງ';
        }
    } else {
        $response['message'] = 'ບໍ່ພົບຊື່ຜູ້ໃຊ້ນີ້';
    }
} else {
    $response['message'] = 'ວິທີການຮ້ອງຂໍບໍ່ຖືກຕ້ອງ';
}

echo json_encode($response);
?>