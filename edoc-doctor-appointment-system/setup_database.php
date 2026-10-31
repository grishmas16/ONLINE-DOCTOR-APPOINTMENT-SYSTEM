<?php
// Database connection without selecting a database first
$servername = "localhost";
$username = "root";
$password = "";

// Connect to MySQL server
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected to MySQL server successfully.\n";

// Create the edoc database
$sql = "CREATE DATABASE IF NOT EXISTS edoc";
if ($conn->query($sql) === TRUE) {
    echo "Database 'edoc' created or already exists.\n";
} else {
    die("Error creating database: " . $conn->error . "\n");
}

// Select the edoc database
$conn->select_db("edoc");
echo "Selected database 'edoc'.\n";

// Read and execute the SQL file
$sql_file = __DIR__ . "/SQL_Database_edoc.sql";
if (!file_exists($sql_file)) {
    die("Error: SQL file not found at $sql_file\n");
}

$sql_content = file_get_contents($sql_file);

// Execute multi query
if ($conn->multi_query($sql_content)) {
    do {
        // Store first result set
        if ($result = $conn->store_result()) {
            $result->free();
        }
    } while ($conn->more_results() && $conn->next_result());
    echo "All tables imported successfully!\n";
} else {
    die("Error importing SQL: " . $conn->error . "\n");
}

$conn->close();
echo "\nDatabase setup complete!\n";
?>