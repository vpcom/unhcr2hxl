<form action="" method="get">
Delete a container: <input type="text" name="container" value="">
<input type="submit" value="Submit">
</form>

<?php

include('inc/init.php');

$log = new Logging();
$log->file($logFile);

if (!empty($_GET)) 
{
    /*$mysqli = new mysqli($sourceConfig['db_host'], $sourceConfig['db_user_name'], $sourceConfig['db_password'], $sourceConfig['db_name']);

    if ($mysqli->connect_error) {
        die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
    }

    if ($dbContent = $mysqli->query($mysqlQueryOneRow)) 
    {*/
        $query = ' DROP GRAPH <' . htmlspecialchars($_GET['container']) . '>'; 
        echo htmlspecialchars($query);
        sparqlLoad($query);
    /*}
    else
    {
        echo "Data base connection error: $mysqli->error";
    }
     * 
     */
}

?>
