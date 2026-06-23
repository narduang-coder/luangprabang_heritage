<?php
/**
 * setup_user.php — One-time admin user setup script.
 *
 * THIS FILE IS TEMPORARY. Delete it after the first successful run.
 *
 * Credentials are read exclusively from Railway environment variables:
 *   ADMIN_USERNAME  — defaults to "nar"    if not set
 *   ADMIN_PASSWORD  — defaults to "123456" if not set
 *
 * Safe to call multiple times (idempotent): if the user already exists
 * the script reports that and exits without making any changes.
 */

header('Content-Type: application/json; charset=utf-8');

// ---------------------------------------------------------------------------
// 1. Read credentials from environment — never hardcoded.
// ---------------------------------------------------------------------------
$admin_username = getenv('ADMIN_USERNAME');
$admin_password = getenv('ADMIN_PASSWORD');

if ($admin_username === false || $admin_username === '') {
    $admin_username = 'nar';
}
if ($admin_password === false || $admin_password === '') {
    $admin_password = '123456';
}

// ---------------------------------------------------------------------------
// 2. Connect to the database using the shared config.
// ---------------------------------------------------------------------------
include_once __DIR__ . '/config/database.php';

// config/database.php already exits with a JSON error if the connection fails,
// but we guard here as well for clarity.
if (!$connect) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Database connection failed: ' . mysqli_connect_error(),
    ]);
    exit;
}

// ---------------------------------------------------------------------------
// 3. Create the users table if it does not already exist.
// ---------------------------------------------------------------------------
$create_table_sql = "
    CREATE TABLE IF NOT EXISTS users (
        user_id     INT AUTO_INCREMENT PRIMARY KEY,
        username    VARCHAR(50)  UNIQUE NOT NULL,
        password    VARCHAR(255) NOT NULL,
        fullname_lo VARCHAR(100),
        fullname_en VARCHAR(100),
        email       VARCHAR(100),
        role        ENUM('admin', 'staff', 'viewer') DEFAULT 'viewer',
        status      ENUM('active', 'inactive')       DEFAULT 'active',
        created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
";

if (!mysqli_query($connect, $create_table_sql)) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Failed to create users table: ' . mysqli_error($connect),
    ]);
    exit;
}

// ---------------------------------------------------------------------------
// 4. Check whether the user already exists.
// ---------------------------------------------------------------------------
$safe_username = mysqli_real_escape_string($connect, $admin_username);

$check = mysqli_query($connect, "SELECT user_id FROM users WHERE username = '$safe_username'");

if (!$check) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Query error: ' . mysqli_error($connect),
    ]);
    exit;
}

if (mysqli_num_rows($check) > 0) {
    // Idempotent: user already exists — nothing to do.
    echo json_encode([
        'success' => true,
        'message' => "User '$admin_username' already exists. No changes made.",
        'action'  => 'skipped',
    ]);
    exit;
}

// ---------------------------------------------------------------------------
// 5. Insert the new admin user with a bcrypt-hashed password.
// ---------------------------------------------------------------------------
$hashed_password = password_hash($admin_password, PASSWORD_DEFAULT);
$safe_hash       = mysqli_real_escape_string($connect, $hashed_password);

$insert_sql = "
    INSERT INTO users (username, password, fullname_lo, role, status, created_at)
    VALUES ('$safe_username', '$safe_hash', 'ຜູ້ຈັດການລະບົບ', 'admin', 'active', NOW())
";

if (!mysqli_query($connect, $insert_sql)) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Failed to insert user: ' . mysqli_error($connect),
    ]);
    exit;
}

// ---------------------------------------------------------------------------
// 6. Success — remind the operator to delete this file.
// ---------------------------------------------------------------------------
echo json_encode([
    'success'  => true,
    'message'  => "Admin user '$admin_username' created successfully.",
    'action'   => 'inserted',
    'reminder' => 'Delete setup_user.php from the server now that setup is complete.',
]);
?>
