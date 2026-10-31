<?php
session_save_path(__DIR__ . "/sessions");
session_start();

include("connection.php");

echo "=== Debug Login ===\n";
echo "\nChecking webuser table:\n";
$result = $database->query("select * from webuser");
while ($row = $result->fetch_assoc()) {
    echo "- " . $row['email'] . " (" . $row['usertype'] . ")\n";
}

echo "\nChecking admin table:\n";
$result = $database->query("select * from admin");
while ($row = $result->fetch_assoc()) {
    echo "- " . $row['aemail'] . " (password: " . $row['apassword'] . ")\n";
}

echo "\nChecking patient table:\n";
$result = $database->query("select * from patient");
while ($row = $result->fetch_assoc()) {
    echo "- " . $row['pemail'] . " (name: " . $row['pname'] . ", password: " . $row['ppassword'] . ")\n";
}

echo "\nChecking doctor table:\n";
$result = $database->query("select * from doctor");
while ($row = $result->fetch_assoc()) {
    echo "- " . $row['docemail'] . " (name: " . $row['docname'] . ", password: " . $row['docpassword'] . ")\n";
}
?>