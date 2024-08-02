<?php

function clearTwigCache($cacheDir) {
    $files = glob($cacheDir . '/*'); // Get all files in the cache directory
    foreach ($files as $file) {
        if (is_file($file)) {
            unlink($file); // Delete each file
        } elseif (is_dir($file)) {
            clearTwigCache($file); // Recursively clear subdirectories
            rmdir($file); // Delete the subdirectory
        }
    }
}

// Clear the Twig cache
clearTwigCache('cache/twig');
echo "Twig cache cleared.";

