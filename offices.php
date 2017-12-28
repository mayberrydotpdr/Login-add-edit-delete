<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ERROR);

/*
Allows the user to both create new records and edit existing records
*/

// connect to the database
include("connect-db.php");

// creates the new/edit record form
// since this form is used multiple times in this file, I have made it a function that is easily reusable
function renderForm($offices_name = '', $error = '', $id = '', $address = '', $city = '', $state = '', $zip = '', $phone_num = '', $fax_num = '', $contact = '', $hide = '')
{ 

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<title>
<?php 
if ($id !== '' && !isset($_GET['view'])) { 
echo "Edit Record"; 
} 
elseif(isset($_GET['view'])){
echo "View Record";
} else { 
echo "New Record"; 
} 
?>
</title>
<meta content="text/html; charset=utf-8"/>
</head>
<body>
<h1>

<?php 
if ($id !== '' && !isset($_GET['view'])) { 
echo "Edit Record"; 
} 
elseif(isset($_GET['view'])){
echo "View Record";
} else { 
echo "New Record"; 
} 
?>
	
</h1>

<?php 
	if ($error !== '') {
	echo "<div style='padding:4px; border:1px solid #000; color:red'>" . $error
	. "</div>";
} 
?>

<form action="" method="post">
<div>
<?php 
if ($id !== '') { 
?>
<input type="hidden" name="id" value="<?php echo $id; ?>" />
<p>OFFICE ID: <?php echo $id; ?></p><?php } ?>

<p>Office Name is required* </p>
<strong>Office Name: *</strong> <input type="text" name="offices_name"
value="<?php echo $offices_name; ?>"/><br/>

<strong>Address: </strong> <input type="text" name="address"
value="<?php echo $address; ?>"/><br/>

<strong>City: </strong> <input type="text" name="city"
value="<?php echo $city; ?>"/><br/>

<strong>State: </strong> <input type="text" name="state"
value="<?php echo $state; ?>"/><br/>

<strong>Zip: </strong> <input type="text" name="zip"
value="<?php echo $zip; ?>"/><br/>

<strong>Phone_Num: </strong> <input type="text" name="phone_num"
value="<?php echo $phone_num; ?>"/><br/>

<strong>Fax_Num: </strong> <input type="text" name="fax_num"
value="<?php echo $fax_num; ?>"/><br/>

<strong>Contact: </strong> <input type="text" name="contact"
value="<?php echo $contact; ?>"/><br/>

<?php
echo "<input type=hidden name=hide value=0>"; //first hidden of this field name set to 0
if($hide==0 or $hide==NULL) {
	$checked=""; //no value in mysql row
} else {
	$checked="checked";  //has value, check the box
	}
echo "<input type=checkbox name=hide value=1 ".$checked.">"; //html checkbox ?checked
echo "<input type=text value=Auxiliary_PO_box><br>";

// if view is in the URL do not show the Submit button
if (isset($_GET['view'])){
} else {
echo '<input type="submit" name="submit" value="Submit" />';
}
?>
</div>
</form>
</body>
</html>

<?php }



/*

EDIT RECORD

*/

// if the 'id' variable is set in the URL, we know that we need to edit a record
if (isset($_GET['id']))
{
// if the form's submit button is clicked, we need to process the form
if (isset($_POST['submit']))
{
// make sure the 'id' in the URL is valid
echo (var_dump($_POST));
if (is_numeric($_POST['id']))
{
// get variables from the URL/form
$id = $_POST['id'];
$office_name = htmlentities($_POST['offices_name'], ENT_QUOTES);
$address = htmlentities($_POST['address'], ENT_QUOTES);
$city = htmlentities($_POST['city'], ENT_QUOTES);
$state = htmlentities($_POST['state'], ENT_QUOTES);
$zip = htmlentities($_POST['zip'], ENT_QUOTES);
$phone_num = htmlentities($_POST['phone_num'], ENT_QUOTES);
$fax_num = htmlentities($_POST['fax_num'], ENT_QUOTES);
$contact = htmlentities($_POST['contact'], ENT_QUOTES);
$hide = htmlentities($_POST['hide'], ENT_QUOTES);

// check that office_name not empty
if ($office_name == '')
{
// if they are empty, show an error message and display the form
$error = 'ERROR: Please fill in all required fields!';
renderForm($office_name, $error, $id, $address, $city, $state, $zip, $phone_num, $fax_num, $contact, $hide);
}
else
{
// if everything is fine, update the record in the database
if ($stmt = $mysqli->prepare("UPDATE offices_table SET office_name = ?, Address = ?, City = ?, State = ?, Zip = ?, Phone_Num = ?, Fax_Num = ?, Contact = ?, Hide  = ? WHERE id=?"))
{
$stmt->bind_param("sssssssssi", $office_name, $address, $city, $state, $zip, $phone_num, $fax_num, $contact, $hide, $id);
$stmt->execute();
$stmt->close();
}
// show an error message if the query has an error
else
{
echo "ERROR: could not prepare SQL statement.";
}

// redirect the user once the form is updated
header("Location: view.php");
}
}
// if the 'id' variable is not valid, show an error message
else
{
echo "Error!";
}
}
// if the form hasn't been submitted yet, get the info from the database and show the form
else
{
// make sure the 'id' value is valid
if (is_numeric($_GET['id']) && $_GET['id'] > 0)
{
// get 'id' from URL
$id = $_GET['id'];

// get the recod from the database
if($stmt = $mysqli->prepare("SELECT * FROM offices_table WHERE id=?"))
{
$stmt->bind_param("i", $id);
$stmt->execute();

$stmt->bind_result($id, $office_name, $address, $city, $state, $zip, $phone_num, $fax_num, $contact, $hide);
$stmt->fetch();

// show the form
renderForm($office_name, NULL, $id, $address, $city, $state, $zip, $phone_num, $fax_num, $contact, $hide);

$stmt->close();
}
// show an error if the query has an error
else
{
echo "Error: could not prepare SQL statement";
}
}
// if the 'id' value is not valid, redirect the user back to the view.php page
else
{
header("Location: view.php");
}
}
}



/*

NEW RECORD

*/
// if the 'id' variable is not set in the URL, we must be creating a new record
else
{
// if the form's submit button is clicked, we need to process the form
if (isset($_POST['submit']))
{
// get the form data
$office_name = htmlentities($_POST['offices_name'], ENT_QUOTES);
$address = htmlentities($_POST['address'], ENT_QUOTES);
$city = htmlentities($_POST['city'], ENT_QUOTES);
$state = htmlentities($_POST['state'], ENT_QUOTES);
$zip = htmlentities($_POST['zip'], ENT_QUOTES);
$phone_num = htmlentities($_POST['phone_num'], ENT_QUOTES);
$fax_num = htmlentities($_POST['fax_num'], ENT_QUOTES);
$contact = htmlentities($_POST['contact'], ENT_QUOTES);
$hide = htmlentities($_POST['hide'], ENT_QUOTES);

// check that office_name not empty
if ($office_name == '')
{
// if they are empty, show an error message and display the form
$error = 'ERROR: Please fill in all required fields!';
renderForm($office_name, $error);
}
else
{
// insert the new record into the database
if ($stmt = $mysqli->prepare("INSERT offices_table (office_name, Address, City, State, Zip, Phone_Num, Fax_Num, Contact, Hide) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)"))
{
$stmt->bind_param("sssssssss", $office_name, $address, $city, $state, $zip, $phone_num, $fax_num, $contact, $hide);
$stmt->execute();
$stmt->close();
}
// show an error if the query has an error
else
{
echo "ERROR: Could not prepare SQL statement.";
}

// redirec the user
header("Location: view.php");
}

}
// if the form hasn't been submitted yet, show the form
else
{
renderForm();
}
}

// close the mysqli connection
$mysqli->close();
?>
