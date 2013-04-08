<?php
// Use sessions.
session_start();

// If we have an assertion to verify, assume this is a login request.
if (isset($_POST['assertion'])) {
	// Get a JSON response from the Persona verifier
	$jsonResult = verify_assertion($_POST['assertion']);
include('../../includes/JSON.php');
$json = new Services_JSON;

	// Parse the JSON.
	$parsedResult = $json->decode($jsonResult);

	// If the assertion is valid.
	if ($parsedResult->status === 'okay') {
		// Set the session's user property to the verified email.
	//	$_SESSION['user'] = $parsedResult->email;
		include('../../includes/sql-jperetz.php');
		$selectuser = $mysqli->query("select * from student where email ='".$parsedResult->email."'");
		print($mysqli->error);
		if ($selectuser->num_rows > 0) {
			$_SESSION['user'] = $selectuser->fetch_assoc();	
			var_dump($_SESSION['user']);		
		}
		$mysqli->close();
		
		
		
	}

	// Print the original JSON verifier response as the response body.
	print $jsonResult;
// Otherwise, assume this is a logout request.
} else {
	session_destroy();
}


// Persona assertion verifier.
// Code taken from the BrowserId Cookbook
// https://github.com/mozilla/browserid-cookbook
function verify_assertion($assertion, $cabundle = NULL) {
	$audience = (empty($_SERVER['HTTPS']) ? 'http://' : 'https://') . $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'];
	print($audience);
	$postdata = 'assertion=' . urlencode($assertion) . '&audience=' . urlencode($audience);

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "https://verifier.login.persona.org/verify");
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
	if (substr(PHP_OS, 0, 3) == 'WIN') {
		if (!isset($cabundle)) {
			$cabundle = dirname(__FILE__).DIRECTORY_SEPARATOR.'cabundle.crt';
		}
		curl_setopt($ch, CURLOPT_CAINFO, $cabundle);
	}
	$json = curl_exec($ch);
	curl_close($ch);

	return $json;
}
?>