<?php
header('Content-Type: application/json');

// Use the shared DB connection code in this folder:
require_once __DIR__ . '/connection.php'; // <-- this is in php/connection.php

$ok = false;
$error = null;

try {
    // If connection.php creates $pdo, this light query proves DB connectivity.
    $pdo->query('SELECT 1');
    $ok = true;
} catch (Throwable $e) {
    $ok = false;
    $error = $e->getMessage();
}

echo json_encode([
    'ok'   => $ok,
    'time' => time(),
    // Comment-out the next line if you don't want to expose error details:
    'error' => $ok ? null : $error
]);
