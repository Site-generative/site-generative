<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$to = 'info@site-generative.com';
// Sanitize and validate input
$contact = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);

if ($contact && $message) {
    // Set up the email parameters
    $subject = 'New message from contact form';
    $headers = 'From: ' . $contact . "\r\n" .
               'Reply-To: ' . $contact . "\r\n" .
               'X-Mailer: PHP/' . phpversion();

    // Send the email
    if (mail($to, $subject, $message, $headers)) {
        // Email sent successfully
        $response = array('status' => 'success', 'message' => 'Email sent successfully.');
    } else {
        // Failed to send email
        $response = array('status' => 'error', 'message' => 'Failed to send email.');
    }
} else {
    // Invalid input
    $response = array('status' => 'error', 'message' => 'Invalid input.');
}

// Return the response as JSON
header('Content-Type: application/json');
echo json_encode($response);
?>