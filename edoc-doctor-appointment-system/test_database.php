<?php
require_once(__DIR__ . '/connection.php');

echo "Database connection successful!\n";

// Check tables
$result = $database->query("SHOW TABLES");
if ($result) {
    echo "Tables in 'edoc' database:\n";
    while ($row = $result->fetch_array()) {
        echo "- " . $row[0] . "\n";
    }
}

$database->close();
?>