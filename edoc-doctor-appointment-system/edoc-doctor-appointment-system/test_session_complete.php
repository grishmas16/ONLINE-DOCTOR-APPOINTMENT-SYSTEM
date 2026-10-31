<?php
$session_path = __DIR__ . "/sessions";

// Step 1: Set session
session_save_path(__DIR__ . "/sessions");
session_start();
$session_id = session_id();

$_SESSION['test_personal'] = array(
    'fname' => 'John',
    'lname' => 'Doe',
    'address' => '123 Main St',
    'nic' => '987654321',
    'dob' => '1990-01-01',
    'role' => 'p'
);

echo "Step 1 - Session set!\n";
echo "Session ID: $session_id\n";
echo "Session data:\n";
print_r($_SESSION['test_personal']);

// Step 2: Write and close session
session_write_close();
echo "\nSession written and closed.\n";

// Step 3: Reopen with same session ID
session_save_path(__DIR__ . "/sessions");
session_id($session_id);
session_start();

echo "\nStep 3 - Reopened session!\n";
echo "Session ID: " . session_id() . "\n";

if (isset($_SESSION['test_personal'])) {
    echo "\n✅ SUCCESS! Session data persisted!\n";
    echo "\nSession data:\n";
    print_r($_SESSION['test_personal']);
} else {
    echo "\n❌ ERROR: Session data NOT found!\n";
}
?>