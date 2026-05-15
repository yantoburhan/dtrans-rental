<?php

/**
 * Fix Admin Role Script
 * Run: php fix_admin_role.php
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

    // Update admin user role
    $stmt = $pdo->prepare("UPDATE users SET role = 'admin' WHERE email = ?");
    $stmt->execute(['admin2@dtransrental.com']);

    echo "Admin role updated successfully!\n";

    // Check current role
    $stmt = $pdo->prepare("SELECT role FROM users WHERE email = ?");
    $stmt->execute(['admin2@dtransrental.com']);
    $role = $stmt->fetchColumn();

    echo "Current role for admin2@dtransrental.com: " . $role . "\n";

} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage() . "\n";
}