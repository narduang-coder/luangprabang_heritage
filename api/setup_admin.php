<?php
// api/setup_admin.php
// One-time setup endpoint: creates the users table and seeds the initial admin user.
// Call this once after deployment to initialise the database.

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

include_once '../config/database.php';

$response = ['success' => false, 'steps' => [], 'message' => ''];

// ----------------------------------------------------------------
// Step 1: Create the users table if it does not already exist
// ----------------------------------------------------------------
$create_table_sql = "
    CREATE TABLE IF NOT EXISTS users (
        user_id     INT AUTO_INCREMENT PRIMARY KEY,
        username    VARCHAR(50)  UNIQUE NOT NULL,
        password    VARCHAR(255) NOT NULL,
        fullname_en VARCHAR(100) DEFAULT NULL,
        fullname_lo VARCHAR(100) DEFAULT NULL,
        email       VARCHAR(100) DEFAULT NULL,
        role        ENUM('admin', 'staff', 'viewer') DEFAULT 'viewer',
        status      ENUM('active', 'inactive')       DEFAULT 'active',
        created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
";

if (mysqli_query($connect, $create_table_sql)) {
    $response['steps'][] = 'users table created (or already exists)';
} else {
    $response['message'] = 'Failed to create users table: ' . mysqli_error($connect);
    echo json_encode($response);
    exit;
}

// ----------------------------------------------------------------
// Step 2: Check whether user "N" already exists
// ----------------------------------------------------------------
$check_sql    = "SELECT user_id FROM users WHERE username = 'N' LIMIT 1";
$check_result = mysqli_query($connect, $check_sql);

if (!$check_result) {
    $response['message'] = 'Failed to query users table: ' . mysqli_error($connect);
    echo json_encode($response);
    exit;
}

if (mysqli_num_rows($check_result) > 0) {
    // User already exists — nothing to insert
    $response['steps'][]  = 'User "N" already exists, skipping insert';
    $response['success']  = true;
    $response['message']  = 'Setup complete. User "N" already exists.';
    echo json_encode($response);
    exit;
}

// ----------------------------------------------------------------
// Step 3: Insert user "N" with hashed password "123456"
// ----------------------------------------------------------------
$hashed_password = password_hash('123456', PASSWORD_DEFAULT);

$insert_sql = "
    INSERT INTO users (username, password, fullname_en, fullname_lo, role, status, created_at)
    VALUES ('N', '$hashed_password', 'Admin User', 'ຜູ້ຈັດການລະບົບ', 'admin', 'active', NOW())
";

if (mysqli_query($connect, $insert_sql)) {
    $response['steps'][]  = 'User "N" inserted successfully';
    $response['success']  = true;
    $response['message']  = 'Setup complete. User "N" created with password "123456".';
} else {
    $response['message'] = 'Failed to insert user "N": ' . mysqli_error($connect);
}

echo json_encode($response);
?>
