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

$stmt=$conn->prepare("Select count(*) from vehicle_locations where vehicleId=? and vehicleSecret=?;");
if (!$stmt) {
    internalError($conn->connect_error);
}

$stmt->bind_param("s",$vid);
$stmt->bind_param("s",password_hash($vehicleSecret,PASSWORD_DEFAULT));

if($stmt->execute()) {
    internalError($conn->error);
}

$count = NULL;
if(!$stmt->bind_result($count)) {
    internalError($stmt->error);
}

$stmt->fetch();

if($count != 1) {
    echo '{error:"Invalid credentials"}';
    exit();
}

mysqli_close($conn);
echo "ok";
