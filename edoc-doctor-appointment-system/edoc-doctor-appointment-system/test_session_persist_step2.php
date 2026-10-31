<?php
session_save_path(__DIR__ . "/sessions");
session_id($_GET['sessid'] ?? '');
session_start();

echo "Session ID: " . session_id() . "\n";

if (isset($_SESSION['test_personal'])) {
    echo "SUCCESS! Session data persisted!\n";
    echo "\nSession data:\n";
    print_r($_SESSION['test_personal']);
} else {
    echo "ERROR: Session data NOT found!\n";
}
?>