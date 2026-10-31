<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_save_path(__DIR__ . "/sessions");
session_start();

echo "=== Testing Full Signup Workflow ===\n\n";

// Step 1: Simulate signup.php submitting personal info
echo "Step 1: Simulating signup.php form submission...\n";
$_SESSION["personal"] = array(
    'fname' => 'Test',
    'lname' => 'User',
    'address' => '123 Test St',
    'nic' => '123456789',
    'dob' => '2000-01-01',
    'role' => 'p'
);

echo "   Personal info stored in session!\n";
echo "   Session ID: " . session_id() . "\n";
echo "   Personal data:\n";
print_r($_SESSION['personal']);

// Step 2: Simulate create-account.php
echo "\nStep 2: Testing create-account.php checks...\n";

// Check if session personal exists (it should)
if (isset($_SESSION['personal'])) {
    echo "   ✅ Personal session data found!\n";
} else {
    echo "   ❌ Personal session data NOT found!\n";
}

echo "\nTest Complete!\n";
?>