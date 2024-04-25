<?php
    ini_set('display_errors', 'Off');
    error_reporting(0);

    $secretKey = "6LeCTscpAAAAADonfgLL_d0a-gB5YCi2IsCStkQg";
    $postData = $valErr = $statusMsg = "";
    $status = "error";

    $to = 'info@site-generative.com';
    $contact = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $message = $_POST['message'];

    if (empty($contact) || !filter_var($contact, FILTER_VALIDATE_EMAIL)) {
        $valErr = "Prosím zadejte platný e-mail.";
    } else {
        $postData = $_POST;
    }

    if (empty($valErr) && !empty($postData)) {
        if (isset($_POST['g-recaptcha-response'])) {
            $api_url = "https://www.google.com/recaptcha/api/siteverify";
            $resq_data = array('secret' => $secretKey, 'response' => $_POST['g-recaptcha-response'], 'remoteip' => $_SERVER['REMOTE_ADDR']);

            $curlConfig = array(
                CURLOPT_URL => $api_url,
                CURLOPT_POST => true,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POSTFIELDS => $resq_data
            );

            $ch = curl_init();
            curl_setopt_array($ch, $curlConfig);
            $response = curl_exec($ch);
            curl_close($ch);

            $jsonResponse = json_decode($response);

            if ($jsonResponse->success) {
                if ($contact && $message) {
                    $subject = 'New message from contact form';
                    $headers = 'From: ' . $contact . "\r\n" .
                        'Reply-To: ' . $contact . "\r\n" .
                        'X-Mailer: PHP/' . phpversion();

                    if (mail($to, $subject, $message, $headers)) {
                        echo '<svg xmlns="http://www.w3.org/2000/svg" height="22px" width="22px" viewBox="0 0 512 512" class="mr-2"><path fill="#22c55e" d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM369 209L241 337c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L335 175c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z"/></svg><p class="text-green-500">E-mail byl úspěšně odeslán, brzy se vám ozveme.</p>';
                    } else {
                        echo '<svg xmlns="http://www.w3.org/2000/svg" height="22px" width="22px" viewBox="0 0 512 512" class="mr-2"><path fill="#ef4444" d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zm0-384c13.3 0 24 10.7 24 24V264c0 13.3-10.7 24-24 24s-24-10.7-24-24V152c0-13.3 10.7-24 24-24zM224 352a32 32 0 1 1 64 0 32 32 0 1 1 -64 0z"/></svg><p class="text-red-500">Nepodařilo se odeslat e-mail.</p>';
                    }
                }
            } else {
                $statusMsg = "Jste robot?";
            }
        } else {
            $statusMsg = "Něco se pokazilo";
        }
    } else {
        echo '<svg xmlns="http://www.w3.org/2000/svg" height="22px" width="22px" viewBox="0 0 512 512" class="mr-2"><path fill="#ef4444" d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zm0-384c13.3 0 24 10.7 24 24V264c0 13.3-10.7 24-24 24s-24-10.7-24-24V152c0-13.3 10.7-24 24-24zM224 352a32 32 0 1 1 64 0 32 32 0 1 1 -64 0z"/></svg><p class="text-red-500">' . $valErr . '</p>';
    }
