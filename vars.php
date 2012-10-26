<?php

$query = "SELECT DISTINCT datarefpop.ReportDate, settlementpcode.pcode AS settlementPcode, countrypcode.pcode AS currentCountryPcode, ";
$query .= "datarefpop.origin, datarefpop.TotalRefPop_HH, datarefpop.TotalRefPop_I, ";
$query .= "datarefpop.DEM_04_M, datarefpop.DEM_04_F, datarefpop.DEM_511_M, datarefpop.DEM_511_F, datarefpop.DEM_1217_M, ";
$query .= "datarefpop.DEM_1217_F, datarefpop.DEM_1859_M, datarefpop.DEM_1859_F, datarefpop.DEM_60_M, datarefpop.DEM_60_F ";
$query .= "FROM datarefpop ";
$query .= "LEFT JOIN settlement ON datarefpop.Settlement = settlement.Id ";
$query .= "LEFT JOIN settlementpcode ON settlement.Id = settlementpcode.Id ";
$query .= "LEFT JOIN countrypcode ON settlement.Country = countrypcode.Id ";
$query .= "WHERE (settlement.SettlementName IS NOT NULL) ";
//$query .= "AND (datarefpop.TotalRefPop_HH != 0 AND datarefpop.DEM_04_M != 0) ";
$query .= "ORDER BY ReportDate";
//echo $query;

$ttlPrefixes = htmlspecialchars("prefix xsd: <http://www.w3.org/2001/XMLSchema#>") . "<br />";  
$ttlPrefixes .= htmlspecialchars("prefix dct: <http://purl.org/dc/terms/>") . "<br />";  
$ttlPrefixes .= htmlspecialchars("prefix rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>") . "<br />"; 
$ttlPrefixes .= htmlspecialchars("prefix rdfs: <http://www.w3.org/2000/01/rdf-schema#>") . "<br />"; 
$ttlPrefixes .= htmlspecialchars("prefix owl: <http://www.w3.org/2002/07/owl#>") . "<br />";
$ttlPrefixes .= htmlspecialchars("prefix skos: <http://www.w3.org/2004/02/skos/core#>") . "<br />"; 
$ttlPrefixes .= htmlspecialchars("prefix foaf: <http://xmlns.com/foaf/0.1/>") . "<br />";  
$ttlPrefixes .= htmlspecialchars("prefix hxl: <http://hxl.humanitarianresponse.info/ns/#>") . "<br /><br />"; 
    
$ttlContainerUri = htmlspecialchars("<http://hxl.humanitarianresponse.info/data/datacontainers/[%timeStamp%]>");
$ttlContainerHeader = htmlspecialchars("[%containerUri%] a hxl:DataContainer . ") . "<br />";
$ttlContainerHeader .= htmlspecialchars("[%containerUri%] hxl:aboutEmergency <http://hxl.humanitarianresponse.info/data/emergencies/demo1> . ") . "<br />";
$ttlContainerHeader .= htmlspecialchars("[%containerUri%] dc:date \"[%reportDate%]\"^^xsd:date . ") . "<br />";
$ttlContainerHeader .= htmlspecialchars("[%containerUri%] hxl:validOn \"[%validOn%]\" . ") . "<br />";
$ttlContainerHeader .= htmlspecialchars("[%containerUri%] hxl:reportCateogry <http://hxl.humanitarianresponse.info/data/reportcategories/humanitarian_profile> . ") . "<br />";
$ttlContainerHeader .= htmlspecialchars("[%containerUri%] hxl:reportedBy <http://hxl.humanitarianresponse.info/data/persons/[%reporter%]> . ") . "<br /><br />";
//echo $ttlContainerHeader;

$ttlSubject = htmlspecialchars("<http://hxl.humanitarianresponse.info/data/RefugeesAsylumSeekers/[%countryPCode%]/[%campPCode%]/[%originPCode%]/[%sex%]/[%age%]>");
//echo $ttlSubject;

$ttlSex = htmlspecialchars("[%subject%] hxl:SexCategory <http://hxl.humanitarianresponse.info/data/sexcategories/[%sex%]> . ") . "<br />";
$ttlAge = htmlspecialchars("[%subject%] hxl:AgeGroup <http://hxl.humanitarianresponse.info/data/agegroups/unhcr/[%age%]> . ") . "<br />";
$ttlPersonCount = htmlspecialchars("[%subject%] hxl:personCount \"[%personCount%]\"^^xsd:integer . ") . "<br />";
$ttlHouseholdCount = htmlspecialchars("[%subject%] hxl:householdCount \"[%householdCount%]\"^^xsd:integer . ") . "<br />";

$ttlPopDescription = htmlspecialchars("[%subject%] hxl:atLocation <http://hxl.humanitarianresponse.info/data/locations/apl/[%countryPCode%]/[%campPCode%]> . ") . "<br />";
$ttlPopDescription .= htmlspecialchars("[%subject%] rdf:type hxl:RefugeesAsylumSeekers . ") . "<br />";
$ttlPopDescription .= htmlspecialchars("[%ttlSex%]");
$ttlPopDescription .= htmlspecialchars("[%ttlAge%]");
$ttlPopDescription .= htmlspecialchars("[%subject%] hxl:nationality <http://hxl.humanitarianresponse.info/data/locations/admin/mli/MLI> . ") . "<br />"; // TODO: soft code it if necessary.
$ttlPopDescription .= htmlspecialchars("[%ttlPopCount%]");
$ttlPopDescription .= htmlspecialchars("[%ttlHouseholdCount%]");
$ttlPopDescription .= htmlspecialchars("[%subject%] hxl:source <http://hxl.humanitarianresponse.info/data/organisations/unhcr> . ") . "<br /><br />";
// no look up yet. can be implemented but may not be usefull if the data is not known in the triple store. $ttlPopDescription .= htmlspecialchars("[%subject%] hxl:method \"[%method%]\" .") . "<br /><br />";

//echo $ttlPopDescription;


?>