<?php

require_once("common.php");

/**
 * POST /update_pos.php
 * data: { vehicleId: string, lat: <string>, lon: <string>, vehicleSecret: <string> }
 */

$vid = $_POST["vehicleId"];
$skt = $_POST["vehicleSecret"];
$lat = $_POST["lat"];
$lon = $_POST["lon"];
$now = date("c");

$conn = new mysqli($DBHOST,$DBUSER,$DBPWD,$DBNAME);

if ($conn->connect_errno)
{
    internalError($conn->connect_error);
}

$stmt=$conn->prepare("Update vehicle_locations set lat=?, lon=?, lastUpdatedAt=? where vehicleId=? and vehicleSecret=?;");
if (!$stmt) {
    internalError($conn->connect_error);
}

$stmt->bind_param("s",$lat);
$stmt->bind_param("s",$lon);
$stmt->bind_param("s",$now);
$stmt->bind_param("s",$vid);
$stmt->bind_param("s",password_hash($vehicleSecret,PASSWORD_DEFAULT));

$stmt->execute();

mysqli_close($conn);
echo "ok";
