<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    echo json_encode(['success' => false, 'message' => 'ທ່ານບໍ່ມີສິດລຶບຂໍ້ມູນ']);
    exit;
}

$user_role = $_SESSION['admin_role'] ?? 'viewer';
if (!in_array($user_role, ['admin', 'staff'])) {
    echo json_encode(['success' => false, 'message' => 'ທ່ານບໍ່ມີສິດລຶບຂໍ້ມູນ']);
    exit;
}

include_once '../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

$house_id = intval($_POST['house_id'] ?? 0);
if ($house_id <= 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid house ID']);
    exit;
}

mysqli_begin_transaction($connect);

try {
    $imgQuery = "SELECT image_path FROM heritage_images WHERE house_id = $house_id";
    $imgResult = mysqli_query($connect, $imgQuery);
    while ($img = mysqli_fetch_assoc($imgResult)) {
        if ($img['image_path'] && file_exists('../../uploads/' . $img['image_path'])) {
            unlink('../../uploads/' . $img['image_path']);
       