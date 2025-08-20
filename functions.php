<?php
function sendEmail($to, $toname, $title, $body, $passcode, $succesMessaeg = "sign up succefully", $errorMessage = "fail")
{

    // --- Email.js API Credentials (REPLACE WITH YOURS) ---
    $service_id = 'service_wwzj1lc'; 
    $template_id = 'template_dsupjr8'; 
    $public_key = 'jSNlWBJZsQs-jNNCI'; 
    $private_key = ''; 

    // --- Email Data (REPLACE WITH YOUR DYNAMIC DATA) ---
    $to_name = $toname ?? 'User'; 
    $to_email = $to;
    $from_name = 'RestaurantApp';
    $message = $body;

   => $message,    // ];

    $template_params = [
        'to_name' => $to_name,
        'email' => $to_email, 
        'from_name' => "RestaurantApp",
        'message' => $message,
        'passcode' => $passcode,
        'Company Name' => 'RestaurantApp', /

    ];

    // Construct the payload for the Email.js API
    $payload = [
        'service_id' => $service_id,
        'template_id' => $template_id,
        'user_id' => $public_key, 
        'template_params' => $template_params,
        'accessToken' => $private_key, 
    ];

    $json_payload = json_encode($payload);

    // Email.js API endpoint
    $api_url = 'https://api.emailjs.com/api/v1.0/email/send';

    // Initialize cURL
    $ch = curl_init($api_url);

    // Set cURL options
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
    curl_setopt($ch, CURLOPT_POST, true);          
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json_payload); 
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Content-Length: ' . strlen($json_payload)
    ]);

    // Execute cURL request
    $response = curl_exec($ch);
    // Check for cURL errors
    if (curl_errno($ch)) {
        $error_msg = curl_error($ch);
        result($error_msg, "sign up succefully", "fail");
    } else {
        // Get HTTP status code
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        // Process the response
        if ($http_code == 200) {
            result($http_code, $succesMessaeg, $errorMessage);
        } else {
            result($http_code, $succesMessaeg, $errorMessage);
            error_log("Email.js API error (HTTP $http_code): " . $response);
        }
    }

    // Close cURL session
    curl_close($ch);
}
