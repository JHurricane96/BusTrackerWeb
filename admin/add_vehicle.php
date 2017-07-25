<?php

require_once("common.php");

/**
 * POST /login.php
 * data: { vehicleId: string, vehicleSecret: <string> }
 *
 * | vehicleId | vehicleType | licenseNumber | lat       | lon       | lastUpdatedAt             | vehicleSecret
 */

$vid = $_POST["vehicleId"];
$vtype = $_POST["vehicleId"];
$skt = $_POST["vehicleSecret"];
$licenseNumber = $_POST["licenseNumber"];

$conn = new mysqli($DBHOST,$DBUSER,$DBPWD,$DBNAME);

if ($conn->connect_errno)
{
    internalError($conn->connect_error);
}

$stmt=$conn->prepare("INSERT INTO vehicle_locations(vechicleId, vehicleType, licenseNumber, vehicleSecret) Values (?,?,?,?);");
if (!$stmt) {
    internalError($conn->connect_error);
}

$stmt->bind_param("s",$vid);
$stmt->bind_param("s",$vtype);
$stmt->bind_param("s",$licenseNumber);
$stmt->bind_param("s",password_hash($vehicleSecret,PASSWORD_DEFAULT));

if($stmt->execute()) {
    internalError($conn->error);
}

mysqli_close($conn);
echo "ok";
