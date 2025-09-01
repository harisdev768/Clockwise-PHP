<?php
 
namespace App\Config;
 
use PDO;
use PDOException;
 
class DB {
    public static function getConnection(): PDO {
        $host = 'dev-usmank-mysql-db.capu4w8cgzz7.us-east-1.rds.amazonaws.com';       
        $port = '3306';
        $dbname = 'clockwise';
        $username = 'clockwiseuser';
        $password = 'clockwise123';
 
        try {
            $dsn = "mysql:host={$host};port={$port};dbname={$dbname};charset=utf8mb4";
            $pdo = new PDO($dsn, $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }
}