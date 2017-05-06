<?php

/**
 * POST /update_pos.php
 * data: { vehicleId: string, lat: <string>, lon: <string> }
 */

$vid = $_POST["vehicleId"];
$lat = $_POST["lat"];
$lon = $_POST["lon"];
$now = date("c");

$conn = mysqli_connect("localhost","root","","bustracker_pilot");

if ($conn->connect_errno)
{
	echo '{"error":"Failed to connect to MySQL: \"' . $conn->connect_error . '\""}';
	exit();
}

$stmt = mysqli_prepare($conn,"Update vehicle_locations set lat=?, lon=?, lastUpdatedAt=? where vehicleId=?");
mysqli_stmt_bind_param($stmt, 'ssss', $lat, $lon, $now, $vid);
mysqli_stmt_execute($stmt);

mysqli_close($conn);
echo "ok";
