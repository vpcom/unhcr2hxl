<?php

/*******************************
 *
 *****************************/
function printContainers($dbContent)
{
    global $reporter, $ttlContainerHeader, $ttlContainerUri, $ttlPrefixes;

    global $log;
    $dateTime = new DateTime();
    $scriptDate = $dateTime->format('Y-m-d H:i:s');
    $timeStamp = microtime(true);

    $reporter = "unhcr";

    $log->write("----------------------------------------------------------------");
    $log->write("Number of rows: " . $dbContent->num_rows);
    $log->write("Number of count columns: 11");
    $log->write("General note: The default population type is hxl:RefugeesAsylumSeekers");
    $log->write("General warning: Unknow reporter IDs and absent or multiple sources in table datarefpop. The hxl:reportedBy is set to $reporter.");
    $log->write("General warning: No country pcode. Using temporary pcodes from the conversion table.");
    $log->write("General warning: No APL pcode. Using temporary pcodes from the conversion table.");
    $log->write("General warning: No origin pcode. Using temporary pcodes from the conversion table.");
    $log->write("General warning: No method reported.");

    $i = 0;
    $containerUriArray = array();
    $containerArray = array();
    while($row = mysqli_fetch_array($dbContent))
    {
        $stringData = '';
        $i++;

        $ttlContainerUri = str_replace("[%timeStamp%]", $timeStamp, $ttlContainerUri);
        array_push($containerUriArray, $ttlContainerUri);

        $stringData .= $ttlPrefixes;
        $stringData .= makeContainerHeader($row, $scriptDate, $ttlContainerUri, $reporter, $ttlContainerHeader);
        $stringData .= makeTtlFromRow($row);
        
        array_push($containerArray, $stringData);


        //if($i == 2) break;
        

/* If need to write in a file, reuse this code
    $fileHandle = fopen($ourFileName, 'w') or die("can't open file");
    fwrite($fileHandle, $stringData);

    fclose($fileHandle);
*/
			
     }	
     /* to print the list of container URIs and containers
    print_r("<pre>");
    print_r($containerUriArray);
    print_r("</pre>");
    print_r("<br />");
    print_r("<pre>");
    print_r($containerArray);
    print_r("</pre>");
      */
}

/*******************************
 *
 *****************************/
function makeContainerHeader($row, $scriptDate, $containerUri,  $reporter, $ttlContainerHeader)
{
    $ttlContainerHeader = str_replace("[%containerUri%]", $containerUri, $ttlContainerHeader);

    $ttlContainerHeader = str_replace("[%reportDate%]", $scriptDate, $ttlContainerHeader);
    $ttlContainerHeader = str_replace("[%reporter%]", $reporter, $ttlContainerHeader);
//	$ttlContainerHeader = str_replace("[%emergency%]", htmlspecialchars("<") . $emergency . htmlspecialchars(">"), $ttlContainerHeader);

    $tempTtlContainerHeader = $ttlContainerHeader;

    $tempTtlContainerHeader = str_replace("[%validOn%]", $row['ReportDate'], $tempTtlContainerHeader);
//$ttlSubject = htmlspecialchars("<http://hxl.humanitarianresponse.info/data/[%popTypePart%]/[%countryPCode%]/[%campPCode%]/[%originPCode%]/[%sex%]/[%age%]>");

    return $tempTtlContainerHeader;
}

/*******************************
 *
 *****************************/
function makeTtlFromRow($row)
{
    global $log;

    $stringData = '';
    /*
    $sex = "";
    $age = "";
    $stringData .= makeTtlPopDescriptiom($row, $sex, $age, $row['TotalRefPop_HH']);
    */


    if(countAvailable($row, $row['ReportDate']))
    {


	////////////////////
	$age = "ages_0-4";
	//$row['DEM_04_M']
	$sex = "male";
	$stringData .= makeTtlPopDescriptiom($row, $sex, $age, $row['DEM_04_M']);
	//$row['DEM_04_F']
	$sex = "female";
	$stringData .= makeTtlPopDescriptiom($row, $sex, $age, $row['DEM_04_F']);

	////////////////////
	$age = "ages_5-11";
	//$row['DEM_511_M']
	$sex = "male";
	$stringData .= makeTtlPopDescriptiom($row, $sex, $age, $row['DEM_511_M']);
	//$row['DEM_511_F']
	$sex = "female";
	$stringData .= makeTtlPopDescriptiom($row, $sex, $age, $row['DEM_511_F']);

	////////////////////
	$age = "ages_12-17";
	//$row['DEM_1217_M']
	$sex = "male";
	$stringData .= makeTtlPopDescriptiom($row, $sex, $age, $row['DEM_1217_M']);
	//$row['DEM_1217_F']
	$sex = "female";
	$stringData .= makeTtlPopDescriptiom($row, $sex, $age, $row['DEM_1217_F']);

	////////////////////
	$age = "ages_18-59";
	//$row['DEM_1859_M']
	$sex = "male";
	$stringData .= makeTtlPopDescriptiom($row, $sex, $age, $row['DEM_1859_M']);
	//$row['DEM_1859_F']
	$sex = "female";
	$stringData .= makeTtlPopDescriptiom($row, $sex, $age, $row['DEM_1859_F']);

	////////////////////
	$age = "ages_60";
	//$row['DEM_60_M']
	$sex = "male";
	$stringData .= makeTtlPopDescriptiom($row, $sex, $age, $row['DEM_60_M']);
	//$row['DEM_60_F']
	$sex = "female";
	$stringData .= makeTtlPopDescriptiom($row, $sex, $age, $row['DEM_60_F']);

    }

    return $stringData;
}

/*******************************
 *
 *****************************/
function makeTtlPopDescriptiom($row, $sex, $age, $popCount)
{
    global $log, $ttlPersonCount, $ttlHouseholdCount, $ttlPopDescription, $ttlSex, $ttlAge, $ttlSubject;

    $ttlSubject = str_replace("[%countryPCode%]", $row['currentCountryPcode'], $ttlSubject);
    $ttlSubject = str_replace("[%campPCode%]", $row['settlementPcode'], $ttlSubject);
    $ttlSubject = str_replace("[%originPCode%]", $row['origin'], $ttlSubject);

    $ttlSexTemp = $ttlSex;
    $ttlAgeTemp = $ttlAge;
    if (empty($sex) && empty($age))
    {
            $ttlSexTemp = "";
            $ttlAgeTemp = "";
    }
    else
    {
            $ttlSexTemp = str_replace("[%sex%]", $sex, $ttlSexTemp);
            $ttlAgeTemp = str_replace("[%age%]", $age, $ttlAgeTemp);		
    }

    $ttlPopDescriptionTemp = $ttlPopDescription;
    $ttlPopDescriptionTemp = str_replace("[%ttlSex%]", $ttlSexTemp, $ttlPopDescriptionTemp);
    $ttlPopDescriptionTemp = str_replace("[%ttlAge%]", $ttlAgeTemp, $ttlPopDescriptionTemp);

    $ttlSubjectTemp = $ttlSubject;
    $ttlSubjectTemp = str_replace("[%originPCode%]", $row['origin'], $ttlSubjectTemp);

    //$ttlSubjectTemp = $ttlSubject;
    $ttlSubjectTemp = str_replace("[%originPCode%]", $row['origin'], $ttlSubjectTemp);
    if (empty($sex) && empty($age))
    {
        $ttlSubjectTemp = str_replace("[%sex%]/[%age%]", "household", $ttlSubjectTemp);
        $ttlPersonCountTemp = "";
        $ttlHouseholdCountTemp = $ttlHouseholdCount;
        $ttlHouseholdCountTemp = str_replace("[%householdCount%]", $popCount, $ttlHouseholdCountTemp);
        $ttlPopDescriptionTemp = str_replace("[%ttlPopCount%]", $ttlPersonCountTemp, $ttlPopDescriptionTemp);
        $ttlPopDescriptionTemp = str_replace("[%ttlHouseholdCount%]", $ttlHouseholdCountTemp, $ttlPopDescriptionTemp);
    }
    else
    {
        $ttlSubjectTemp = str_replace("[%sex%]", $sex, $ttlSubjectTemp);
        $ttlSubjectTemp = str_replace("[%age%]", $age, $ttlSubjectTemp);
        $ttlHouseholdCountTemp = "";
        $ttlPersonCountTemp = $ttlPersonCount;
        $ttlPersonCountTemp = str_replace("[%personCount%]", $popCount, $ttlPersonCountTemp);
        $ttlPopDescriptionTemp = str_replace("[%ttlPopCount%]", $ttlPersonCountTemp, $ttlPopDescriptionTemp);
        $ttlPopDescriptionTemp = str_replace("[%ttlHouseholdCount%]", $ttlHouseholdCountTemp, $ttlPopDescriptionTemp);
    }


    $ttlPopDescriptionTemp = str_replace("[%countryPCode%]", $row['currentCountryPcode'], $ttlPopDescriptionTemp);
    $ttlPopDescriptionTemp = str_replace("[%countryPCode%]", $row['currentCountryPcode'], $ttlPopDescriptionTemp);
    $ttlPopDescriptionTemp = str_replace("[%campPCode%]", $row['settlementPcode'], $ttlPopDescriptionTemp);
    //$ttlPopDescriptionTemp = str_replace("[%popTypePart%]", $popTypePart, $ttlPopDescriptionTemp);
    //$ttlPopDescriptionTemp = str_replace("[%source%]", $row['source'], $ttlPopDescriptionTemp);
    // on hold // $ttlPopDescriptionTemp = str_replace("[%method%]", "undefined", $ttlPopDescriptionTemp);
    $ttlPopDescriptionTemp = str_replace("[%subject%]", $ttlSubjectTemp, $ttlPopDescriptionTemp);

    return $ttlPopDescriptionTemp;
}

/*******************************
 *
 *****************************/
function countAvailable($row, $reportDate)
{
    global $log;

    if (empty($row['DEM_04_M']) &
        empty($row['DEM_04_F']) &
        empty($row['DEM_511_M']) &
        empty($row['DEM_511_F']) &
        empty($row['DEM_1217_M']) &
        empty($row['DEM_1217_F']) &
        empty($row['DEM_1859_M']) &
        empty($row['DEM_1859_F']) &
        empty($row['DEM_60_M']) &
        empty($row['DEM_60_F']))
    {
        $log->write("Warning: Missing population counts at the date " . $reportDate);
        return false;
    }
    else
    {
        return true;
    }
}

/*******************************
 *
 *****************************/
function printResultArray($dbContent)
{

    $i = 0;
    printf("Select returned %d rows.<br /><br />\n", $dbContent->num_rows);
    printf("We retain 11 columns of distinct age/sex type. It makes a total of 11 columns * %d rows or containers = %d population counts and household counts all together.<br /><br />\n", $dbContent->num_rows, $dbContent->num_rows * 11);

    echo "<table><tr>";
    echo "<td>#</td>";
    echo "<td>ReportDate</td>";
    echo "<td>Set. pcode</td>";

    echo "<td>country. pcode</td>";
    echo "<td>origin</td>";
    echo "<td>Total HH</td>";
    echo "<td>Total I</td>";
    echo "<td>0-4 M</td>";
    echo "<td>0-4 F</td>";
    echo "<td>5-11 M</td>";
    echo "<td>5-11 F</td>";
    echo "<td>12-17 M</td>";
    echo "<td>12-17 F</td>";
    echo "<td>18-59 M</td>";
    echo "<td>18-59 F</td>";
    echo "<td>60 M</td>";
    echo "<td>60 F</td>";
    echo "</tr>";
    while($row = mysqli_fetch_array($dbContent)) {
        $i++;
        echo "<tr>";
        echo "<td>$i</td>";
        echo "<td>{$row['ReportDate']}</td>";
        echo "<td>{$row['settlementPcode']}</td>";
        echo "<td>{$row['currentCountryPcode']}</td>";
        echo "<td>{$row['origin']}</td>";
        echo "<td>{$row['TotalRefPop_HH']}</td>";
        echo "<td>{$row['TotalRefPop_I']}</td>";
        echo "<td>{$row['DEM_04_M']}</td>";
        echo "<td>{$row['DEM_04_F']}</td>";
        echo "<td>{$row['DEM_511_M']}</td>";
        echo "<td>{$row['DEM_511_F']}</td>";
        echo "<td>{$row['DEM_1217_M']}</td>";
        echo "<td>{$row['DEM_1217_F']}</td>";
        echo "<td>{$row['DEM_1859_M']}</td>";
        echo "<td>{$row['DEM_1859_F']}</td>";
        echo "<td>{$row['DEM_60_M']}</td>";
        echo "<td>{$row['DEM_60_F']}</td>";
        echo "</tr>";
    }
    echo "</table>";
     
    $dbContent->close();
}

?>