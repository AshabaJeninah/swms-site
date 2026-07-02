<?php

function swms_load_env(string $path): void
{
    if (!is_file($path)) {
        return;
    }

    foreach (file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        $line = trim($line);
        if ($line === '' || str_starts_with($line, '#') || !str_contains($line, '=')) {
            continue;
        }
        [$key, $value] = array_map('trim', explode('=', $line, 2));
        $value = trim($value, "\"'");
        if (getenv($key) === false) {
            putenv("$key=$value");
        }
    }
}

swms_load_env(__DIR__ . '/../.env');

$host     = getenv('DB_HOST') ?: 'localhost';
$user     = getenv('DB_USER') ?: 'root';
$password = getenv('DB_PASSWORD') ?: '';
$database = getenv('DB_NAME') ?: 'swms_simple';
$port     = (int) (getenv('DB_PORT') ?: 3306);

$conn = @new mysqli($host, $user, $password, $database, $port);

if ($conn->connect_error) {
    error_log('SWMS database connection failed: ' . $conn->connect_error);
    http_response_code(500);
    die('Service temporarily unavailable. Please try again later.');
}

$conn->set_charset('utf8mb4');
