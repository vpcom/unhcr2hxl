<?php

$sourceConfigFile = '../etl_source.ini';
$storeConfigFile = '../etl_store.ini';
$logFile = 'unhcr2hxl.log';
$curlDropFile = 'curlDropGraph.txt';

$reporter = 'unhcr';
$defaultPopulationType = 'RefugeesAsylumSeekers';

$storeConfig = parse_ini_file($storeConfigFile); 
$sourceConfig = parse_ini_file($sourceConfigFile); 
$currentEmergency = 'http://hxl.humanitarianresponse.info/data/emergencies/mali2012test';
// TODO: .
// nationality mali
// source unhcr

$mysqlQueryAllPopulation = "SELECT DISTINCT datarefpop.ReportDate, settlementpcode.pcode AS settlementPcode, countrypcode.pcode AS currentCountryPcode, ";
$mysqlQueryAllPopulation .= "datarefpop.origin, datarefpop.TotalRefPop_HH, datarefpop.TotalRefPop_I, ";
$mysqlQueryAllPopulation .= "datarefpop.DEM_04_M, datarefpop.DEM_04_F, datarefpop.DEM_511_M, datarefpop.DEM_511_F, datarefpop.DEM_1217_M, ";
$mysqlQueryAllPopulation .= "datarefpop.DEM_1217_F, datarefpop.DEM_1859_M, datarefpop.DEM_1859_F, datarefpop.DEM_60_M, datarefpop.DEM_60_F ";
$mysqlQueryAllPopulation .= "FROM datarefpop ";
$mysqlQueryAllPopulation .= "LEFT JOIN settlement ON datarefpop.Settlement = settlement.Id ";
$mysqlQueryAllPopulation .= "LEFT JOIN settlementpcode ON settlement.Id = settlementpcode.Id ";
$mysqlQueryAllPopulation .= "LEFT JOIN countrypcode ON settlement.Country = countrypcode.Id ";
$mysqlQueryAllPopulation .= "WHERE (settlement.SettlementName IS NOT NULL) ";
$mysqlQueryAllPopulation .= "ORDER BY ReportDate";
//echo $mysqlQueryAllPopulation;

$mysqlQueryOneRow = "SELECT DISTINCT datarefpop.ReportDate, settlementpcode.pcode AS settlementPcode, countrypcode.pcode AS currentCountryPcode, ";
$mysqlQueryOneRow .= "datarefpop.origin, datarefpop.TotalRefPop_HH, datarefpop.TotalRefPop_I, ";
$mysqlQueryOneRow .= "datarefpop.DEM_04_M, datarefpop.DEM_04_F, datarefpop.DEM_511_M, datarefpop.DEM_511_F, datarefpop.DEM_1217_M, ";
$mysqlQueryOneRow .= "datarefpop.DEM_1217_F, datarefpop.DEM_1859_M, datarefpop.DEM_1859_F, datarefpop.DEM_60_M, datarefpop.DEM_60_F ";
$mysqlQueryOneRow .= "FROM datarefpop ";
$mysqlQueryOneRow .= "LEFT JOIN settlement ON datarefpop.Settlement = settlement.Id ";
$mysqlQueryOneRow .= "LEFT JOIN settlementpcode ON settlement.Id = settlementpcode.Id ";
$mysqlQueryOneRow .= "LEFT JOIN countrypcode ON settlement.Country = countrypcode.Id ";
$mysqlQueryOneRow .= "WHERE (settlement.SettlementName IS NOT NULL) ";
$mysqlQueryOneRow .= "ORDER BY ReportDate ";
$mysqlQueryOneRow .= "LIMIT 1";

$mysqlQueryCountRows = "SELECT COUNT(*) FROM datarefpop ";

$mysqlQueryManyRows = "SELECT DISTINCT datarefpop.ReportDate, settlementpcode.pcode AS settlementPcode, countrypcode.pcode AS currentCountryPcode,
datarefpop.origin, datarefpop.TotalRefPop_HH, datarefpop.TotalRefPop_I, 
datarefpop.DEM_04_M, datarefpop.DEM_04_F, datarefpop.DEM_511_M, datarefpop.DEM_511_F, datarefpop.DEM_1217_M, 
datarefpop.DEM_1217_F, datarefpop.DEM_1859_M, datarefpop.DEM_1859_F, datarefpop.DEM_60_M, datarefpop.DEM_60_F 
FROM datarefpop 
LEFT JOIN settlement ON datarefpop.Settlement = settlement.Id 
LEFT JOIN settlementpcode ON settlement.Id = settlementpcode.Id 
LEFT JOIN countrypcode ON settlement.Country = countrypcode.Id 
WHERE (settlement.SettlementName IS NOT NULL) 
ORDER BY ReportDate DESC 
LIMIT 10";//

$mysqlQueryAllRows = "SELECT DISTINCT datarefpop.ReportDate, settlementpcode.pcode AS settlementPcode, countrypcode.pcode AS currentCountryPcode,
datarefpop.origin, datarefpop.TotalRefPop_HH, datarefpop.TotalRefPop_I, 
datarefpop.DEM_04_M, datarefpop.DEM_04_F, datarefpop.DEM_511_M, datarefpop.DEM_511_F, datarefpop.DEM_1217_M, 
datarefpop.DEM_1217_F, datarefpop.DEM_1859_M, datarefpop.DEM_1859_F, datarefpop.DEM_60_M, datarefpop.DEM_60_F 
FROM datarefpop 
LEFT JOIN settlement ON datarefpop.Settlement = settlement.Id 
LEFT JOIN settlementpcode ON settlement.Id = settlementpcode.Id 
LEFT JOIN countrypcode ON settlement.Country = countrypcode.Id 
WHERE (settlement.SettlementName IS NOT NULL) 
ORDER BY ReportDate";//

/*
$ttlPrefixes = htmlspecialchars("@prefix xsd: <http://www.w3.org/2001/XMLSchema#> . ") . "<br />";  
$ttlPrefixes .= htmlspecialchars("@prefix dct: <http://purl.org/dc/terms/> . ") . "<br />";  
$ttlPrefixes .= htmlspecialchars("@prefix dc: <http://purl.org/dc/elements/1.1/> . ") . "<br />";  
$ttlPrefixes .= htmlspecialchars("@prefix rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#> . ") . "<br />"; 
$ttlPrefixes .= htmlspecialchars("@prefix rdfs: <http://www.w3.org/2000/01/rdf-schema#> . ") . "<br />"; 
$ttlPrefixes .= htmlspecialchars("@prefix owl: <http://www.w3.org/2002/07/owl#> . ") . "<br />";
$ttlPrefixes .= htmlspecialchars("@prefix skos: <http://www.w3.org/2004/02/skos/core#> . ") . "<br />"; 
$ttlPrefixes .= htmlspecialchars("@prefix foaf: <http://xmlns.com/foaf/0.1/> . ") . "<br />";  
$ttlPrefixes .= htmlspecialchars("@prefix hxl: <http://hxl.humanitarianresponse.info/ns/#> . ") . "<br /><br />"; 
*/

$ttlPrefixes = "prefix xsd: <http://www.w3.org/2001/XMLSchema#>
prefix dct: <http://purl.org/dc/terms/>  
prefix dc: <http://purl.org/dc/elements/1.1/> 
prefix rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#> 
prefix rdfs: <http://www.w3.org/2000/01/rdf-schema#> 
prefix owl: <http://www.w3.org/2002/07/owl#>
prefix skos: <http://www.w3.org/2004/02/skos/core#>
prefix foaf: <http://xmlns.com/foaf/0.1/>  
prefix hxl: <http://hxl.humanitarianresponse.info/ns/#>"; 

$ttlContainerUri = "http://hxl.humanitarianresponse.info/data/datacontainers/[%timeStamp%]";
$ttlContainerHeader = "<[%containerUri%]> a hxl:DataContainer . 
<[%containerUri%]> hxl:aboutEmergency <[%currentEmergency%]> . 
<[%containerUri%]> dc:date \"[%reportDate%]\"^^xsd:date . 
<[%containerUri%]> hxl:validOn \"[%validOn%]\" . 
<[%containerUri%]> hxl:reportCateogry <http://hxl.humanitarianresponse.info/data/reportcategories/humanitarian_profile> . 
<[%containerUri%]> hxl:reportedBy <http://hxl.humanitarianresponse.info/data/persons/[%reporter%]> . ";
//echo $ttlContainerHeader;

$ttlSubject = "<http://hxl.humanitarianresponse.info/data/[%populationType%]/[%countryPCode%]/[%campPCode%]/[%originPCode%]/[%sex%]/[%age%]>";
$ttlSex = "[%subject%] hxl:SexCategory <http://hxl.humanitarianresponse.info/data/sexcategories/[%sex%]> . ";
$ttlAge = "[%subject%] hxl:AgeGroup <http://hxl.humanitarianresponse.info/data/agegroups/unhcr/[%age%]> . ";
$ttlPersonCount = "[%subject%] hxl:personCount \"[%personCount%]\"^^xsd:integer . ";
$ttlHouseholdCount = "[%subject%] hxl:householdCount \"[%householdCount%]\"^^xsd:integer . ";

/*
$ttlPopDescription = htmlspecialchars("[%subject%] hxl:atLocation <http://hxl.humanitarianresponse.info/data/locations/apl/[%countryPCode%]/[%campPCode%]> . ") . "<br />";
$ttlPopDescription .= htmlspecialchars("[%subject%] rdf:type hxl:RefugeesAsylumSeekers . ") . "<br />";
$ttlPopDescription .= htmlspecialchars("[%ttlSex%]");
$ttlPopDescription .= htmlspecialchars("[%ttlAge%]");
$ttlPopDescription .= htmlspecialchars("[%subject%] hxl:nationality <http://hxl.humanitarianresponse.info/data/locations/admin/mli/MLI> . ") . "<br />"; // TODO: soft code it if necessary.
$ttlPopDescription .= htmlspecialchars("[%ttlPopCount%]");
$ttlPopDescription .= htmlspecialchars("[%ttlHouseholdCount%]");
$ttlPopDescription .= htmlspecialchars("[%subject%] hxl:source <http://hxl.humanitarianresponse.info/data/organisations/unhcr> . ") . "<br /><br />";
*/

$ttlPopDescription = "[%subject%] hxl:atLocation <http://hxl.humanitarianresponse.info/data/locations/apl/[%countryPCode%]/[%campPCode%]> . 
[%subject%] rdf:type hxl:RefugeesAsylumSeekers .
[%ttlSex%]
[%ttlAge%]
[%subject%] hxl:nationality <http://hxl.humanitarianresponse.info/data/locations/admin/mli/MLI> . 
[%ttlPopCount%]
[%ttlHouseholdCount%]
[%subject%] hxl:source <http://hxl.humanitarianresponse.info/data/organisations/unhcr> . ";

// no look up yet. 
// $ttlPopDescription .= htmlspecialchars("[%subject%] hxl:method \"[%method%]\" .") . "<br /><br />";

//echo $ttlPopDescription;

$curlDropOneContainer = "curl --user [%userPass%] --data-urlencode \"update= DROP GRAPH [%graph%]\" [%endPoint%]\n";
$curlDropOneEmergency = "curl --user [%userPass%] --data-urlencode \"update= DELETE
 { GRAPH ?a 
  { 
    ?a <http://hxl.humanitarianresponse.info/ns/#aboutEmergency> <http://hxl.humanitarianresponse.info/data/emergencies/demo1>
  } }\" [%endPoint%]";
 

?>