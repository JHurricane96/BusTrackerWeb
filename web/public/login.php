<?php

require_once("common.php");

/**
 * POST /login.php
 * data: { vehicleId: string, vehicleSecret: <string> }
 */

$vid = $_POST["vehicleId"];
$skt = $_POST["vehicleSecret"];

$conn = new mysqli($DBHOST,$DBUSER,$DBPWD,$DBNAME);

if ($conn->connect_errno)
{
    internalError($conn->connect_error);
}

$stmt=$conn->prepare("Select vehicleSecret from vehicle_locations where vehicleId=?;");
if (!$stmt) {
    internalError($conn->error);
}

if(!$stmt->bind_param("s",$vid)) {
    internalError($stmt->error);
}

if(!$stmt->execute()) {
    internalError($conn->error);
}

$hash = NULL;
if(!$stmt->bind_result($hash)) {
    internalError($stmt->error);
}

$stmt->fetch();

if(!password_verify($skt, $hash)) {
    echo '{error:"Invalid credentials"}';
    exit();
}

mysqli_close($conn);
echo "ok";
