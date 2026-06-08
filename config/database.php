<?php
// config/database.php
// ສຳລັບ Railway - ແກ້ໄຂບັນຫາການເຊື່ອມຕໍ່

// ປິດການສະແດງ error ໃຫ້ຜູ້ໃຊ້ (ແຕ່ບັນທຶກໄວ້)
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);

// ກຳນົດຄ່າການເຊື່ອມຕໍ່
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'railway';
$port = 3306;

// ອ່ານຄ່າຈາກ environment variables (Railway)
if (getenv('RAILWAY_ENVIRONMENT')) {
    // ໃຊ້ MySQL URL ຈາກ Railway
    $mysql_url = getenv('MYSQL_URL');
    if ($mysql_url) {
        $parts = parse_url($mysql_url);
        $host = $parts['host'];
        $username = $parts['user'];
        $password = $parts['pass'];
        $database = ltrim($parts['path'], '/');
        $port = $parts['port'] ?? 3306;
    } else {
        // ໃຊ້ individual variables
        $host = getenv('MYSQLHOST') ?: 'localhost';
        $username = getenv('MYSQLUSER') ?: 'root';
        $password = getenv('MYSQLPASSWORD') ?: '';
        $database = getenv('MYSQLDATABASE') ?: 'railway';
        $port = getenv('MYSQLPORT') ?: 3306;
    }
}

// ສ້າງການເຊື່ອມຕໍ່
$connect = null;
try {
    $connect = mysqli_connect($host, $username, $password, $database, $port);
    
    // ກວດສອບການເຊື່ອມຕໍ່
    if (!$connect) {
        throw new Exception(mysqli_connect_error());
    }
    
    // ຕັ້ງຄ່າ charset
    mysqli_set_charset($connect, 'utf8mb4');
    
    // ບັນທຶກວ່າເຊື່ອມຕໍ່ສຳເລັດ (ສຳລັບ debugging)
    error_log("Database connected successfully to: $database@$host:$port");
    
} catch (Exception $e) {
    error_log("Database connection failed: " . $e->getMessage());
    
    // ບໍ່ສະແດງ error ໃຫ້ຜູ້ໃຊ້ ແຕ່ສ້າງ $connect ເປັນ false
    $connect = false;
}

// ຟັງຊັນກວດສອບການເຊື່ອມຕໍ່
function is_db_connected() {
    global $connect;
    return $connect !== false && $connect !== null;
}
?>