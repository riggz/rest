<?php
require_once ('new.php');
// create a new cURL resource
$uniData = curl_init();

// set URL and other appropriate options
curl_setopt($uniData, CURLOPT_URL, "http://www.example.com/");
curl_setopt($uniData, CURLOPT_HEADER,true);

// grab URL and pass it to the browser
curl_exec($uniData);
json_encode($uniData);
// close cURL resource, and free up system resources


$result = getUrl('http://localhost/rest/brand.html');
$result = json_encode($result,JSON_PRETTY_PRINT );
echo $result;


function deliver_response($status,$status_message,$data)	
{	
	header("HTTP/1.1 $status $status_message");
	$response['status']=$status;
	$response['status_message'] =$status_message;
	$reponse['data']=$data;
	
	$json =json_encode($response);
	echo$json;
	}


?>

