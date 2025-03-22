<?php
// db.php - Database connection using PDO

$host = 'db';
$db   = 'restaurant_db'; 
$user = 'root';            
$pass = 'example';                
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, 
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       
    PDO::ATTR_EMULATE_PREPARES   => false,                  
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    // In production, log errors instead of displaying them
    exit('Database connection failed: ' . $e->getMessage());
}
?>
