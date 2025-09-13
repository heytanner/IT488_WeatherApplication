<?php
// php/register.php
session_start();
header('Content-Type: application/json');
require_once __DIR__ . '/connection.php';

$input = json_decode(file_get_contents('php://input'), true);
$full_name = trim($input['full_name'] ?? '');
$email = trim($input['email'] ?? '');
$password = $input['password'] ?? '';

if ($full_name==='' || $email==='' || $password==='') {
  echo json_encode(['ok'=>false,'error'=>'All fields are required.']); exit;
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  echo json_encode(['ok'=>false,'error'=>'Invalid email.']); exit;
}
if (strlen($password) < 6) {
  echo json_encode(['ok'=>false,'error'=>'Password too short.']); exit;
}

try {
  // ensure unique email
  $stmt = $pdo->prepare("SELECT user_id FROM users WHERE email=? LIMIT 1");
  $stmt->execute([$email]);
  if ($stmt->fetch()) { echo json_encode(['ok'=>false,'error'=>'Email already registered.']); exit; }

  $hash = password_hash($password, PASSWORD_DEFAULT);
  $stmt = $pdo->prepare("INSERT INTO users (full_name,email,pass_hash,created_at) VALUES (?,?,?,NOW())");
  $stmt->execute([$full_name,$email,$hash]);
  $uid = $pdo->lastInsertId();

  $_SESSION['user'] = ['user_id'=>$uid,'full_name'=>$full_name,'email'=>$email];
  echo json_encode(['ok'=>true]);
} catch (Throwable $e) {
  echo json_encode(['ok'=>false,'error'=>'Registration failed.']);
}
