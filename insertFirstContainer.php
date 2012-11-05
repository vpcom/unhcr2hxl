<?php

include('inc/init.php');

$log = new Logging();
$log->file($logFile);

$mysqli = new mysqli($sourceConfig['db_host'], $sourceConfig['db_user_name'], $sourceConfig['db_password'], $sourceConfig['db_name']);

if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

if ($dbContent = $mysqli->query($mysqlQueryOneRow)) 
{
    $containerInfo = giveFirstRow($dbContent);
    
    $query = htmlspecialchars_decode($ttlPrefixes) . ' INSERT DATA { GRAPH ' . $containerInfo[0][0] . ' { ' . $containerInfo[1][0] . '}}';
    
    //echo '<pre>';
   // print_r($dbContent);
    //echo '</pre>';
    echo htmlspecialchars($query);
    
    displayDropCurlCommand($containerInfo[0][0]);
    sparqlLoad($query);
    
    
}
else
{
    $log->write("Data base connection error: $mysqli->error");
$log->close();  
}






?>
