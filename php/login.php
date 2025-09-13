<?php
// php/login.php
session_start();
header('Content-Type: application/json');
require_once __DIR__ . '/connection.php';

$input = json_decode(file_get_contents('php://input'), true);
$email = trim($input['email'] ?? '');
$password = $input['password'] ?? '';

if ($email==='' || $password==='') {
  echo json_encode(['ok'=>false,'error'=>'Email and password required.']); exit;
}

try {
  $stmt = $pdo->prepare("SELECT user_id, full_name, email, pass_hash FROM users WHERE email=? LIMIT 1");
  $stmt->execute([$email]);
  $u = $stmt->fetch();
  if (!$u || !password_verify($password, $u['pass_hash'])) {
    echo json_encode(['ok'=>false,'error'=>'Invalid credentials.']); exit;
  }
  $_SESSION['user'] = ['user_id'=>$u['user_id'],'full_name'=>$u['full_name'],'email'=>$u['email']];
  echo json_encode(['ok'=>true]);
} catch (Throwable $e) {
  echo json_encode(['ok'=>false,'error'=>'Login failed.']);
}
