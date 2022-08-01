<?php
header('Access-Control-Allow-Origin: *');
$array = [];
foreach ($dates as $date) {
  $array[] = substr($date, 0, 16);
}
echo json_encode($array, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
