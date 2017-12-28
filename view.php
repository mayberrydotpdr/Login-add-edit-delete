<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<title>View Records</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>
<body>
<a href="index.php">Home<a>
<center>
<h1>Offices</h1>

<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ERROR);


// connect to the database
include('connect-db.php');

// get the records from the database
if ($result = $mysqli->query("SELECT * FROM offices_table ORDER BY office_name"))
{
// display records if there are records to display
if ($result->num_rows > 0)
{

// set select box
echo '<select multiple="" style="width:170px; height:400px; font-size: 14pt;">';

while ($row = $result->fetch_object())
{
// set up a row for each option
echo '<option id="'. $row->id .'">' . $row->office_name . '</option>';
}
echo "</select><br><br>";
}
// if there are no records in the database, display an alert message
else
{
echo "No results to display!";
}
}
// show an error if there is an issue with the database query
else
{
echo "Error: " . $mysqli->error;
}

// close database connection
$mysqli->close();

?>

<button onclick="edit()">Edit Office</button>
<button onclick="addOffice()">Add New Office</button>
<button onclick="deleteOffice()">Delete</button>
<button onclick="viewOffice()">View</button>
</center>
<script src="script.js"></script>
</body>
</html>
