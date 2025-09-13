<?php
// php/weather.php — current (OpenWeather) + hourly/daily (Open-Meteo)
header('Content-Type: application/json');
require_once __DIR__ . '/../config.php';

$lat   = isset($_GET['lat']) ? (float)$_GET['lat'] : null;
$lon   = isset($_GET['lon']) ? (float)$_GET['lon'] : null;
$units = ($_GET['units'] ?? 'imperial') === 'metric' ? 'metric' : 'imperial';
$inc   = isset($_GET['include']) ? explode(',', $_GET['include']) : ['current'];

if ($lat===null || $lon===null) { echo json_encode(['ok'=>false,'error'=>'Missing coords']); exit; }

$out = ['ok'=>true, 'data'=>[]];

/* ---- Current: OpenWeather ---- */
if (in_array('current', $inc)) {
  if (empty($OPENWEATHER_API_KEY)) { echo json_encode(['ok'=>false,'error'=>'Missing API key']); exit; }
  $u = $units==='metric' ? 'metric' : 'imperial';
  $cwUrl = "https://api.openweathermap.org/data/2.5/weather?lat={$lat}&lon={$lon}&units={$u}&appid={$OPENWEATHER_API_KEY}";
  $ch = curl_init($cwUrl);
  curl_setopt_array($ch, [CURLOPT_RETURNTRANSFER=>true, CURLOPT_TIMEOUT=>10]);
  $resp = curl_exec($ch); $code = curl_getinfo($ch, CURLINFO_HTTP_CODE); $err = curl_error($ch); curl_close($ch);
  if ($err || $code>=400) { echo json_encode(['ok'=>false,'error'=>'Upstream error (current)']); exit; }
  $out['data']['current'] = json_decode($resp, true);
}

/* ---- Hourly/Daily: Open-Meteo ---- */
if (in_array('hourly',$inc) || in_array('daily',$inc)) {
  $temp_unit = $units==='imperial' ? 'fahrenheit' : 'celsius';
  $speed_unit = $units==='imperial' ? 'mph' : 'ms'; // 'ms' = m/s
  $hourly = 'temperature_2m,weathercode';
  $daily  = 'temperature_2m_max,temperature_2m_min,weathercode';
  $omUrl = "https://api.open-meteo.com/v1/forecast?latitude={$lat}&longitude={$lon}"
         . "&hourly={$hourly}&daily={$daily}&temperature_unit={$temp_unit}"
         . "&windspeed_unit={$speed_unit}&timezone=auto";
  $om = @file_get_contents($omUrl);
  if ($om !== false) {
    $j = json_decode($om, true);
    // flatten to simple arrays
    $hours = [];
    if (!empty($j['hourly']['time'])) {
      $N = count($j['hourly']['time']);
      for ($i=0; $i<$N; $i++){
        $hours[] = [
          'time' => $j['hourly']['time'][$i],                 // e.g., 2025-04-20T15:00
          'temp' => $j['hourly']['temperature_2m'][$i] ?? null,
          'code' => $j['hourly']['weathercode'][$i] ?? null
        ];
      }
    }
    $days = [];
    if (!empty($j['daily']['time'])) {
      $M = count($j['daily']['time']);
      for ($k=0; $k<$M; $k++){
        $days[] = [
          'date' => $j['daily']['time'][$k],                  // e.g., 2025-04-20
          'tmax' => $j['daily']['temperature_2m_max'][$k] ?? null,
          'tmin' => $j['daily']['temperature_2m_min'][$k] ?? null,
          'code' => $j['daily']['weathercode'][$k] ?? null
        ];
      }
    }
    $out['data']['hourly'] = $hours;
    $out['data']['daily']  = $days;
  }
}

echo json_encode($out);
