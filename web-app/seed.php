<?php
/**
 * Rex's Rents - Database Seeder
 * Use this script to reset and seed the database.
 * Run: php seed.php
 */

require_once 'config.php';

echo "--- REX'S RENTS DATABASE SEEDER ---\n";

try {
    // 1. Connect to MySQL (without selecting DB first to ensure we can create it)
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS);
    
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    echo "[1/3] Connected to MySQL...\n";

    // 2. Read the SQL file
    $sqlFile = 'database.sql';
    if (!file_exists($sqlFile)) {
        throw new Exception("SQL file not found: $sqlFile");
    }
    
    $sql = file_get_contents($sqlFile);
    echo "[2/3] Reading database.sql...\n";

    // 3. Execute Multi-Query
    // We use multi_query to handle the entire file at once
    if ($conn->multi_query($sql)) {
        do {
            // Process results
            if ($result = $conn->store_result()) {
                $result->free();
            }
        } while ($conn->more_results() && $conn->next_result());
        
        echo "[3/3] Seeding completed successfully!\n";
        echo "-----------------------------------\n";
        echo "Login: admin / admin123\n";
    } else {
        throw new Exception("Error executing SQL: " . $conn->error);
    }

    $conn->close();

} catch (Exception $e) {
    echo "FAILED: " . $e->getMessage() . "\n";
    exit(1);
}
?>
