<?php

require_once("../common.php");

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

$stmt=$conn->prepare("INSERT INTO vehicle_locations(vehicleId, vehicleType, licenseNumber, vehicleSecret) Values (?,?,?,?);");
if (!$stmt) {
    internalError($conn->connect_error);
}

$hash = password_hash($skt, PASSWORD_DEFAULT);
if(!$stmt->bind_param("ssss",$vid,$vtype,$licenseNumber, $hash)) {
    internalError($stmt->error);
}

if(!$stmt->execute()) {
    internalError($stmt->error);
}

mysqli_close($conn);
echo "ok";
