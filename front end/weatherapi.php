<?php

include __DIR__.'/config.php';

header('Content-Type: application/json');
$q='Hong Kong';
if(isset($_REQUEST['q'])){
	$q=$_REQUEST['q'];
}

echo json_encode( getWeatherApi($q) );

die();

?>