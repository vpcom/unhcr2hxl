<?php
session_start();

include('inc/init.php');

$log = new Logging();
$log->file($logFile);

$sliceSize = 100; // 100

        
if (array_key_exists("slice", $_GET))
{
    //echo $_GET["slice"];
    $slice = $_GET["slice"];
    
    
    $sparqlQueryArray = unserialize($_SESSION['sparqlQueryArray']);
    $splitCount = $_SESSION['splitCount'];
    
    $splittedQueryArray = array_chunk($sparqlQueryArray, $sliceSize);
    /*
        echo '<br />';
        echo $slice;
        echo '<br />';
        echo count($splittedQueryArray);
    */
    if (count($splittedQueryArray) != $slice)
    {
        echo "There are $splitCount chunks of database to parse.<br />";
        echo "Are you ready to proceed with the next slice?<br />";
        echo "<a href=?slice=" . (intval($slice) + 1.0) . ">Click here for the slice number " . (intval($slice) + 1.0) . "</a><br />";
        echo '<br />';
    }

    
/*
        echo "<br> splittedQueryArray: ";
    echo count($splittedQueryArray);
        echo " <br>";
    echo count($splittedQueryArray[0]);
*/
    
    $errorCount = 0;
    $successCount = 0;
    
    for($k = 0; $k < $sliceSize; $k++)
    {
        if (!array_key_exists($k, $splittedQueryArray[$slice -1])) break;
        
        //echo $splittedQueryArray[$slice -1][$k];

        //echo htmlspecialchars($query);
        
        if (!sparqlUpdate($splittedQueryArray[$slice -1][$k]))
        {
            $errorCount++;
        }
        else
        {
            $successCount++;
        }
    }
        echo "<br /><br />";
        echo "errorCount: ";
        echo $errorCount;
        echo "<br>";
        echo "successCount: ";
        echo $successCount;
        echo "<br>";
}
else
{

    $mysqli = new mysqli($sourceConfig['db_host'], $sourceConfig['db_user_name'], $sourceConfig['db_password'], $sourceConfig['db_name']);

    if ($mysqli->connect_error) {
        die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
    }

    if ($dbContent = $mysqli->query($mysqlQueryAllRows)) //$mysqlQueryAllRows // $mysqlQueryManyRows
    {
        $rowCount = $dbContent->num_rows;
        $splitCount = ceil($rowCount / $sliceSize);
        $_SESSION['splitCount'] = $splitCount;

        $dropScript = '';
        $sparqlQueryArray = array();
        
        while($row = mysqli_fetch_array($dbContent))
        {
            $containerInfo = extractRowData($row);
            $query = htmlspecialchars_decode($ttlPrefixes) . ' INSERT DATA { GRAPH <' . $containerInfo[0][0] . '> { ' . $containerInfo[1][0] . '}}';

            //echo htmlspecialchars($query);
            
            array_push($sparqlQueryArray, $query);

            $dropScript .= $containerInfo[2];

        }

        
        $_SESSION['sparqlQueryArray'] = serialize($sparqlQueryArray);

        $fileHandle = fopen($curlDropFile, 'w') or die("can't open file");
        fwrite($fileHandle, $dropScript);
        fclose($fileHandle);

        echo "There are $splitCount chunks of database to parse.<br />";
        echo "Are you ready to proceed with the first slice?<br />";
        echo "<a href=?slice=1>Click here</a><br />";
        echo '<br />';

    }
    else
    {
        $log->write("Data base connection error: $mysqli->error");
        $log->close();  
    }

}

?>
