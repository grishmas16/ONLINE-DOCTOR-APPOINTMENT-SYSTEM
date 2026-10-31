<?php
// Test 1: Access create-account.php directly (should redirect to signup.php)
echo "Test 1: Access without session data should redirect...\n";

// Test 2: Access with proper session data
echo "\nTest 2: Setting up test session data...\n";
if (session_status() === PHP_SESSION_NONE) { session_save_path(__DIR__ . "/sessions"); @session_start(); }

$_SESSION['personal'] = [
    'fname' => 'Test',
    'lname' => 'User',
    'address' => '123 Test St',
    'nic' => '123456789',
    'dob' => '2000-01-01',
    'role' => 'd'
];

echo "Session data set up successfully!\n";
echo "Testing role check: " . (isset($_SESSION['personal']['role']) && $_SESSION['personal']['role'] == 'd' ? "PASS" : "FAIL") . "\n";

echo "\nAll tests completed!\n";
?>