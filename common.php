<?php

$DBHOST="localhost";
$DBUSER="root";
$DBPWD="";
$DBNAME="bustracker_pilot";

function internalError($reason) {
    echo '{"error":"Internal server error"}';
    $logfile = fopen("error.log", "a");
    fwrite($logfile, "Error connecting to mysql server: '". $reason . "'\n");
    fclose($logfile);
	exit();
}

?>
