<?php
    ini_set( 'display_errors', 1 );
    error_reporting( E_ALL );
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

        echo 'Email: ' . $contact . '<br>' .
             'Message: ' . $message;
        // Send the email
        if (mail($to, $subject, $message, $headers)) {
            echo 'Email sent successfully.';
        } else {
            echo 'Failed to send email.';
        }
    } else {
        echo 'Invalid input.';
    }
    //echo '<br><a href="index.html">Back to contact form</a>';
    header('Location: ../index.html');
?>
