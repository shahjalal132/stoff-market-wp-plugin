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

        // get admin email
        $admin_email = get_option( 'admin_email' );

        // Email sending
        // $to      = $admin_email;
        $to      = 'rjshahjalal132@gmail.com'; // Change this to your email address
        $subject = "A new Stoff Market Inquiry came from $website";

        // Construct HTML for table
        $tableRows = "";
        $labels    = array( "Website", "Lanced", "Email", "Fabric", "GSM", "Approximate Quantity", "Target From", "Target To", "Lis of color(s)", "Delivery Date", "Orders Per Year", "Product", "Fabric Finish", "Desired Contents", "Anything else we should know?" );
        $values    = array( $website, $lanced, $email, $fabric, $gsm, $approx, $target_from, $target_to, $list_of_color, "$delivery_day/$delivery_month/$delivery_year", $orders_per_year, $product, $fabric_finish, $desired_contents, $anything_else );

        // Iterate through labels and values to construct table rows
        for ( $i = 0; $i < count( $labels ); $i++ ) {
            $tableRows .= "<tr><td><strong>$labels[$i]:</strong></td><td>$values[$i]</td></tr>";
        }

        // Boundary
        $semi_rand     = md5( time() );
        $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";

        // Message body
        $message = "--{$mime_boundary}\r\n";
        $message .= "Content-Type: text/html; charset=UTF-8\r\n";
        $message .= "Content-Transfer-Encoding: 7bit\r\n\r\n";

        // HTML content
        $message .= "<html lang='en'><head><meta charset='UTF-8'><title>Stoff Market Inquiry</title><style>/* Inline CSS */body {font-family: Arial, sans-serif;line-height: 1.6;background-color: #f4f4f4;padding: 20px;}.container {max-width: 600px;margin: auto;background: #fff;padding: 20px;border-radius: 5px;}h2 {color: #fff;background-color: #fac83e;text-align: center;padding: 10px;margin-bottom: 10px;}table {width: 100%;}table tr td {padding: 5px;border-bottom: 1px solid #ddd;}table tr td:first-child {font-weight: bold;width: 30%;}</style></head><body><div class='container'><h2>Stoff Market Inquiry Details</h2><table><tbody>$tableRows</tbody></table></div></body></html>\r\n\r\n";

        // Attachments handling
        if ( isset ( $_FILES['fileInput'] ) && $_FILES['fileInput']['error'] == UPLOAD_ERR_OK ) {
            $file_tmp  = $_FILES['fileInput']['tmp_name'];
            $file_name = $_FILES['fileInput']['name'];

            // Read file data
            $file_data = file_get_contents( $file_tmp );

            // Encode file data
            $file_data_encoded = chunk_split( base64_encode( $file_data ) );

            // Set attachment headers
            $attachment_headers = "Content-Type: application/octet-stream\r\n";
            $attachment_headers .= "Content-Transfer-Encoding: base64\r\n";
            $attachment_headers .= "Content-Disposition: attachment; filename=\"$file_name\"\r\n";

            // Add attachment to message
            $message .= "--{$mime_boundary}\r\n";
            $message .= $attachment_headers;
            $message .= $file_data_encoded . "\r\n";
        }

        // Send email
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "From: $email \r\n";
        $headers .= "Content-Type: multipart/mixed;\r\n";
        $headers .= " boundary=\"$mime_boundary\"";

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