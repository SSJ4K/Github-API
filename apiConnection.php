<?php

$username = $argv[1];
$cacheDir = 'cache';
$cacheFile = $cacheDir."/{$username}.json"; // Different file name for different api calls
$expires = 3600; // 1 hour
$curlError = false;

// Check if directory exists if not make it
if (!is_dir($cacheDir)) {
    mkdir($cacheDir, 0755, true);
}

if (file_exists($cacheFile) && (time() - filemtime($cacheFile) < $expires)) {
    // Serve from cache
    $response = file_get_contents($cacheFile);
} else {
    // 1. Initialize cURL session
    $ch = curl_init();

    // 2. Set options
    curl_setopt($ch, CURLOPT_URL, "https://api.github.com/users/{$username}/events");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Returns the response as a string instead of outputting it directly
    curl_setopt($ch, CURLOPT_USERAGENT, 'SSJ4K'); // Github needs this to verify who is making the request
    // curl_setopt($curl, CURLOPT_FORBID_REUSE, TRUE);

    // 3. Execute and store response
    $response = curl_exec($ch);

    if (curl_error($ch)) {
        echo 'Error: '.curl_error($ch);
        $curlError = true;
    }

    file_put_contents($cacheFile, $response);
}
