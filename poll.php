<?php

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

$conn = mysqli_connect("localhost","root","","bustracker_pilot");

if ($conn->connect_errno)
{
	echo '{"error":"Failed to connect to MySQL: "' . $conn->connect_error . '}';
	exit();
}

$vehicles = [];
if($result = mysqli_query($conn,"SELECT * FROM vehicle_locations")) {
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
