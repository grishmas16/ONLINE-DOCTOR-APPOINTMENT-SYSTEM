<?php
session_save_path(__DIR__ . "/sessions");
session_start();

include("connection.php");

$email = "karishma@123"; // your email
$password = "123"; // your password

echo "=== Testing login for $email ===" . "\n";

// Step 1: Check webuser
$stmt = $database->prepare("select * from webuser where email=?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows==1){
    echo "✅ Step 1: User found in webuser table!\n";
    $user = $result->fetch_assoc();
    $utype = $user['usertype'];
    echo "User type: $utype\n";

    if ($utype=='p'){
        echo "✅ Step 2: Checking patient table...\n";
        $stmt = $database->prepare("select * from patient where pemail=?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $checker = $stmt->get_result();
        if ($checker->num_rows==1){
            $row = $checker->fetch_assoc();
            $stored_password = $row['ppassword'];
            echo "Stored password hash: " . $stored_password . "\n";
            
            if (password_verify($password, $stored_password)) {
                echo "✅ Step 3: password_verify SUCCESS!\n";
            } elseif ($password == $stored_password) {
                echo "✅ Step 3: Plain text password match SUCCESS!\n";
            } else {
                echo "❌ Step 3: Password verification FAILED!\n";
                echo "   password_verify: " . (password_verify($password, $stored_password) ? 'true' : 'false') . "\n";
                echo "   Plain text match: " . ($password == $stored_password ? 'true' : 'false') . "\n";
            }
        }
    }
} else {
    echo "❌ Step 1: User NOT found in webuser table!\n";
}
?>