<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// require autoloader
require_once STOFF_PLUGIN_PATH . '/vendor/autoload.php';

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
    $list_of_color    = $data['list-of-color'] ?? '';
    $delivery_day     = $data['delivery-day'] ?? '';
    $delivery_month   = $data['delivery-month'] ?? '';
    $delivery_year    = $data['delivery-year'] ?? '';
    $orders_per_year  = $data['orders-per-year'] ?? '';
    $product          = $data['product'] ?? '';
    $fabric_finish    = $data['fabric-finishes'] ?? '';
    $desired_contents = $data['desired_contents'] ?? '';
    $anything_else    = $data['anything-else'] ?? '';

    // Check if any required field is empty
    if ( !empty ( $website ) && !empty ( $lanced ) && !empty ( $email ) && !empty ( $fabric ) && !empty ( $gsm ) && !empty ( $approx ) && !empty ( $target_from ) && !empty ( $target_to ) && !empty ( $list_of_color ) && !empty ( $delivery_day ) && !empty ( $delivery_month ) && !empty ( $delivery_year ) && !empty ( $orders_per_year ) && !empty ( $product ) && !empty ( $desired_contents ) ) {

        $mail = new PHPMailer( true );

        // get admin email
        $admin_email = get_option( 'admin_email' );

        try {

            // Set email parameters
            $mail->setFrom( $email, 'Mailer' );
            // $mail->addAddress( $admin_email, 'Recipient' );
            $mail->addAddress( 'rjshahjalal132@gmail.com', 'Recipient' );
            $mail->isHTML( true );
            // $mail->addAttachment( STOFF_PLUGIN_PATH . '/assets/images/Spinner.gif' );

            // Email subject
            $mail->Subject = "A new Stoff Market Inquiry came from $website";

            // Construct HTML for table
            $tableRows = "";
            $labels    = array( "Website", "Lanced", "Email", "Fabric", "GSM", "Approximate Quantity", "Target From", "Target To", "Lis of color(s)", "Delivery Date", "Orders Per Year", "Product", "Fabric Finish", "Desired Contents", "Anything else we should know?" );
            $values    = array( $website, $lanced, $email, $fabric, $gsm, $approx, $target_from, $target_to, $list_of_color, "$delivery_day/$delivery_month/$delivery_year", $orders_per_year, $product, $fabric_finish, $desired_contents, $anything_else );

            // Iterate through labels and values to construct table rows
            for ( $i = 0; $i < count( $labels ); $i++ ) {
                $tableRows .= "<tr><td><strong>$labels[$i]:</strong></td><td>$values[$i]</td></tr>";
            }

            // HTML message body
            $mail->Body = "
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
                            color: #fff;
                            background-color: #fac83e;
                            text-align: center;
                            padding: 10px;
                            margin-bottom: 10px;
                        }
                        table {
                            width: 100%;
                        }
                        table tr td {
                            padding: 5px;
                            border-bottom: 1px solid #ddd;
                        }
                        table tr td:first-child {
                            font-weight: bold;
                            width: 30%;
                        }
                    </style>
                </head>
                <body>
                    <div class='container'>
                        <h2>Stoff Market Inquiry Details</h2>
                        <table>
                            <tbody>
                                $tableRows
                            </tbody>
                        </table>
                    </div>
                </body>
                </html>";

            // Send email
            $mail->send();
            echo 'Mail sent successfully';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        echo 'Form data is incomplete';
    }
}