<?php
declare(strict_types=1);

/**
 * Checks if the PostgreSQL database is accessible.
 */
function checkPgConnection(array $config): bool {
    try {
        $dsn = "pgsql:host={$config['pgHost']};port={$config['pgPort']};dbname={$config['pgDb']}";
        new PDO($dsn, $config['pgUser'], $config['pgPass'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ]);
        return true;
    } catch (PDOException $e) {
        return false;
    }
}