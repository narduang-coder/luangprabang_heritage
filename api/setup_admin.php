<?php
// api/setup_admin.php
// Idempotent endpoint to create the users table and seed the initial admin user.
// Safe to call multiple times via HTTP GET or POST.

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

include_once '../config/database.php';

$response = [
    'success' => false,
    'steps'   => [],
    'message' => ''
];

// ── Step 1: Create users table ────────────────────────────────────────────────
$create_table_sql = "
    CREATE TABLE IF NOT EXISTS users (
        user_id    INT AUTO_INCREMENT PRIMARY KEY,
        username   VARCHAR(50)  UNIQUE NOT NULL,
        password   VARCHAR(255) NOT NULL,
        fullname_en VARCHAR(100),
        fullname_lo VARCHAR(100),
        email      VARCHAR(100),
        role       ENUM('admin', 'staff', 'viewer') DEFAULT 'viewer',
        status     ENUM('active', 'inactive')       DEFAULT 'active',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
";

if (mysqli_query($connect, $create_table_sql)) {
    $response['steps'][] = 'users table created (or already exists)';
} else {
    $response['message'] = 'Failed to create users table: ' . mysqli_error($connect);
    echo json_encode($response);
    exit;
}

// ── Step 2: Check whether user "nar" already exists ──────────────────────────
$check_sql    = "SELECT user_id FROM users WHERE username = 'nar' LIMIT 1";
$check_result = mysqli_query($connect, $check_sql);

if ($check_result === false) {
    $response['message'] = 'Failed to query users table: ' . mysqli_error($connect);
    echo json_encode($response);
    exit;
}

if (mysqli_num_rows($check_result) > 0) {
    // User already exists — nothing to do
    $response['success'] = true;
    $response['steps'][] = 'user "nar" already exists — no changes made';
    $response['message'] = 'Admin user already exists';
    echo json_encode($response);
    exit;
}

// ── Step 3: Insert admin user "nar" ──────────────────────────────────────────
$hashed_password = password_hash('123456', PASSWORD_DEFAULT);
$insert_sql = "
    INSERT INTO users (username, password, fullname_en, fullname_lo, role, status, created_at)
    VALUES ('nar', '$hashed_password', 'Nar', 'ນາ', 'admin', 'active', NOW())
";

if (mysqli_query($connect, $insert_sql)) {
    $response['success'] = true;
    $response['steps'][] = 'user "nar" inserted with role "admin" and status "active"';
    $response['message'] = 'Admin user created successfully';
} else {
    $response['message'] = 'Failed to insert admin user: ' . mysqli_error($connect);
}

echo json_encode($response);
?>
