<?php

// Check if form data is empty
if ( !empty ( $_POST ) ) {
    $data = $_POST;

    $website          = $data['website'] ?? '';
    $lanced           = $data['lanced'] ?? '';
    $email            = $data['email'] ?? '';
    $fabric           = $data['fabric'] ?? '';
    $gsm              = $data['gsm'] ?? '';
    $approx           = $data['approx'] ?? '';
    $target_from      = $data['target-from'] ?? '';
    $target_to        = $data['target-to'] ?? '';
    $delivery_day     = $data['delivery-day'] ?? '';
    $delivery_month   = $data['delivery-month'] ?? '';
    $delivery_year    = $data['delivery-year'] ?? '';
    $orders_per_year  = $data['orders-per-year'] ?? '';
    $product          = $data['product'] ?? '';
    $fabric_finish    = $data['fabric-finishes'] ?? '';
    $desired_contents = $data['desired_contents'] ?? '';

    // Check if any required field is empty
    if ( !empty ( $website ) && !empty ( $lanced ) && !empty ( $email ) && !empty ( $fabric ) && !empty ( $gsm ) && !empty ( $approx ) && !empty ( $target_from ) && !empty ( $target_to ) && !empty ( $delivery_day ) && !empty ( $delivery_month ) && !empty ( $delivery_year ) && !empty ( $orders_per_year ) && !empty ( $product ) && !empty ( $desired_contents ) ) {

        $to      = 'rjshahjalal132@gmail.com'; // Change this to your email address
        $subject = "A new Stoff Market Inquiry came from $website";

        // Merge all data into $message
        $message = "
            <!DOCTYPE html>
            <html lang='en'>
            <head>
                <meta charset='UTF-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <title>Stoff Market Inquiry</title>
                <style>
                    /* Inline CSS */
                    body {
                        font-family: Arial, sans-serif;
                        line-height: 1.6;
                        background-color: #f4f4f4;
                        padding: 20px;
                    }
                    .container {
                        max-width: 600px;
                        margin: auto;
                        background: #fff;
                        padding: 20px;
                        border-radius: 5px;
                    }
                    h2 {
                        color: #333;
                    }
                    p {
                        margin: 0 0 10px;
                    }
                    .data-label {
                        font-weight: bold;
                    }
                </style>
            </head>
            <body>
                <div class='container'>
                    <h2>Stoff Market Inquiry Details</h2>
                    <p><span class='data-label'>Website:</span> $website</p>
                    <p><span class='data-label'>Lanced:</span> $lanced</p>
                    <p><span class='data-label'>Email:</span> $email</p>
                    <p><span class='data-label'>Fabric:</span> $fabric</p>
                    <p><span class='data-label'>GSM:</span> $gsm</p>
                    <p><span class='data-label'>Approximate Quantity:</span> $approx</p>
                    <p><span class='data-label'>Target From:</span> $target_from</p>
                    <p><span class='data-label'>Target To:</span> $target_to</p>
                    <p><span class='data-label'>Delivery Date:</span> $delivery_day/$delivery_month/$delivery_year</p>
                    <p><span class='data-label'>Orders Per Year:</span> $orders_per_year</p>
                    <p><span class='data-label'>Product:</span> $product</p>
                    <p><span class='data-label'>Fabric Finish:</span> $fabric_finish</p>
                    <p><span class='data-label'>Desired Content:</span> $desired_contents</p>
                </div>
            </body>
            </html>
        ";

        // Set headers for HTML email
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

        // Additional headers
        $headers .= "From: $email \r\n";

        // Send email
        $mailSend = mail( $to, $subject, $message, $headers );

        if ( $mailSend ) {
            echo 'Mail sent successfully';
        } else {
            echo 'Mail not sent';
        }
    } else {
        echo 'Form data is incomplete';
    }
}