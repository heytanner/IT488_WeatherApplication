<?php
// php/connection.php
// Copies config from config.php (create by copying config.php.sample)
require_once __DIR__ . '/../config.php';

try {
  $dsn = "mysql:host={$DB_HOST};dbname={$DB_NAME};charset=utf8mb4";
  $pdo = new PDO($dsn, $DB_USER, $DB_PASS, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
  ]);
} catch (Throwable $e) {
  http_response_code(500);
  header('Content-Type: application/json');
  echo json_encode(['ok'=>false,'error'=>'DB connection failed']);
  exit;
}
