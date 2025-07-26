<?php
// This is a dummy file to avoid connection errors during development
// Leave $pdo unset if DB is not required<?php
$host = 'host.docker.internal';
$dbname = 'project_db_pg';  
$user = 'user';      
$pass = 'password';   
$dsn = "pgsql:host=host.docker.internal;port=5112;dbname=project_db_pg";

try {
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (PDOException $e) {
    error_log("DB Connection Failed: " . $e->getMessage());
    die("Database connection failed.");
}
