<?php

$server = "vaportrail.asoshared.com";
$user = "workmans_Jason";
$pass = "Password";
$db = "workmans_offices";

$mysqli = new mysqli($server, $user, $pass, $db);

// show errors (remove this line if on a live site)
mysqli_report(MYSQLI_REPORT_ERROR);
