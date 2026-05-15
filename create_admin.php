<?php

/**
 * Create Admin User Script
 * Run: php create_admin.php
 */

require_once __DIR__ . '/app/core/Env.php';
Env::load(__DIR__ . '/.env');

// Database config
$host = Env::get('DB_HOST', 'localhost');
$dbname = Env::get('DB_DATABASE', 'dtrans_rental');
$user = Env::get('DB_USERNAME', 'root');
$pass = Env::get('DB_PASSWORD', '');

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if admin already exists
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute(['admin2@dtransrental.com']);
    if ($stmt->fetch()) {
        echo "Admin user already exists.\n";
        exit;
    }

    // Create new admin
    $hashedPassword = password_hash('Admin@123', PASSWORD_BCRYPT);
    $stmt = $pdo->prepare("INSERT INTO users (full_name, username, email, password, role, email_verified_at) VALUES (?, ?, ?, ?, 'admin', NOW())");
    $stmt->execute(['Admin User 2', 'admin2', 'admin2@dtransrental.com', $hashedPassword]);

    echo "Admin user created successfully!\n";
    echo "Email: admin2@dtransrental.com\n";
    echo "Password: Admin@123\n";

} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage() . "\n";
}
