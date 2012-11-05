<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/*
// ok 
curl  --user 257e:2rSBs5GTga --data-urlencode "update= prefix rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#> prefix hxl: <http://hxl.humanitarianresponse.info/ns/#> INSERT DATA { GRAPH <http://hxl.humanitarianresponse.info/data/datacontainers/777> { <http://hxl.humanitarianresponse.info/data/RefugeesAsylumSeekers/NGR/Gaoudel/Mali/male/ages_0-4> rdf:type hxl:RefugeesAsylumSeekers } }" http://hxl.humanitarianresponse.info/update

// ok
curl  --user 257e:2rSBs5GTga --data-urlencode "update= DROP GRAPH <http://hxl.humanitarianresponse.info/data/datacontainers/777>" http://hxl.humanitarianresponse.info/update
*/


sparqlLoad();


function sparqlLoad()
{
    $username = "257e";
    $password = "2rSBs5GTga";
    $endpoint = 'http://hxl.humanitarianresponse.info/update';
    
    $query = ' prefix rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#> prefix hxl: <http://hxl.humanitarianresponse.info/ns/#> INSERT DATA { GRAPH <http://hxl.humanitarianresponse.info/data/datacontainers/777> { <http://hxl.humanitarianresponse.info/data/RefugeesAsylumSeekers/NGR/Gaoudel/Mali/male/ages_0-4> rdf:type hxl:RefugeesAsylumSeekers } }'; 
    $parameterString = "update=" . urlencode( $query );   
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
    curl_setopt($ch, CURLOPT_URL, $endpoint);
    //curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/sparql-results+json'));
    //curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/sparql-results+xml,application/xml;q=0.8' ));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $parameterString);
 
    $response = curl_exec($ch);
    curl_close($ch);

 		//$results = json_decode($response, true);

    print_r('<pre>');
    print_r($parameterString);
    print_r($response);
    print_r('</pre>');
   
}

?>
