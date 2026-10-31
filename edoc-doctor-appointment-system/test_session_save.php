<?php
session_save_path(__DIR__ . "/sessions");
session_start();

echo "Session save path: " . session_save_path(__DIR__ . "/sessions"). "\n";
echo "Is path writable? " . (is_writable(session_save_path(__DIR__ . "/sessions")) ? "YES" : "NO") . "\n";

$_SESSION['test'] = "Hello World!";
echo "Session ID: " . session_id() . "\n";
echo "Session data set!\n";

echo "\nNow checking session file...\n";
$session_file = session_save_path(__DIR__ . "/sessions"). "/sess_" . session_id();
echo "Session file: $session_file\n";
echo "Session file exists? " . (file_exists($session_file) ? "YES" : "NO") . "\n";

if (file_exists($session_file)) {
    echo "Session file content:\n";
    echo file_get_contents($session_file) . "\n";
}
?>