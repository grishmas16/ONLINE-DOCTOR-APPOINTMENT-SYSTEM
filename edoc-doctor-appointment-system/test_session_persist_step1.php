<?php
session_save_path(__DIR__ . "/sessions");
session_start();

$_SESSION['test_personal'] = array(
    'fname' => 'John',
    'lname' => 'Doe',
    'address' => '123 Main St',
    'nic' => '987654321',
    'dob' => '1990-01-01',
    'role' => 'p'
);

echo "Session ID: " . session_id() . "\n";
echo "Session data set successfully!\n";
echo "Now go to test_session_persist_step2.php to verify it persisted!\n";
echo "\nSession data:\n";
print_r($_SESSION['test_personal']);
?>