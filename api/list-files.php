<?php

$baseDir = '/opt/cpanel/ea-php82/root/usr/share/pear';

// Get requested directory from URL parameter safely
$dir = isset($_GET['dir']) ? realpath($baseDir . '/' . $_GET['dir']) : $baseDir;

// Security check: Ensure requested path is within base directory
if (strpos($dir, $baseDir) !== 0 || !is_dir($dir)) {
    die("Invalid directory path.");
}

$files = scandir($dir);

// Helper function to create relative path for URLs
function relativePath($path, $baseDir) {
    return ltrim(str_replace($baseDir, '', $path), '/');
}

echo "<h2>Contents of folder: " . htmlspecialchars($dir) . "</h2><ul>";

// Link to parent directory
if ($dir !== $baseDir) {
    $parentDir = dirname(relativePath($dir, $baseDir));
    echo '<li><a href="?dir=' . urlencode($parentDir) . '">[..]</a></li>';
}

foreach ($files as $file) {
    if ($file !== '.' && $file !== '..') {
        $filePath = $dir . '/' . $file;
        $relPath = relativePath($filePath, $baseDir);

        if (is_dir($filePath)) {
            echo '<li>[Folder] <a href="?dir=' . urlencode($relPath) . '">' . htmlspecialchars($file) . '</a></li>';
        } else {
            echo '<li>' . htmlspecialchars($file) . '</li>';
        }
    }
}

echo "</ul>";