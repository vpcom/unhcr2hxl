<form action="" method="get">
Delete containers from an emergency: <input type="text" name="emergency" value="">
<input type="submit" value="Submit">
</form>

<?php

include('inc/init.php');

$log = new Logging();
$log->file($logFile);

if (!empty($_GET)) 
{
    $query= "PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
    PREFIX hxl: <http://hxl.humanitarianresponse.info/ns/#>

    SELECT DISTINCT ?graph WHERE {
    ?graph hxl:aboutEmergency <" . $_GET['emergency'] . "> .
    ?graph hxl:aboutEmergency <" . $_GET['emergency'] . "> .
    }";

    $queryResult = getQueryResults($query);

    if ($queryResult->num_rows() == 0) echo 'no result';
    else 
    {
        $return = '';
        // To extract coordinates from the polygon string.
        while( $row = $queryResult->fetch_array() )
        {  
            $query = ' DROP GRAPH <' . htmlspecialchars($row["graph"]) . '>'; 
            echo htmlspecialchars($query);
            sparqlUpdate($query);
        } 
    }
}

?>
