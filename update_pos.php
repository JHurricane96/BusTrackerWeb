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

mysqli_query($conn,"Update vehicle_locations set lat='$lat', lon='$lon', lastUpdatedAt='$now' where vehicleId=$vid;");

mysqli_close($conn);
echo "ok";
