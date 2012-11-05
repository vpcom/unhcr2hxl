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
    $query = ' DROP GRAPH <http://hxl.humanitarianresponse.info/data/datacontainers/777>'; 
    sparqlLoad($query);
  
}
else
{
    $log->write("Data base connection error: $mysqli->error");
}

$log->close();  

/*
function sparqlLoad()
{
    global $storeConfig, $log;
    
    $parameterString = "update=" . urlencode( $query );   
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_USERPWD, $storeConfig['store_username'] . ':' . $storeConfig['store_password']);
    curl_setopt($ch, CURLOPT_URL, $storeConfig['store_endpoint']);
    //curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/sparql-results+json'));
    //curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/sparql-results+xml,application/xml;q=0.8' ));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $parameterString);
 
    $response = curl_exec($ch);
    curl_close($ch);

    if ($response)
    {
        $log->write("Delete first container: success");
    }
    else
    {
        $log->write("Delete first container: FAILED");
    }

    print_r('<pre>');
    print_r($parameterString);
    print_r($response);
    print_r('</pre>');
   
}
*/
?>
