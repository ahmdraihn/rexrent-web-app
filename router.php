<?php
// Router script for PHP built-in server
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Static files
if ($uri === '/' || $uri === '/index.php') {
    require __DIR__ . '/index.php';
    return true;
}

if (file_exists(__DIR__ . $uri)) {
    if (is_dir(__DIR__ . $uri)) {
        $uri .= '/index.php';
    }
    
    if (file_exists(__DIR__ . $uri)) {
        require __DIR__ . $uri;
        return true;
    }
}

// Fallback to index.php
require __DIR__ . '/index.php';
return true;
?>
