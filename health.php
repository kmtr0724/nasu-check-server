<?php 
require 'vendor/autoload.php';
$json = file_get_contents('php://input');
$params = json_decode($json, true);
#print_r($params);
#echo "tmp=".$params[0]['fields']['temp'];
$temp = $params[0]['fields']['temp'];
$humid = $params[0]['fields']['humid'];
$pressure = $params[0]['fields']['pressure'];

$client = new InfluxDB\Client("127.0.0.1", 8086);
$database = $client->selectDB('nasu_health');
$points = array(
	new InfluxDB\Point(
		'nasu_thp', 
		null,
		[],
		['temp' => $temp, 'humid' => $humid, 'pressure' => $pressure] // measurement fields
	),
);
$result = $database->writePoints($points, InfluxDB\Database::PRECISION_SECONDS);
echo "OK";
