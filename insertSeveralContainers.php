<?php

include('inc/init.php');

ini_set('max_execution_time', 300);

$log = new Logging();
$log->file($logFile);

$mysqli = new mysqli($sourceConfig['db_host'], $sourceConfig['db_user_name'], $sourceConfig['db_password'], $sourceConfig['db_name']);

if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

if ($dbContent = $mysqli->query($mysqlQueryManyRows)) 
{
    $dropScript = '';
    while($row = mysqli_fetch_array($dbContent))
    {
    
        $containerInfo = extractRowData($row);
        $query = htmlspecialchars_decode($ttlPrefixes) . ' INSERT DATA { GRAPH ' . $containerInfo[0][0] . ' { ' . $containerInfo[1][0] . '}}';
        echo htmlspecialchars($query);
        sparqlLoad($query);
        
        $dropScript .= $containerInfo[2];
        echo htmlspecialchars('; ; ; ; ;' . $dropScript);
        // query drop emergency

        //$i++;
    }
    
    
   
    $fileHandle = fopen($curlDropFile, 'w') or die("can't open file");
    fwrite($fileHandle, $dropScript);
    fclose($fileHandle);

    
    //echo '<pre>';
   // print_r($dbContent);
    //echo '</pre>';
    
   //displayDropEmergencyContainers($dbContent);
    
    
}
else
{
    $log->write("Data base connection error: $mysqli->error");
$log->close();  
}






?>
