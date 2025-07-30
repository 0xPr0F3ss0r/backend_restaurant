<?php
function sendEmail($to, $toname, $title, $body, $passcode, $succesMessaeg = "sign up succefully", $errorMessage = "fail")
{

    // --- Email.js API Credentials (REPLACE WITH YOURS) ---
    $service_id = 'service_wwzj1lc'; // e.g., service_xxxxxx
    $template_id = 'template_dsupjr8'; // e.g., template_xxxxxx
    $public_key = 'jSNlWBJZsQs-jNNCI'; // User ID, e.g., user_xxxxxx
    $private_key = 'B4T9IpvVKUK5o8DcA2ksF'; // Private Key (KEEP THIS SECRET!)

    // --- Email Data (REPLACE WITH YOUR DYNAMIC DATA) ---
    $to_name = $toname ?? 'User'; // Fallback to 'User' if $toname is not set
    $to_email = $to;
    $from_name = 'RestaurantApp';
    $message = $body;

    // Prepare template_params and other data as required by your Email.js template
    // $template_params = [
    //     'user_email' => $to_email,   // This tells EmailJS who the recipient is
    //     'to_name' => $to_name,        // Used to personalize the content
    //     'from_name' => $from_name,
    //     'message' => $message,
    // ];

    $template_params = [
        'to_name' => $to_name,
        'email' => $to_email, // This is often used by Email.js service itself for 'To' address
        'from_name' => "RestaurantApp",
        'message' => $message,
        'passcode' => $passcode,
        'Company Name' => 'RestaurantApp', // Add your company name or any other static data
        // Add any other variables your Email.js template expects (e.g., 'user_email', 'order_id')
    ];

    // Construct the payload for the Email.js API
    $payload = [
        'service_id' => $service_id,
        'template_id' => $template_id,
        'user_id' => $public_key, // This is your User ID / Public Key
        'template_params' => $template_params,
        'accessToken' => $private_key, // Authenticate with your private key
    ];

    $json_payload = json_encode($payload);

    // Email.js API endpoint
    $api_url = 'https://api.emailjs.com/api/v1.0/email/send';

    // Initialize cURL
    $ch = curl_init($api_url);

    // Set cURL options
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return the response as a string
    curl_setopt($ch, CURLOPT_POST, true);           // Set as POST request
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json_payload); // Set the JSON payload
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Content-Length: ' . strlen($json_payload)
    ]);

    // Execute cURL request
    $response = curl_exec($ch);
    // Check for cURL errors
    if (curl_errno($ch)) {
        $error_msg = curl_error($ch);
        // error_log("Email.js cURL error: " . $error_msg);
        //echo "Error sending email: " . $error_msg;
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
