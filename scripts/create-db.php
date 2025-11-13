<?php

// Script untuk membuat database laundry
echo "=== Creating Database 'laundry' ===\n\n";

// Load .env file
if (file_exists(__DIR__ . '/../.env')) {
    $env = parse_ini_file(__DIR__ . '/../.env');
} else {
    echo "Error: .env file not found!\n";
    exit(1);
}

$host = $env['DB_HOST'] ?? '127.0.0.1';
$port = $env['DB_PORT'] ?? '3306';
$username = $env['DB_USERNAME'] ?? 'root';
$password = $env['DB_PASSWORD'] ?? '';

try {
    // Connect to MySQL without database
    $dsn = "mysql:host=$host;port=$port";
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Connected to MySQL server\n";
    
    // Create database
    $sql = "CREATE DATABASE IF NOT EXISTS laundry CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
    $pdo->exec($sql);
    
    echo "✓ Database 'laundry' created successfully!\n\n";
    echo "You can now run:\n";
    echo "  php artisan migrate\n";
    echo "  php artisan db:seed\n";
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n\n";
    echo "Please check:\n";
    echo "1. MySQL is running\n";
    echo "2. Username and password in .env are correct\n";
    echo "3. MySQL port is correct (default: 3306)\n";
    exit(1);
}
