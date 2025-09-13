<?php
// config.php.sample — copy to config.php and fill in values
$DB_HOST = 'localhost';
$DB_NAME = 'weatherloop';
$DB_USER = 'root';
$DB_PASS = 'Math0ss@!91L';

$OPENWEATHER_API_KEY = '939a7da16bb8d27ed82d418bbd0b961c';

$dsn = "mysql:host=$DB_HOST;dbname=$DB_NAME;charset=utf8mb4";
$options = [
  PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
  PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
  $pdo = new PDO($dsn, $DB_USER, $DB_PASS, $options);
} catch (Throwable $e) {
  http_response_code(500);
  header('Content-Type: application/json');
  echo json_encode(['ok'=>false,'error'=>'DB connection failed']);
  exit;
}