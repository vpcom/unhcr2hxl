<?php

/*******************************
 *
 *****************************/
function sparqlUpdate($query)
{
    global $storeConfig, $log;
    
    $parameterString = "update=" . urlencode( $query );   
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_USERPWD, $storeConfig['store_username'] . ':' . $storeConfig['store_password']);
    curl_setopt($ch, CURLOPT_URL, $storeConfig['store_endpoint']);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $parameterString);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Expect:"));
 
    $response = curl_exec($ch);
    curl_close($ch);

        //echo(strlen($response));
        
        // strlen($response) is 88 when success, 687 when failure
        
    if (strlen($response) < 200)
    {
        //$log->write("Insert first container: success");
        return true;
    }
    else
    {
        $log->write("Insert container: FAILED");
        
        print_r('<pre>');
        echo(htmlspecialchars(urldecode($parameterString)));
        print_r($response);
        print_r('</pre>');
        return false;
    }
}

/*******************************
 *
 *****************************/
function getQueryResults($query)
{
    try {
        $db = sparql_connect( "http://hxl.humanitarianresponse.info/sparql" );
        
        if( !$db ) {
            print $db->errno() . ": " . $db->error(). "\n"; exit;
        }
        $result = $db->query($query);
        if( !$result ) {
            print $db->errno() . ": " . $db->error(). "\n"; exit;
        }

    } catch (Exception $e) {
        echo 'Caught exception: ',  $e->getMessage(), "\n";
    }
    return $result;
}

?>