<?php
// php/me.php
session_start();
header('Content-Type: application/json');
if (!empty($_SESSION['user'])) {
  $u = $_SESSION['user'];
  echo json_encode(['ok'=>true,'user'=>['user_id'=>$u['user_id'],'full_name'=>$u['full_name'],'email'=>$u['email']]]);
} else {
  echo json_encode(['ok'=>true,'user'=>null]);
}
