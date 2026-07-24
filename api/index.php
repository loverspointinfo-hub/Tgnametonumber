<?php

header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");

$username = $_GET['username'] ?? '';

if ($username == '') {
    echo json_encode([
        "status" => false,
        "message" => "Username parameter is required."
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    exit;
}

$url = "https://tgusertonum.suryajasoos.workers.dev/?username=" . urlencode($username);

$response = file_get_contents($url);

if ($response === false) {
    echo json_encode([
        "status" => false,
        "message" => "Unable to fetch API."
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    exit;
}

$data = json_decode($response, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    // If upstream doesn't return valid JSON, return it as-is.
    echo $response;
    exit;
}

// Remove unwanted fields
unset($data['owner']);
unset($data['note']);

// Output raw JSON
echo json_encode(
    $data,
    JSON_UNESCAPED_UNICODE |
    JSON_UNESCAPED_SLASHES |
    JSON_PRETTY_PRINT
);

?>