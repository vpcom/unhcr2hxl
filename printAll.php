
<?php

include_once('inc/init.php');

$log = new Logging();
$log->file($logFile);

$mysqli = new mysqli($sourceConfig['db_host'], $sourceConfig['db_user_name'], $sourceConfig['db_password'], $sourceConfig['db_name']);

if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

if ($dbContent = $mysqli->query($mysqlQueryAllPopulation)) 
{
    printContainers($dbContent);
}
else
{
    $log->write("Data base connection error: $mysqli->error");
}

$log->close();    

?>