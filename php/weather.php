<?php
// php/weather.php — server-side proxy to OpenWeather to keep API key private
header('Content-Type: application/json');
require_once __DIR__ . '/connection.php';
require_once __DIR__ . '/../config.php';

$lat = isset($_GET['lat']) ? floatval($_GET['lat']) : null;
$lon = isset($_GET['lon']) ? floatval($_GET['lon']) : null;
$units = ($_GET['units'] ?? 'imperial');
if ($lat===null || $lon===null) { echo json_encode(['ok'=>false,'error'=>'Missing coords']); exit; }

$api = $OPENWEATHER_API_KEY ?? null;
if (!$api) { echo json_encode(['ok'=>false,'error'=>'Missing API key']); exit; }

$u = $units==='metric' ? 'metric' : 'imperial';
$url = "https://api.openweathermap.org/data/2.5/weather?lat={$lat}&lon={$lon}&units={$u}&appid={$api}";

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
$resp = curl_exec($ch);
$err  = curl_error($ch);
$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($err || $code>=400) {
  echo json_encode(['ok'=>false,'error'=>'Upstream error']); exit;
}
$data = json_decode($resp, true);
echo json_encode(['ok'=>true,'data'=>['current'=>$data]]);
