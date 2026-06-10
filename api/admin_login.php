<?php
session_start();
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

// 1. ປ່ຽນ Path ໃຫ້ໄປເອີ້ນຫາຟາຍ database.php ທີ່ຢູ່ໂຟນເດີນອກສຸດ
include_once '../database.php'; 

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // 2. ປ່ຽນ $connect ມາເປັນ $conn ໃຫ້ກົງກັບຟາຍ database.php
    $username = isset($_POST['username']) ? mysqli_real_escape_string($conn, $_POST['username']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    
    if (empty($username) || empty($password)) {
        $response['message'] = 'ກະລຸນາປ້ອນຊື່ຜູ້ໃຊ້ ແລະ ລະຫັດຜ່ານ';
        echo json_encode($response);
        exit;
    }
    
    // 3. ປ່ຽນຊື່ Table ຈາກ users ມາເປັນ heritage_houses ໃຫ້ກົງກັບ Database ຈິງຂອງເຈົ້າ
    $query = "SELECT * FROM heritage_houses WHERE username = '$username'";
    $result = mysqli_query($conn, $query); // ປ່ຽນເປັນ $conn
    
    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        
        if (password_verify($password, $user['password'])) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_id'] = $user['user_id'];
            $_SESSION['admin_name'] = $user['fullname_en'] ?: $user['username'];
            $_SESSION['admin_role'] = $user['role'];  
            
            $response['success'] = true;
            $response['message'] = 'ເຂົ້າສູ່ລະບົບສຳເລັດ';
        } else {
            $response['message'] = 'ລະຫັດຜ່ານບໍ່ຖືກຕ້ອງ';
        }
    } else {
        $response['message'] = 'ບໍ່ພົບຊື່ຜູ້ໃຊ້ນີ້';
    }
}

echo json_encode($response);
?>