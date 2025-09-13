<?php
// php/favorites.php
session_start();
header('Content-Type: application/json');
require_once __DIR__ . '/connection.php';

$user = $_SESSION['user'] ?? null;
$method = $_SERVER['REQUEST_METHOD'];
$action = $_GET['action'] ?? null;

if ($method === 'GET' && $action === 'list') {
  if (!$user) { echo json_encode(['ok'=>true,'items'=>[]]); exit; }
  $stmt = $pdo->prepare("SELECT location_id, location_name, lat, lon FROM favorites WHERE user_id=? ORDER BY location_id DESC");
  $stmt->execute([$user['user_id']]);
  echo json_encode(['ok'=>true,'items'=>$stmt->fetchAll()]); exit;
}

$input = json_decode(file_get_contents('php://input'), true);
$act = $input['action'] ?? $action;

if (!$user) { echo json_encode(['ok'=>false,'error'=>'Auth required']); exit; }

try {
  if ($act === 'add') {
    $name = trim($input['location_name'] ?? '');
    $lat = (float)($input['lat'] ?? 0);
    $lon = (float)($input['lon'] ?? 0);
    if ($name==='') $name = 'Unknown';
    $stmt = $pdo->prepare("INSERT INTO favorites (user_id, location_name, lat, lon, created_at) VALUES (?,?,?,?,NOW())");
    $stmt->execute([$user['user_id'],$name,$lat,$lon]);
    echo json_encode(['ok'=>true]); exit;
  }
  if ($act === 'remove') {
    $id = (int)($input['location_id'] ?? 0);
    $stmt = $pdo->prepare("DELETE FROM favorites WHERE location_id=? AND user_id=?");
    $stmt->execute([$id, $user['user_id']]);
    echo json_encode(['ok'=>true]); exit;
  }
  echo json_encode(['ok'=>false,'error'=>'Unknown action']);
} catch (Throwable $e) {
  echo json_encode(['ok'=>false,'error'=>'Favorites error']);
}
