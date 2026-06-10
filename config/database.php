<?php
// ============================================
// Database Connection Configuration
// ============================================

// Railway Environment Variables
// อ่านค่าจาก Environment Variables
$host = getenv('MYSQLHOST') ?: (getenv('DB_HOST') ?: 'localhost');
$user = getenv('MYSQLUSER') ?: (getenv('DB_USER') ?: 'root');
$password = getenv('MYSQLPASSWORD') ?: (getenv('DB_PASS') ?: '');
$database = getenv('MYSQL_DATABASE') ?: (getenv('DB_NAME') ?: 'luangprabang_heritage');
$port = getenv('MYSQLPORT') ?: (getenv('DB_PORT') ?: 3306);

// สร้างการเชื่อมต่อด้วย mysqli
$connect = mysqli_connect($host, $user, $password, $database, $port);

// ตรวจสอบการเชื่อมต่อ
if (!$connect) {
    // Debug Mode - แสดงข้อผิดพลาด
    $error_msg = mysqli_connect_error();
    
    // Log the error
    error_log("Database Connection Error: " . $error_msg);
    error_log("Host: " . $host);
    error_log("User: " . $user);
    error_log("Database: " . $database);
    error_log("Port: " . $port);
    
    // สำหรับ development
    if (getenv('APP_ENV') === 'development') {
        die("❌ ข้อผิดพลาดในการเชื่อมต่อฐานข้อมูล: " . $error_msg . 
            "<br>Host: " . $host .
            "<br>Port: " . $port);
    } else {
        // สำหรับ production
        die("❌ ข้อผิดพลาดในการเชื่อมต่อฐานข้อมูล กรุณาลองใหม่อีกครั้ง");
    }
}

// ตั้งค่า charset เป็น UTF-8
mysqli_set_charset($connect, "utf8mb4");

// ตั้งค่า timezone
mysqli_query($connect, "SET time_zone = '+00:00'");

// ✅ ปิด automatic commit เพื่อควบคุม transaction
mysqli_autocommit($connect, false);

?>
