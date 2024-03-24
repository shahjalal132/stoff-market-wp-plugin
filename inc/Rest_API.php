<?php

// Check if form data is empty
if ( !empty ( $_POST ) ) {
    $data = $_POST;

    $website          = $data['website'] ?? '';
    $launched         = $data['lanced'] ?? '';
    $launched         = $data['lanced'] ?? '';
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
    $fabric_design    = $data['fabric_design'] ?? '';

    // Check if any required field is empty
    if ( !empty ( $website ) && !empty ( $email ) ) {

        try {

            // Construct HTML for table
            $tableRows = "";
            $labels    = array( "Website", "Launched", "Email", "Fabric Structure", "Desired Contents", "Weight GSM", "How many yards do you approx need", "USD cost per yard", "List of color(s)", "Delivery Date", "Orders Per Year", "What’s the end product", "Fabric Finish", "Anything else we should know?" );

            // Construct array of values
            $values = array( $website, $launched, $email, $fabric, $desired_contents, $gsm, $approx, "$target_from -to- $target_to", $list_of_color, "$delivery_day - $delivery_month - $delivery_year", $orders_per_year, $product, $fabric_finish, $anything_else );

            // Iterate through labels and values to construct table rows
            for ( $i = 0; $i < count( $labels ); $i++ ) {
                $tableRows .= "<tr><td><strong>$labels[$i]:</strong></td><td>$values[$i]</td></tr>";
            }

            add_action( 'wp_loaded', function () use ($website, $tableRows, $fabric_design) {

                // check if the image is not empty and the file is valid image
                if ( !empty ( $fabric_design ) ) {
                    // Decode the base64 data
                    $image_data = base64_decode( preg_replace( '#^data:image/\w+;base64,#i', '', $fabric_design ) );
                    // generate a random name for the image
                    $random_number = rand( 100, 1000 );
                    $image_name    = 'stoff-market-' . time() . $random_number . '.png';

                    // Upload the image to WordPress
                    $upload = wp_upload_bits( $image_name, null, $image_data );
                    // Get the image URL
                    $image_url = $upload['url'];
                } else {
                    $image_url = '';
                }

                $to            = get_option( 'stoff-set-email' );
                $subject       = "A new Stoff Market Inquiry came from $website";
                $message       = "
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
                                <tr><td><strong>Fabric Design:</strong></td><td><a target=\"_blank\" href=\"$image_url\">Click here to view</a></td></tr>
                            </tbody>
                        </table>
                    </div>
                </body>
                </html>";

                $from          = "Stoff Market <info@stoffmarket.com>";
                $headers       = array ( 'Content-Type: text/html; charset=UTF-8' );
                $headers[]     = 'From: ' . $from;
                $attachments   = array ();
                $attachments[] = $image_url;

                // Send email
                \wp_mail( $to, $subject, $message, $headers, $attachments );
                
                echo 'Mail sent successfully';
            } );


        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$e->getMessage()}";
        }
    } else {
        echo 'Form data is incomplete';
    }
}