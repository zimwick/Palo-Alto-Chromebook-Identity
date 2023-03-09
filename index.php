<?php

// Check if a POST request was received
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  
  // Decode the JSON payload
  $payload = json_decode(file_get_contents('php://input'), true);

  // Extract the IP address and username from the payload
  $ip = $payload['ips'] ?? '';
  $username = $payload['username'] ?? '';

  // Check if IP address and username are not blank
  if ($ip !== '' && $username !== '') {

    // Create the XML string
    $xml = '<uid-message>
              <version>1.0</version>
              <type>update</type>
              <payload>
                <login>
                  <entry name="'.$username.'" ip="'.$ip.'" timeout="600">
				  </entry>
                </login>
              </payload>
            </uid-message>';

    // Create the cURL request
$url = 'https://<firewall ip>/api/?type=user-id';
$apiKey = '<palo alto generated api key here>';
$headers = array('key: ' . $apiKey);

$postfields = array(
    'file' => curl_file_create(
        'data://text/plain;base64,' . base64_encode($xml),
        'test.xml',
        'text/xml'
    ),
    'key' => $apiKey
);

	// Create the cURL request
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

	// Send the cURL request and capture the response and HTTP code
	$response = curl_exec($ch);
	$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	curl_close($ch);

    // Check if the POST request was successful
    if ($response !== false && $httpCode === 200) {
      // Send a response back to the client
      echo "Data received and logged successfully.";

      // Log the successful POST request with IP address, username, and HTTP response code
      $logMessage = date('Y-m-d H:i:s') . " - SUCCESS - IP: " . $ip . ", Username: " . $username . ", HTTP Response Code: " . $httpCode . "\n";
      file_put_contents('log.log', $logMessage, FILE_APPEND);
    } else {
      // If the POST request failed, send a 500 error
      http_response_code(500);
      echo "Internal Server Error";

      // Log the failed POST request with IP address, username, and HTTP response code
      $logMessage = date('Y-m-d H:i:s') . " - FAILURE - IP: " . $ip . ", Username: " . $username . ", HTTP Response Code: " . $httpCode . "\n";
      file_put_contents('log.log', $logMessage, FILE_APPEND);
    }
  }

} else {
  // If no POST request was received, send a 404 error
  http_response_code(404);
  echo "404 Not Found";
}
