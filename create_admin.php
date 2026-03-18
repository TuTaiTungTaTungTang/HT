<?php
require_once __DIR__ . '/src/bootstrap.php';

// Create admin account with plaintext password
$adminEmail = 'admin@gmail.com';
$adminPassword = '123456';
$adminName = 'admin';

// Delete existing admin if exists
$deleteStatement = $PDO->prepare('DELETE FROM users WHERE user_email = :email AND role = :role');
$deleteStatement->execute(['email' => $adminEmail, 'role' => 'admin']);

// Create new admin account (plaintext password)
$insertStatement = $PDO->prepare('INSERT INTO users (user_name, user_email, user_psw, role) VALUES (:name, :email, :psw, :role)');
$insertStatement->execute([
    'name' => $adminName,
    'email' => $adminEmail,
    'psw' => $adminPassword,
    'role' => 'admin'
]);

echo "✅ Admin account created successfully!<br>";
echo "Email: <strong>admin@gmail.com</strong><br>";
echo "Password: <strong>123456</strong><br>";
echo "<br><a href='public/login.php'>Go to Login Page</a>";
?>
