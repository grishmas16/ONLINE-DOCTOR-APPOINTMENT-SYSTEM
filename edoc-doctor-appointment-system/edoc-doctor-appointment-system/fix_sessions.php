<?php
$old_path = "C:\xampp\htdocs\edoc-doctor-appointment-system\edoc-doctor-appointment-system/sessions";
$new_path = __DIR__ . "/sessions";

// Get all PHP files recursively
$files = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator(__DIR__),
    RecursiveIteratorIterator::SELF_FIRST
);

$count = 0;
foreach ($files as $file) {
    if ($file->isFile() && $file->getExtension() === 'php') {
        $content = file_get_contents($file->getPathname());
        if (strpos($content, $old_path) !== false) {
            $new_content = str_replace($old_path, $new_path, $content);
            file_put_contents($file->getPathname(), $new_content);
            echo "Updated: " . $file->getPathname() . "\n";
            $count++;
        }
    }
}

echo "\nTotal files updated: $count\n";
?>