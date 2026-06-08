<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) { header('Content-Type: application/json'); echo json_encode(['success' => false, 'message' => 'Unauthorized']); exit; }
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
    $query = "SELECT * FROM heritage_houses WHERE house_id = $house_id";
    $result = mysqli_query($connect, $query);
    $house = mysqli_fetch_assoc($result);
    if (!$house) { echo json_encode(['success' => false, 'message' => 'House not found']); exit; }
    if (empty($house['qr_code'])) { $qr_id = 'LP_' . uniqid(); mysqli_query($connect, "UPDATE heritage_houses SET qr_code='$qr_id' WHERE house_id=$house_id"); }
    else { $qr_id = $house['qr_code']; }
    if (!is_dir('../qr_codes')) mkdir('../qr_codes', 0777, true);
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
    $host = $_SERVER['HTTP_HOST'];
    $base_url = $protocol . $host;
    $base_url = str_replace('/admin', '', $base_url);
    $qr_data = $base_url . '/luangprabang_heritage/heritage_detail.php?id=' . $qr_id;
    $qr_image = generateQRCode($qr_data, 300);
    if ($qr_image !== false) { $qr_filename = "qr_codes/{$qr_id}.png"; file_put_contents("../" . $qr_filename, $qr_image); echo json_encode(['success' => true, 'qr_url' => $qr_filename, 'qr_id' => $qr_id, 'qr_data' => $qr_data]); }
    else { echo json_encode(['success' => false, 'message' => 'Failed to generate QR code']); }
    exit;
}
echo json_encode(['success' => false, 'message' => 'Invalid request']);
?>