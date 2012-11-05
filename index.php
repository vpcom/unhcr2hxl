
<?php
// PHP 5.2.9 minimum

include_once('inc/init.php');

$log = new Logging();
$log->file($logFile);

echo "<h1>UNHCR db to HXL</h1>";
echo "<h2>Print</h2>";
echo "<a href=\"printAll.php\" >Print containers and their URIs</a>.<br /><br />";
echo "<h2>Load</h2>";
echo "<a href=\"insertFirstContainer.php\" >Insert the first container to the triple store</a>.<br /><br />";
echo "<a href=\"insertSeveralContainers.php\" >Insert several data containers</a>.<br /><br />";
echo "<a href=\"insertAllContainers.php\" >Insert containers per 100</a>.<br /><br />";
echo "<h2>Delete</h2>";
echo "<a href=\"deleteAContainer.php\" >Delete a container</a>.<br /><br />";
echo "<a href=\"deleteAllContainersFromEmergency.php\" >Delete containers from an emergency</a>.<br /><br />";
echo "<br />";
echo "<br />";
echo "<br />";

if (!function_exists('curl_init'))
{
    $log->write("CURL is not installed!");
    $log->close();  
    die('CURL is not installed!');
}


?>