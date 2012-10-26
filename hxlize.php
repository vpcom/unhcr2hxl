
<?php

include_once('functions.php');
include_once('vars.php');
include('loggingClass.php');

$log = new Logging();
$log->file('unhcr2hxl_log.txt');

?>

<?php

$mysqli = new mysqli('localhost', 'root', '', 'unhcr');

if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') '
            . $mysqli->connect_error);
}
/*
// For retrocompatibility before 5.2.9
if (mysqli_connect_error()) {
    die('Connect Error (' . mysqli_connect_errno() . ') '
            . mysqli_connect_error());
}
*/

if ($dbContent = $mysqli->query($query)) 
{
	printContainers($dbContent);



}
else
{
	$log->write("Data base connection error: $mysqli->error");
}

$log->close();    

?>