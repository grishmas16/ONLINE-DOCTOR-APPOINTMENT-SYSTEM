<?php
// Get all PHP files recursively
$files = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator(__DIR__),
    RecursiveIteratorIterator::SELF_FIRST
);

$count = 0;
foreach ($files as $file) {
    if ($file->isFile() && $file->getExtension() === 'php') {
        $content = file_get_contents($file->getPathname());
        
        // Find and replace any session_save_path with the correct one using __DIR__
        $new_content = preg_replace(
            '/session_save_path\(["\'][^"\']+["\']\)/',
            'session_save_path(__DIR__ . "/sessions")',
            $content
        );
        
        if ($new_content !== $content) {
            file_put_contents($file->getPathname(), $new_content);
            echo "Updated: " . $file->getPathname() . "\n";
            $count++;
        }
    }
}

echo "\nTotal files updated: $count\n";
?>