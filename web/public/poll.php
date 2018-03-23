<?php

require("common.php");

/*
 * /poll
 * Returns json:
 * if Successful:
 *     [{
 *       vehicleId: <string>,
 *       vehicleType: <string:boysBus,girlsBus,boysCab,girlsCab,generalCab>
 *       licenseNumber: <string>,
 *       lat: <string>,
 *       lon: <string>,
 *       lastUpdatedAt: <ISO 8601 datetime string>
 *     }]
 * else:
 * { "error": <string> }
 */

$conn = new mysqli($DBHOST,$DBUSER,$DBPWD,$DBNAME);

if ($conn->connect_errno)
{
    internalError($conn->connect_error);
}

$vehicles = [];
if($result = $conn->query("SELECT vehicleId, vehicleType, licenseNumber, lat, lon, lastUpdatedAt FROM vehicle_locations")) {
	while($row = $result->fetch_object()) {
		$vehicles[] = $row;
	}
	$result->close();
}
else {
    print_r("error");
}

mysqli_close($conn);
echo json_encode($vehicles);
