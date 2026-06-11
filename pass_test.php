<?php
// test_password.php
// ໃຊ້ທົດສອບລະຫັດຜ່ານ

echo "<h1>ທົດສອບລະຫັດຜ່ານ</h1>";

$hash = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi';
$password = 'password';

echo "<h3>ທົດສອບລະຫັດຜ່ານ: 'password'</h3>";
if (password_verify($password, $hash)) {
    echo '<p style="color:green">✓ ລະຫັດຜ່ານ "password" ຖືກຕ້ອງ!</p>';
} else {
    echo '<p style="color:red">✗ ລະຫັດຜ່ານບໍ່ຖືກຕ້ອງ</p>';
}

echo "<h3>ທົດສອບລະຫັດຜ່ານອື່ນໆ:</h3>";
$test_passwords = ['123456', 'admin123', 'password123', 'admin'];
foreach ($test_passwords as $test) {
    if (password_verify($test, $hash)) {
        echo "<p style='color:green'>✓ ພົບ: " . $test . "</p>";
    }
}
?>